<?php

namespace App\Http\Controllers;

use App\Models\AccountsReceivable;
use App\Models\Companies;
use App\Models\PaymentMethodModel;

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
        // Debug: Check if there are any accounts receivable
        $accountsCount = AccountsReceivable::where('is_delete', 0)->count();
        Log::info('Total accounts receivable in database: ' . $accountsCount);

        $data['paymentMethods'] = PaymentMethodModel::where('is_delete', '=', 0)->get();
        $data['accountsCount'] = $accountsCount; // Pass count to view for debugging

        return view('admin.accounts_receivable.list', $data);
    }

    /**
     * Simple method to get accounts without relations for debugging
     */
    public function getAccountsSimple()
    {
        try {
            $accounts = AccountsReceivable::where('is_delete', 0)->get();

            $simpleAccounts = $accounts->map(function ($account) {
                return [
                    'id' => $account->id,
                    'date_of_issue' => $account->date_of_issue,
                    'date_of_due' => $account->date_of_due,
                    'total_amount' => $account->total_amount,
                    'customer_id' => $account->customer_id,
                    'sale_id' => $account->sale_id,
                    'account_statuses_id' => $account->account_statuses_id,
                    'customers' => ['name' => 'Cliente ' . $account->customer_id],
                    'sales' => ['invoice_no' => 'INV-' . $account->sale_id],
                    'account_states' => ['name' => 'Pendiente'],
                    'payments' => [],
                    'total_paid' => 0,
                    'balance' => $account->total_amount,
                    'calculated_status' => 'Pendiente'
                ];
            });

            return response()->json($simpleAccounts);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all accounts receivable data for AJAX request
     */
    public function getAccountsReceivable()
    {
        try {
            // Debug: Log the query
            Log::info('Fetching accounts receivable data');

            $accounts = AccountsReceivable::with([
                'customers',
                'accountStates',
                'sales',
                'payments' => function ($query) {
                    $query->where('is_delete', 0);
                }
            ])
                ->where('is_delete', 0)
                ->orderBy('date_of_due', 'asc')
                ->get();

            Log::info('Found ' . $accounts->count() . ' accounts receivable');

            // Transform data for frontend
            $transformedAccounts = $accounts->map(function ($account) {
                // Verificar si las relaciones existen
                if (!$account->customers) {
                    Log::warning('Account ' . $account->id . ' has no customer relation');
                    return null;
                }

                if (!$account->sales) {
                    Log::warning('Account ' . $account->id . ' has no sales relation');
                    return null;
                }

                if (!$account->accountStates) {
                    Log::warning('Account ' . $account->id . ' has no accountStates relation');
                    return null;
                }

                // Calcular totales
                $totalPaid = $account->payments->sum('payment_amount');
                $balance = $account->total_amount - $totalPaid;

                return [
                    'id' => $account->id,
                    'date_of_issue' => $account->date_of_issue,
                    'date_of_due' => $account->date_of_due,
                    'total_amount' => $account->total_amount,
                    'customers' => [
                        'name' => $account->customers->name ?? 'N/A'
                    ],
                    'sales' => [
                        'invoice_no' => $account->sales->invoice_no ?? 'N/A'
                    ],
                    'account_states' => [
                        'name' => $account->accountStates->name ?? 'Pendiente'
                    ],
                    'payments' => $account->payments,
                    'total_paid' => $totalPaid,
                    'balance' => $balance,
                    'calculated_status' => $balance <= 0 ? 'Pagado' : ($totalPaid > 0 ? 'Parcial' : 'Pendiente')
                ];
            })->filter(); // Remove null values

            return response()->json($transformedAccounts->values());
        } catch (\Exception $e) {
            Log::error('Error fetching accounts receivable: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => true,
                'message' => 'Error fetching accounts receivable: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
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
                'payments' => function ($query) {
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

    /**
     * Test method to check data structure
     */
    public function testData()
    {
        try {
            // Get raw data without relations
            $rawAccounts = AccountsReceivable::where('is_delete', 0)->get();

            // Test each relation individually
            $testResults = [];

            foreach ($rawAccounts as $account) {
                $testResult = [
                    'account_id' => $account->id,
                    'customer_id' => $account->customer_id,
                    'sale_id' => $account->sale_id,
                    'account_statuses_id' => $account->account_statuses_id,
                ];

                // Test customer relation
                try {
                    $customer = $account->customers;
                    $testResult['customer_exists'] = $customer ? true : false;
                    $testResult['customer_name'] = $customer ? $customer->name : null;
                } catch (\Exception $e) {
                    $testResult['customer_error'] = $e->getMessage();
                }

                // Test sales relation
                try {
                    $sale = $account->sales;
                    $testResult['sale_exists'] = $sale ? true : false;
                    $testResult['invoice_no'] = $sale ? $sale->invoice_no : null;
                } catch (\Exception $e) {
                    $testResult['sale_error'] = $e->getMessage();
                }

                // Test account states relation
                try {
                    $state = $account->accountStates;
                    $testResult['state_exists'] = $state ? true : false;
                    $testResult['state_name'] = $state ? $state->name : null;
                } catch (\Exception $e) {
                    $testResult['state_error'] = $e->getMessage();
                }

                $testResults[] = $testResult;
            }

            return response()->json([
                'total_accounts' => $rawAccounts->count(),
                'raw_accounts' => $rawAccounts->toArray(),
                'relation_tests' => $testResults,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Generate payment history ticket PDF
     */
    public function printPaymentTicket($id)
    {
        try {
            // Get account receivable with payments
            $accountReceivable = AccountsReceivable::with([
                'customers',
                'sales',
                'payments' => function ($query) {
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

            // Generate PDF with ticket view
            $pdf = PDF::loadView('admin.accounts_receivable.payment_ticket', [
                'accountReceivable' => $accountReceivable,
                'company' => $company,
                'totalPaid' => $totalPaid,
                'remainingBalance' => $remainingBalance,
                'currentDate' => now()->format('d/m/Y'),
                'currentTime' => now()->format('H:i:s')
            ]);

            // Set PDF options for ticket format
            $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait'); // 80mm width
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'margin_top' => 5,
                'margin_bottom' => 5,
                'margin_left' => 5,
                'margin_right' => 5,
            ]);

            // Generate filename
            $filename = 'ticket_pagos_' . $accountReceivable->sales->invoice_no . '.pdf';

            // Return PDF for download or display
            return $pdf->stream($filename);
        } catch (\Exception $e) {
            Log::error('Error generating payment ticket PDF: ' . $e->getMessage());
            return back()->with('error', 'Error al generar el ticket: ' . $e->getMessage());
        }
    }
}
