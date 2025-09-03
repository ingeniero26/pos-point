<?php

namespace App\Http\Controllers;

use App\Models\AccountsReceivable;
use App\Models\Companies;
use App\Models\PaymentMethodModel;
use App\Models\PaymentsSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Log;

class AccountsReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        $data['paymentMethods'] = PaymentMethodModel::where('is_delete','=',0)->get();
        return view('admin.accounts_receivable.list', $data);
    }
    
    /**
     * Get all accounts receivable data for AJAX request
     */
    public function getAccountsReceivable()
    {
        try {
            $accounts = AccountsReceivable::with([
                'customers', 
                'accountStates', 
                'sales',
                'payments' => function($query) {
                    $query->where('is_delete', 0);
                }
            ])
            ->where('is_delete', 0)
            ->orderBy('date_of_due', 'asc')
            ->get();
            
            // Agregar los campos calculados a cada cuenta
            $accounts->each(function ($account) {
                $account->total_paid = $account->total_paid;
                $account->balance = $account->balance;
                $account->calculated_status = $account->calculated_status;
            });
            
            return response()->json($accounts);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error fetching accounts receivable: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
 * Generate PDF for accounts receivable with payment details
 *
 * @param int $id Account receivable ID
 * @return \Illuminate\Http\Response
 */
public function printPdf($id)
{
    try {
        // Get account receivable with related data
        $accountReceivable = AccountsReceivable::with([
            'customers', 
            'sales', 
            'payments' => function($query) {
                $query->with(['payment_method', 'user'])
                    ->where('is_delete', 0)
                    ->orderBy('payment_date', 'desc');
            }
        ])->findOrFail($id);
        
        // Get company information
        $company = Companies::where('id', Auth::user()->company_id)->first();
        
        // Calculate totals
        $totalPaid = $accountReceivable->payments->sum('payment_amount');
        $remainingBalance = $accountReceivable->total_amount - $totalPaid;
        
        // Format dates
        $issueDate = Carbon::parse($accountReceivable->date_of_issue)->format('d/m/Y');
        $dueDate = Carbon::parse($accountReceivable->due_date)->format('d/m/Y');
        
        // Generate PDF with view
        $pdf = PDF::loadView('admin.accounts_receivable.pdf', [
            'accountReceivable' => $accountReceivable,
            'company' => $company,
            'issueDate' => $issueDate,
            'dueDate' => $dueDate,
            'totalPaid' => $totalPaid,
            'remainingBalance' => $remainingBalance
        ]);
        
        // Set PDF options for a professional look
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);
        
        // Generate filename
        $filename = 'cuenta_por_cobrar_' . $accountReceivable->invoice_no . '.pdf';
        
        // Return PDF for download or display
        return $pdf->stream($filename);
        
    } catch (\Exception $e) {
        // Log error and return with error message
        Log::error('Error generating accounts receivable PDF: ' . $e->getMessage());
        return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
    }
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
   

    /**
     * Display the specified resource.
     */
    public function show(AccountsReceivable $accountsReceivable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountsReceivable $accountsReceivable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountsReceivable $accountsReceivable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountsReceivable $accountsReceivable)
    {
        //
    }

    /**
     * Update account status based on payments
     */
    public function updateAccountStatus($accountReceivableId)
    {
        try {
            $account = AccountsReceivable::findOrFail($accountReceivableId);
            
            // Calcular el balance actual
            $totalPaid = $account->payments()->sum('payment_amount');
            $balance = $account->total_amount - $totalPaid;
            
            // Determinar el nuevo estado
            if ($balance <= 0) {
                // Completamente pagado
                $newStatusId = 3; // Asumiendo que 3 es "Pagado"
            } elseif ($totalPaid > 0) {
                // Pago parcial
                $newStatusId = 2; // Asumiendo que 2 es "Parcial"
            } else {
                // Sin pagos
                $newStatusId = 1; // Asumiendo que 1 es "Pendiente"
            }
            
            // Actualizar el estado
            $account->update(['account_statuses_id' => $newStatusId]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error updating account status: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Recalculate all account balances and update statuses
     */
    public function recalculateAllBalances()
    {
        try {
            $accounts = AccountsReceivable::where('is_delete', 0)->get();
            
            foreach ($accounts as $account) {
                $this->updateAccountStatus($account->id);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Balances recalculados exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al recalcular balances: ' . $e->getMessage()
            ], 500);
        }
    }
}
