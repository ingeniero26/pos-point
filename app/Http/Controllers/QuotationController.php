<?php

namespace App\Http\Controllers;

use App\Mail\QuotationEmail;
use App\Models\Branch;
use App\Models\CashMovement;
use App\Models\CashRegisterSession;
use App\Models\CurrenciesModel;
use App\Models\IdentificationTypeModel;
use App\Models\ItemsModel;
use App\Models\PaymentMethodModel;
use App\Models\PaymentTypeModel;
use App\Models\PersonModel;
use App\Models\Quotation;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use App\Models\Companies;
use App\Models\InventoryModel;
use App\Models\ItemMovementModel;
use App\Models\StatusQuotation;
use App\Models\AccountsReceivable;
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
        $data['branches'] = Branch::where('is_delete','=',0)->get();
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
                'branch',
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
            $quotation->branch_id = $request->branch_id;
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
        $query = Quotation::with(['customer', 'paymentForm', 'payment_method', 'statusQuotation','warehouse','branch','quotation_items.item','quotation_items.item.measure','quotation_items.item.category'])
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

   // convertToInvoice
    public function convertToInvoice(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $quotation = Quotation::with(['quotation_items.item', 'company'])->findOrFail($id);

            if ($quotation->converted_to_invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta cotización ya fue convertida a factura.',
                    'quotation_id' => $id
                ], 400);
            }

            $company = $quotation->company ?? Companies::findOrFail(Auth::user()->company_id);
            $nextConsecutive = $company->getNextConsecutive();
            $series = $company->invoice_prefix ?? 'FV';

            $sale = new Invoices();
            $sale->voucher_type_id = $quotation->voucher_type_id;
            $sale->customer_id = $quotation->customer_id;
            $sale->state_type_id = 1;
            $sale->warehouse_id = $quotation->warehouse_id;
            $sale->payment_form_id = $quotation->payment_form_id;
            $sale->payment_method_id = $quotation->payment_method_id;
            $sale->date_of_issue = $quotation->date_of_issue;
            $sale->date_of_due = $quotation->date_of_expiration ?? $quotation->date_of_issue;
            $sale->time_of_issue = now()->format('H:i:s');
            $sale->series = $series;
            $sale->number = $nextConsecutive;
            $sale->currency_id = $quotation->currency_id;
            $sale->total_subtotal = $quotation->subtotal;
            $sale->total_tax = $quotation->total_tax;
            $sale->total_discount = $quotation->total_discount;
            $sale->total_sale = $quotation->total;
            $sale->delivery_status = 'pending';
            $sale->shipping_method = null;
            $sale->observations = $quotation->notes;
            $sale->company_id = $company->id;
            $sale->created_by = Auth::user()->id;
            $sale->operation_type = '10';
            $sale->uuid = \Illuminate\Support\Str::uuid()->toString();
            $sale->save();

            $sale->invoice_no = $company->getFormattedConsecutive($nextConsecutive);
            $sale->save();

            foreach ($quotation->quotation_items as $quotationItem) {
                $product = $quotationItem->item;
                if (! $product) {
                    throw new \Exception('Producto no encontrado para el item de cotización ID: ' . $quotationItem->id);
                }

                $saleItem = new InvoiceItems();
                $saleItem->invoice_id = $sale->id;
                $saleItem->item_id = $quotationItem->item_id;
                $saleItem->quantity = $quotationItem->quantity;
                $saleItem->unit_price = $quotationItem->unit_price;
                $saleItem->total_price = $quotationItem->quantity * $quotationItem->unit_price;
                $saleItem->discount = $quotationItem->discount ?? 0;
                $saleItem->tax_id = $quotationItem->tax_id;
                $saleItem->tax_rate = $quotationItem->tax_rate ?? 0;
                $saleItem->tax_amount = $quotationItem->total_tax ?? 0;
                $saleItem->subtotal = $quotationItem->subtotal ?? ($quotationItem->quantity * $quotationItem->unit_price - ($quotationItem->discount ?? 0));
                $saleItem->total = $quotationItem->total ?? ($saleItem->subtotal + $saleItem->tax_amount);
                $saleItem->is_taxed = $quotationItem->tax_id ? 1 : 0;
                $saleItem->is_exonerated = 0;
                $saleItem->is_unaffected = 0;
                $saleItem->created_by = Auth::user()->id;
                $saleItem->company_id = Auth::user()->company_id;
                $saleItem->save();

                if ($quotation->warehouse_id) {
                    $warehouseItem = InventoryModel::where('item_id', $quotationItem->item_id)
                        ->where('warehouse_id', $quotation->warehouse_id)
                        ->first();

                    if ($warehouseItem) {
                        $previousStock = $warehouseItem->stock;
                        $warehouseItem->stock -= $quotationItem->quantity;
                        $warehouseItem->save();

                        $movement = new ItemMovementModel();
                        $movement->item_id = $quotationItem->item_id;
                        $movement->warehouse_id = $quotation->warehouse_id;
                        $movement->movement_type_id = 6;
                        $movement->movement_date = now()->format('Y-m-d');
                        $movement->quantity = $quotationItem->quantity;
                        $movement->previous_stock = $previousStock;
                        $movement->new_stock = $warehouseItem->stock;
                        $movement->reason = 'Venta #' . $sale->invoice_no;
                        $movement->reference_id = $sale->id;
                        $movement->reference_type = 'Salida';
                        $movement->created_by = Auth::user()->id;
                        $movement->company_id = Auth::user()->company_id;
                        $movement->save();
                    }
                }
            }

            // Procesar pago en efectivo si aplica
            if ($quotation->payment_method_id == 1) {
                $cashSession = CashRegisterSession::where('user_id', Auth::id())
                    ->where('status', 'Open')
                    ->first();

                if (!$cashSession) {
                    throw new \Exception('No hay una sesión de caja abierta para el usuario ' . Auth::user()->name);
                }

                // Registrar movimiento de caja único para toda la factura
                $cashMovement = new CashMovement([
                    'cash_register_session_id' => $cashSession->id,
                    'cash_movement_type_id' => 2, // Ingreso por venta
                    'amount' => $quotation->total,
                    'description' => 'Venta #' . $sale->invoice_no,
                    'reference_document_type' => 'SALE',
                    'reference_document_number' => $sale->invoice_no,
                    'related_sale_id' => $sale->id,
                    'related_third_party_id' => $sale->customer_id,
                    'transaction_time' => now(),
                    'user_id' => Auth::id(),
                    'company_id' => Auth::user()->company_id,
                    'created_by' => Auth::id()
                ]);

                if (!$cashMovement->save()) {
                    throw new \Exception('Error al registrar el movimiento de caja');
                }

                // Actualizar saldo de caja
                $cashSession->current_balance += $quotation->total;
                $cashSession->expected_closing_balance += $quotation->total;
                $cashSession->save();
            }

            // Registrar cuenta por cobrar si es crédito
            if ($quotation->payment_form_id == 2) {
                $accountsReceivable = new \App\Models\AccountsReceivable();
                $accountsReceivable->sale_id = $sale->id;
                $accountsReceivable->customer_id = $quotation->customer_id;
                $accountsReceivable->voucher_type_id = $quotation->voucher_type_id;
                $accountsReceivable->date_of_issue = $quotation->date_of_issue;
                $accountsReceivable->date_of_due = $quotation->date_of_expiration ?? $quotation->date_of_issue;
                $accountsReceivable->total_amount = $quotation->total;
                $accountsReceivable->balance = $quotation->total;
                $accountsReceivable->account_statuses_id = 1; // Pendiente
                $accountsReceivable->currency_id = $quotation->currency_id;
                $accountsReceivable->company_id = Auth::user()->company_id;
                $accountsReceivable->created_by = Auth::user()->id;
                $accountsReceivable->save();
            }

          

            $convertedStatus = StatusQuotation::where('name', 'like', '%convertida%')->first();
            if ($convertedStatus) {
                $quotation->status_quotation_id = $convertedStatus->id;
            }

            $quotation->converted_to_invoice = 1;
            $quotation->sale_id = $sale->id;
            $quotation->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cotización convertida a factura correctamente.',
                'invoice_id' => $sale->id,
                'invoice_no' => $sale->invoice_no
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al convertir cotización en factura: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al convertir la cotización: ' . $e->getMessage()
            ], 500);
        }
    }

}
