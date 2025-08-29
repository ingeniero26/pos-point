<?php

namespace App\Http\Controllers;

use App\Models\AccountsPayableModel;
use App\Models\PaymentMethodModel;
use App\Models\PaymentsPurchasesModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class AccountsPayableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        $data['paymentMethods'] = PaymentMethodModel::where('is_delete','=',0)->get();
        return view('admin.accounts_payable.list', $data);
    }
    public function getAccountsPayable()
    {
        $purchase_accounts = AccountsPayableModel::where('is_delete','=',0)
       ->with(['purchases',
            'suppliers',
            'type_document',
            'company',
            'account_states',
            'currency'])
        ->orderBy('id','desc')
        ->get();
        return response()->json($purchase_accounts);
    }

    public function printPdf($id){
        // Obtener la cuenta por pagar con sus relaciones
    $account_payable = \App\Models\AccountsPayableModel::with([
        'suppliers',
        'account_states',
        'payments.paymentMethod' // Include payment history
    ])
    ->where('id', $id)
    ->firstOrFail();
    
    // Cargar la vista del PDF con los datos
    $pdf = PDF::loadView('admin.accounts_payable.pdf', compact('account_payable'));
    
    // Descargar el PDF
    return $pdf->download('Cuenta-' . $account_payable->id . '.pdf');
    }


    public function getPaymentDetails($id)
{
    try {
        // Obtener la cuenta por pagar con sus relaciones
        $accountPayable = \App\Models\AccountsPayableModel::with(['suppliers', 'account_states'])
            ->findOrFail($id);
            
        // Obtener los pagos relacionados con esta cuenta
        $payments = \App\Models\PaymentsPurchasesModel::with('paymentMethod')
            ->where('account_payable_id', $id)
            ->where('is_delete', 0)
            ->orderBy('payment_date', 'desc')
            ->get();
            
        return response()->json([
            'success' => true,
            'account_payable' => $accountPayable,
            'payments' => $payments
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener los detalles: ' . $e->getMessage()
        ], 500);
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
    public function store(Request $request)
    {
        dd($request->all());
        // agregar 
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountsPayableModel $accountsPayableModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountsPayableModel $accountsPayableModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountsPayableModel $accountsPayableModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountsPayableModel $accountsPayableModel)
    {
        //
    }
}
