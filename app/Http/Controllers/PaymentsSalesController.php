<?php

namespace App\Http\Controllers;

use App\Models\PaymentsSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //agrega y actualizar el balance en la cuenta por cobrar
        try {
            // Validate the request data
            $request->validate([
                'account_receivable_id' => 'required|exists:accounts_receivable,id',
                'payment_amount' => 'required|numeric|min:0.01',
                'payment_date' => 'required|date',
                'payment_method_id' => 'required',
                'reference' => 'nullable|string'
            ]);

            // Begin transaction
            \DB::beginTransaction();

            // Get the accounts receivable record
            $accountReceivable = \App\Models\AccountsReceivable::findOrFail($request->account_receivable_id);
            
            // Check if payment amount is valid
            if ($request->payment_amount > $accountReceivable->balance) {
                return response()->json([
                    'success' => false,
                    'message' => 'El monto del pago no puede ser mayor que el saldo pendiente'
                ], 400);
            }

            // Create new payment record
            $payment = new PaymentsSales();
            $payment->account_receivable_id = $request->account_receivable_id;
            $payment->payment_amount = $request->payment_amount;
            $payment->payment_date = $request->payment_date;
            $payment->payment_method_id = $request->payment_method_id;
            $payment->reference = $request->reference;
            $payment->created_by = Auth::id();
            $payment->company_id = Auth::user()->company_id;
            $payment->is_delete = 0;
            $payment->save();
            // insertar el movimiento y actualizar el saldo de la caja si el pago es efectivo
          
            // actualizar el estado de la cuenta por pagar
            $pagadoState = \App\Models\AccountStates::where('name', 'Pagado')->first(); // or use a unique code

            if ($pagadoState) {
                // Check if balance is zero or less
                if ($accountReceivable->balance <= 0) {
                    $accountReceivable->account_statuses_id = $pagadoState->id;
                } else {
                    //If you want to update to a partially paid state.
                    $parcialState = \App\Models\AccountStates::where('name', 'Parcialmente Pagado')->first();
                    if($parcialState){
                        $accountReceivable->account_statuses_id = $parcialState->id;
                    }
                }
            }
          
            $accountReceivable->save();

            // Commit transaction
            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago registrado correctamente',
                'payment_id' => $payment->id
            ]);

        } catch (\Exception $e) {
            // Rollback transaction on error
            \DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el pago: ' . $e->getMessage()
            ], 500);
        }
    }

  /**
 * Get payment history for an account receivable
 * 
 * @param int $id Account receivable ID
 * @return \Illuminate\Http\JsonResponse
 */
public function getPaymentHistory($id)
{
    try {
        // Get all payments for this account receivable with related data
        $payments = PaymentsSales::with(['payment_method', 'user'])
            ->where('account_receivable_id', $id)
            ->where('is_delete', 0)
            ->orderBy('payment_date', 'desc')
            ->get();
            
        return response()->json($payments);
    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => 'Error fetching payment history: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(PaymentsSales $paymentsSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentsSales $paymentsSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentsSales $paymentsSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentsSales $paymentsSales)
    {
        //
    }
}
