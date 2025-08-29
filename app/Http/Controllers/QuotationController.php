<?php

namespace App\Http\Controllers;

use App\Mail\QuotationEmail;
use App\Models\CurrenciesModel;
use App\Models\IdentificationTypeModel;
use App\Models\ItemsModel;
use App\Models\PaymentMethodModel;
use App\Models\PaymentTypeModel;
use App\Models\PersonModel;
use App\Models\Quotation;
use App\Models\Sales;
use App\Models\StatusQuotation;
use App\Models\User;
use App\Models\VoucherTypeModel;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class QuotationController extends Controller
{
    //
    public function list(){
        $data['customers'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 1)
        ->get();
        return view('admin.quotation.list', $data);
    }
    public function create(){
        $data['voucherTypes'] = VoucherTypeModel::where('is_delete','=',0)->get();
        $data['warehouses'] = WarehouseModel::where('is_delete','=',0)->get();
        $data['stateTypes'] = StatusQuotation::where('is_delete','=',0)->get();
        $data['formPayments'] = PaymentTypeModel::where('is_delete','=',0)->get();
        $data['currencies'] = CurrenciesModel::where('is_delete','=',0)->get();
        $data['paymentMethods'] = PaymentMethodModel::where('is_delete','=',0)->get();
       $data['identificationTypes'] = IdentificationTypeModel::where('is_delete','=',0)->get();
       // usuarios de rol 2
       $data['users'] = User::where('is_role', '=', 2)->get();

       
        $data['customers'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 1)
        ->get();
        $data['products'] = ItemsModel::where('is_delete', '=', 0)
        ->get();
        $data['employees'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 4)
        ->get();
        return view('admin.quotation.add', $data);
    }
    public function show($id){
        try {
            $quotation = Quotation::with([
                'customer', 
                'warehouse', 
                'statusQuotation',
                'quotation_items.item.measure',
                'quotation_items.item.tax',
                'quotation_items.item.category',
                'user',
                'company',
                'currency',
                'paymentForm',
                'payment_method',
                'voucherTypes'
            ])->findOrFail($id);
            
            return view('admin.quotation.show', compact('quotation'));
        } catch (\Exception $e) {
            return redirect()->route('admin.quotation.list')
                ->with('error', 'Cotización no encontrada: ' . $e->getMessage());
        }
    }
    public function store(Request $request){
        //validar
        try {
            

            $quotation = new Quotation();
            $quotation->voucher_type_id = $request->voucher_type_id;
            //$quotation->user_id = $request->user_id;
            $quotation->user_id = Auth::user()->id;
         
            $quotation->state_type_id = $request->state_type_id;
            $quotation->prefix = $request->prefix;
           // $quotation->number = $request->number;
            $quotation->date_of_issue = $request->date_of_issue;
            $quotation->date_of_expiration = $request->date_of_expiration;
            $quotation->validity_days = $request->validity_days;
            $quotation->customer_id = $request->customer_id;
            $quotation->warehouse_id = $request->warehouse_id;
            $quotation->payment_conditions = $request->payment_conditions;
            $quotation->payment_form_id = $request->payment_form_id;
            $quotation->currency_id = $request->currency_id;
            $quotation->payment_method_id = $request->payment_method_id;
            $quotation->exchange_rate = $request->exchange_rate;
            $quotation->subtotal = $request->total_subtotal;
            $quotation->total_discount = $request->total_discount;
            $quotation->total_tax = $request->total_tax;
            $quotation->total = $request->total;
            $quotation->withholding_tax = $request->withholding_tax;
            $quotation->ica_tax = $request->ica_tax;
            $quotation->iva_tax = $request->iva_tax;
            $quotation->notes = $request->notes;
           // $quotation->approved_by = $request->approved_by;
          //  $quotation->approval_date = $request->approval_date;
            $quotation->status_quotation_id = $request->status_quotation_id;
            $quotation->converted_to_invoice = $request->converted_to_invoice;
            //$quotation->sale_id = $request->sale_id;
            $quotation->company_id = Auth::user()->company_id;
            $quotation->save();
            $quotation->number = $request->prefix . str_pad($quotation->id, 6, '0', STR_PAD_LEFT);
            $quotation->save();
            
            // Save quotation items
            if ($request->has('product_ids') && is_array($request->product_ids)) {
                for ($i = 0; $i < count($request->product_ids); $i++) {
                    // Get the product details
                        $product = ItemsModel::find($request->product_ids[$i]);
                        
                        if ($product) {
                            // Create quotation item
                            DB::table('quotation_items')->insert([
                                'quotation_id' => $quotation->id,
                                'item_id' => $request->product_ids[$i],
                                'company_id' => Auth::user()->company_id,
                                'unit_type_id' => $product->measure_id ?? 1, // Get the unit_id from the product
                                'tax_id' => $product->tax_id,
                                'total_tax' => isset($request->tax_rates) ? 
                                    (($request->prices[$i] * $request->quantities[$i] - $request->discount_amounts[$i]) * $request->tax_rates[$i] / 100) : 0,
                            'subtotal' => $request->subtotals[$i] ?? 0,
                            'discount' => $request->discount_amounts[$i] ?? 0,
                            'quantity' => $request->quantities[$i],
                            'unit_price' => $request->prices[$i],
                            'total' => $request->subtotals[$i] ?? 0,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Cotización creada correctamente.',
                'data' => $quotation
            ]);
            
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en el servidor.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function getQuotations(Request $request){
        $query = Quotation::with(['customer', 'paymentForm', 'payment_method', 'statusQuotation','warehouse'])
        ->orderBy('id', 'desc');
    
    // Apply date from filter
    if ($request->has('date_from') && !empty($request->date_from)) {
        $query->whereDate('date_of_issue', '>=', $request->date_from);
    }
    
    // Apply date to filter
    if ($request->has('date_to') && !empty($request->date_to)) {
        $query->whereDate('date_of_issue', '<=', $request->date_to);
    }
    
    // Apply customer filter
    if ($request->has('customer_id') && !empty($request->customer_id)) {
        $query->where('customer_id', $request->customer_id);
    }
    
    // Apply state type filter
    if ($request->has('status_quotation_id') && !empty($request->status_quotation_id)) {
        $query->where('status_quotation_id', $request->status_quotation_id);
    }
    
  
    
    $quotation = $query->get() ->where('is_delete', '=', 0);
    return response()->json($quotation);
    }
    public function getDetails($id)
    {
        try {
            $quotation = Quotation::with([
                'customer', 
                'warehouse', 
                'statusQuotation',
                'quotation_items.item.measure',
                'user'
            ])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $quotation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener detalles de la cotización: ' . $e->getMessage()
            ], 500);
        }
    }
    public function sendEmail(Request $request)
    {
        try {
            $request->validate([
                'quotation_id' => 'required|exists:quotations,id',
                'email_to' => 'required|email',
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);

            Log::info('Starting email process for quotation ID: ' . $request->quotation_id);

            $quotation = Quotation::with([
                'customer',
                'warehouse',
                'statusQuotation',
                'quotation_items.item.measure',
                'user',
                'company',
                'quotation_items.item.tax',
                'currency'
            ])->findOrFail($request->quotation_id);

            // Generate PDF
            $pdf = PDF::loadView('admin.quotation.pdf', [
                'quotation' => $quotation
            ]);

            // Set paper size and orientation
            $pdf->setPaper('a4', 'portrait');

            // Generate a filename
            $filename = 'cotizacion_' . $quotation->number . '.pdf';

            // Prepare email data
            $emailData = [
                'message' => $request->message,
                'subject' => $request->subject,
                'quotation' => $quotation,
                'quotationNumber' => $quotation->number,
                'issueDate' => $quotation->date_of_issue ? date('d/m/Y', strtotime($quotation->date_of_issue)) : 'N/A',
                'expirationDate' => $quotation->date_of_expiration ? date('d/m/Y', strtotime($quotation->date_of_expiration)) : 'N/A',
                'total' => number_format($quotation->total, 0, ',', '.'),
                'userName' => $quotation->user ? $quotation->user->name : 'Administrador',
                'companyName' => $quotation->company && $quotation->company->company_name ?
                    $quotation->company->company_name : ''
            ];

            Log::info('Email data prepared, sending email to: ' . $request->email_to);

            // Send email using the Mailable class
            Mail::to($request->email_to)
                ->send(new QuotationEmail($emailData, $pdf, $filename));

            Log::info('Email sent successfully');
            
            // Update quotation status to "enviada" (sent)
            // First, find the status ID for "enviada" or similar status
            $sentStatus = StatusQuotation::where('name', 'like', '%enviada%')
                ->orWhere('name', 'like', '%sent%')
                ->orWhere('id', 2) // Assuming ID 2 is for "Enviada" status
                ->first();
                
            if ($sentStatus) {
                $quotation->status_quotation_id = $sentStatus->id;
                $quotation->save();
                Log::info('Quotation status updated to: ' . $sentStatus->name);
            } else {
                Log::warning('Could not find "enviada" status to update quotation');
            }

            return response()->json([
                'success' => true,
                'message' => 'Email enviado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending quotation email: ' . $e->getMessage());
            Log::error('Error line: ' . $e->getLine());
            Log::error('Error file: ' . $e->getFile());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el email: ' . $e->getMessage()
            ], 500);
        }
    }
    public function pdfQuotation($id){
        try {
            $quotation = Quotation::with([
                'customer',
                'warehouse',
                'statusQuotation',
                'quotation_items.item.measure',
                'user',
                'company',
                'quotation_items.item.tax',
                'currency'
            ])->findOrFail($id);

            $pdf = PDF::loadView('admin.quotation.pdf', [
                'quotation' => $quotation
            ]);

            $pdf->setPaper('a4', 'portrait');
            
            return $pdf->stream('cotizacion_' . $quotation->number . '.pdf');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        $quotation = Quotation::findOrFail($id);
        $quotation->is_delete = 1;
        $quotation->save();
        return response()->json([
            'success' => true,
            'message' => 'Cotización eliminada correctamente'
        ]);
    }
    public function approve($id){
        $quotation = Quotation::findOrFail($id);
        $quotation->status_quotation_id = 3;
        $quotation->save();
        return response()->json([
            'success' => true,
            'message' => 'Cotización aprobada correctamente'
        ]);
    }

    public function updateState(Request $request){
        $quotation = Quotation::findOrFail($request->quotation_id);
        $quotation->status_quotation_id = $request->state_id;
        $quotation->save();
        return response()->json([
            'success' => true,
            'message' => 'Estado de cotización actualizado correctamente'
        ]);
    }



}
