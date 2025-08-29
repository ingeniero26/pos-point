<?php

namespace App\Http\Controllers;

use App\Models\PaymentsPurchasesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use DB;

class PaymentsPurchasesController extends Controller
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
        //agrega y actualizar el balance en la cuenta por pagar
        try {
            // Validate the request data
            $request->validate([
                'account_payable_id' => 'required|exists:accounts_payable,id',
                'payment_amount' => 'required|numeric|min:0.01',
                'payment_date' => 'required|date',
                'payment_method_id' => 'required',
                'reference' => 'nullable|string'
            ]);

            // Begin transaction
            \DB::beginTransaction();

            // Get the accounts payable record
            $accountPayable = \App\Models\AccountsPayableModel::findOrFail($request->account_payable_id);
            
            // Check if payment amount is valid
            if ($request->payment_amount > $accountPayable->balance) {
                return response()->json([
                    'success' => false,
                    'message' => 'El monto del pago no puede ser mayor que el saldo pendiente'
                ], 400);
            }

            // Create new payment record
            $payment = new PaymentsPurchasesModel();
            $payment->account_payable_id = $request->account_payable_id;
            $payment->payment_amount = $request->payment_amount;
            $payment->payment_date = $request->payment_date;
            $payment->payment_method_id = $request->payment_method_id;
            $payment->reference = $request->reference;
            $payment->created_by = Auth::id();
            $payment->company_id = Auth::user()->company_id;
            $payment->save();
            // realizar ingreso a la caja si el pago es efectivo
            
        
            // actualizar el estado de la cuenta por pagar
            $pagadoState = \App\Models\AccountStates::where('name', 'Pagado')->first(); // or use a unique code

            if ($pagadoState) {
                // Check if balance is zero or less
                if ($accountPayable->balance <= 0) {
                    $accountPayable->account_statuses_id = $pagadoState->id;
                } else {
                    //If you want to update to a partially paid state.
                    $parcialState = \App\Models\AccountStates::where('name', 'Parcialmente Pagado')->first();
                    if($parcialState){
                        $accountPayable->account_statuses_id = $parcialState->id;
                    }
                }
            }

          
            $accountPayable->save();

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

    // para imprimir 
   
    public function printPdf($id)
    {
        // Obtener el pago con sus relaciones
        $payment_purchase = PaymentsPurchasesModel::with([
            'accountsPayable.suppliers', // Include supplier information
            'paymentMethod',
            'company'
        ])
        ->where('id', $id)
        ->where('is_delete', 0)
        ->firstOrFail();
        
        // Get payment history for this account payable
        $payment_history = PaymentsPurchasesModel::where('account_payable_id', $payment_purchase->account_payable_id)
            ->where('is_delete', 0)
            ->with('paymentMethod') // Eager load payment method for each payment
            ->orderBy('payment_date', 'asc')
            ->get();
  
        // Cargar la vista del PDF con los datos del pago
        $viewPath = 'admin.payments_purchase_pdf.payment_purchase';
        if (!view()->exists($viewPath)) {
            // If view doesn't exist, try to find it or use a fallback
            $viewPath = 'admin.payments_purchase_pdf.payment_purchase';
            if (!view()->exists($viewPath)) {
                return response()->json(['error' => 'View template not found'], 404);
            }
        }
        $pdf = PDF::loadView($viewPath, compact('payment_purchase', 'payment_history'));
        
        // Descargar el PDF
        return $pdf->download('Pago-' . $payment_purchase->id . '.pdf');
    }


    /**
     * Display the specified resource.
     */
    public function show(PaymentsPurchasesModel $paymentsPurchasesModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentsPurchasesModel $paymentsPurchasesModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentsPurchasesModel $paymentsPurchasesModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentsPurchasesModel $paymentsPurchasesModel)
    {
        //
    }
}
