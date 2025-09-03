<?php

namespace App\Http\Controllers;

use App\Models\PaymentsSales;
use App\Models\AccountsReceivable;
use App\Models\PaymentMethodModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentsSalesController extends Controller
{
    /**
     * Store a new payment for accounts receivable
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos de entrada
            $request->validate([
                'account_receivable_id' => 'required|exists:accounts_receivable,id',
                'payment_amount' => 'required|numeric|min:0.01',
                'payment_date' => 'required|date',
                'payment_method_id' => 'required|exists:payment_method,id',
                'reference' => 'nullable|string|max:255'
            ]);

            DB::beginTransaction();

            // Obtener la cuenta por cobrar
            $accountReceivable = AccountsReceivable::findOrFail($request->account_receivable_id);
            
            // Calcular el balance actual
            $totalPaid = $accountReceivable->payments()->sum('payment_amount');
            $currentBalance = $accountReceivable->total_amount - $totalPaid;
            
            // Validar que el monto no exceda el balance
            if ($request->payment_amount > $currentBalance) {
                return response()->json([
                    'success' => false,
                    'message' => 'El monto del pago no puede ser mayor al saldo pendiente'
                ], 400);
            }

            // Crear el pago
            $payment = PaymentsSales::create([
                'account_receivable_id' => $request->account_receivable_id,
                'payment_amount' => $request->payment_amount,
                'payment_date' => $request->payment_date,
                'payment_method_id' => $request->payment_method_id,
                'reference' => $request->reference,
                'created_by' => Auth::id(),
                'company_id' => Auth::user()->company_id,
                'is_delete' => 0
            ]);

            // Actualizar el estado de la cuenta por cobrar
            $newBalance = $currentBalance - $request->payment_amount;
            
            if ($newBalance <= 0) {
                // Completamente pagado
                $accountReceivable->update(['account_statuses_id' => 3]);
            } elseif ($totalPaid + $request->payment_amount > 0) {
                // Pago parcial
                $accountReceivable->update(['account_statuses_id' => 2]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago registrado exitosamente',
                'payment' => $payment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el pago: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment history for an account receivable
     */
    public function getPaymentHistory($id)
    {
        try {
            $payments = PaymentsSales::with(['payment_method', 'user'])
                ->where('account_receivable_id', $id)
                ->where('is_delete', 0)
                ->orderBy('payment_date', 'desc')
                ->get();

            return response()->json($payments);

        } catch (\Exception $e) {
            Log::error('Error fetching payment history: ' . $e->getMessage());
            
            return response()->json([
                'error' => true,
                'message' => 'Error al obtener el historial de pagos'
            ], 500);
        }
    }

    /**
     * Get all payments for a specific account receivable
     */
    public function getPaymentsByAccount($accountReceivableId)
    {
        try {
            $payments = PaymentsSales::with(['payment_method', 'user'])
                ->where('account_receivable_id', $accountReceivableId)
                ->where('is_delete', 0)
                ->orderBy('payment_date', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'payments' => $payments
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching payments by account: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los pagos'
            ], 500);
        }
    }

    /**
     * Update payment
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'payment_amount' => 'required|numeric|min:0.01',
                'payment_date' => 'required|date',
                'payment_method_id' => 'required|exists:payment_methods,id',
                'reference' => 'nullable|string|max:255'
            ]);

            DB::beginTransaction();

            $payment = PaymentsSales::findOrFail($id);
            $oldAmount = $payment->payment_amount;
            
            $payment->update([
                'payment_amount' => $request->payment_amount,
                'payment_date' => $request->payment_date,
                'payment_method_id' => $request->payment_method_id,
                'reference' => $request->reference,
                'updated_by' => Auth::id()
            ]);

            // Recalcular el estado de la cuenta por cobrar
            $accountReceivable = $payment->accountReceivable;
            $totalPaid = $accountReceivable->payments()->sum('payment_amount');
            $balance = $accountReceivable->total_amount - $totalPaid;
            
            if ($balance <= 0) {
                $accountReceivable->update(['account_statuses_id' => 3]);
            } elseif ($totalPaid > 0) {
                $accountReceivable->update(['account_statuses_id' => 2]);
            } else {
                $accountReceivable->update(['account_statuses_id' => 1]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago actualizado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el pago'
            ], 500);
        }
    }

    /**
     * Delete payment (soft delete)
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $payment = PaymentsSales::findOrFail($id);
            $payment->update([
                'is_delete' => 1,
                'deleted_by' => Auth::id()
            ]);

            // Recalcular el estado de la cuenta por cobrar
            $accountReceivable = $payment->accountReceivable;
            $totalPaid = $accountReceivable->payments()->sum('payment_amount');
            $balance = $accountReceivable->total_amount - $totalPaid;
            
            if ($balance <= 0) {
                $accountReceivable->update(['account_statuses_id' => 3]);
            } elseif ($totalPaid > 0) {
                $accountReceivable->update(['account_statuses_id' => 2]);
            } else {
                $accountReceivable->update(['account_statuses_id' => 1]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el pago'
            ], 500);
        }
    }
}