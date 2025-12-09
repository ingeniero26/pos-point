<?php

namespace App\Http\Controllers;

use App\Models\CurrenciesModel;
use App\Models\IdentificationTypeModel;
use App\Models\ItemsModel;
use App\Models\PaymentMethodModel;
use App\Models\PaymentTypeModel;
use App\Models\PersonModel;
use App\Models\Invoices;
use App\Models\InvoicesItems;
use App\Models\StateTypeModel;
use App\Models\User;
use App\Models\VoucherTypeModel;
use App\Models\WarehouseModel;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use App\Models\AccountsReceivable;
use App\Models\CashMovement;
use App\Models\CashRegisterSession;
use App\Models\InventoryModel;
use App\Models\TaxesModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\InventoryCacheService;
use Illuminate\Support\Facades\Mail;

use App\Models\AccountTypesModel;
use App\Models\InvoiceItems;
use Stripe\Invoice;

class InvoicesController extends Controller
{
    protected $inventoryCacheService;

    public function __construct(InventoryCacheService $inventoryCacheService)
    {
        $this->inventoryCacheService = $inventoryCacheService;
    }

    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        $data['customers'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 1)
        ->get();
        return view('admin.sales.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['voucherTypes'] = VoucherTypeModel::where('is_delete','=',0)->get();
        $data['warehouses'] = WarehouseModel::where('is_delete','=',0)->get();
        $data['stateTypes'] = StateTypeModel::where('is_delete','=',0)->get();
        $data['formPayments'] = PaymentTypeModel::where('is_delete','=',0)->get();
        $data['currencies'] = CurrenciesModel::where('is_delete','=',0)->get();
        $data['paymentMethods'] = PaymentMethodModel::where('is_delete','=',0)->get();
       $data['identificationTypes'] = IdentificationTypeModel::where('is_delete','=',0)->get();
        // obtener las cajas registradoras activas
       $data['cashRegisters'] = \App\Models\CashRegister::where('is_delete', '=', 0)
       ->where('status', '=', 1)
       ->get();
       // mostrar los bancos
         $data['banks'] = \App\Models\BankingInstitutionsModel::where('is_delete', '=', 0)
       ->get();
       // tipo cuenta bancaria
         $data['bankAccountTypes'] = \App\Models\AccountTypesModel::where('is_delete', '=', 0)
       ->get();       
       // usuarios de rol 2
       $data['users'] = User::where('is_delete', '=', 0)->get();

       
        $data['customers'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 1)
        ->get();
        $data['products'] = ItemsModel::where('is_delete', '=', 0)
        ->get();
        $data['employees'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 4)
        ->get();
        return view('admin.sales.add', $data);
    }
    public function getItems(Request $request) {
        // consult
        try {
            $term = $request->input('term');
    
            // Aplicar el filtro WHERE en la consulta a la base de datos
            $items = ItemsModel::where(function ($query) use ($term) {
                $query->where('product_name', 'like', "%{$term}%")
                    ->orWhere('barcode', 'like', "%{$term}%")
                    ->orWhere('internal_code', 'like', "%{$term}%");
            })
            ->with(['tax', 'category'])
            ->get();
    
            $result = [];
            foreach ($items as $item) {
                $stock = \Illuminate\Support\Facades\DB::table('item_warehouse')
                    ->where('item_id', $item->id)
                    ->sum('stock');
    
                $result[] = [
                    'id' => $item->id,
                    'code' => $item->internal_code ?? $item->barcode,
                    'name' => $item->product_name,
                    'sale_price' => (float)$item->selling_price,
                    'cost_price' => (float)$item->cost_price,
                    'stock' => (int)$stock,
                    'tax_rate' => $item->tax ? (float)$item->tax->rate : 0,
                    'category' => $item->category ? $item->category->category_name : ''
                ];
            }
    
            return response()->json($result, 200, [
                'Content-Type' => 'application/json',
                'charset' => 'utf-8'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en el servidor.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public  function preview() {
        $data['voucherTypes'] = VoucherTypeModel::where('is_delete','=',0)->get();
        $data['warehouses'] = WarehouseModel::where('is_delete','=',0)->get();
        $data['stateTypes'] = StateTypeModel::where('is_delete','=',0)->get();
        $data['formPayments'] = PaymentTypeModel::where('is_delete','=',0)->get();
        $data['currencies'] = CurrenciesModel::where('is_delete','=',0)->get();
        $data['paymentMethods'] = PaymentMethodModel::where('is_delete','=',0)->get();
       $data['identificationTypes'] = IdentificationTypeModel::where('is_delete','=',0)->get();


        $data['customers'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 1)
        ->get();
        $data['products'] = ItemsModel::where('is_delete', '=', 0)
        ->get();
        $data['employees'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 4)
        ->get();
        return view('admin.sales.preview', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // obtener company_id
              // Obtener company_id del usuario autenticado
        $companyId = Auth::user()->company_id;
        
        // Obtener el objeto Company para generar el consecutivo
       $company = Companies::findOrFail($companyId);
            
            // Validar los datos de entrada
            $request->validate([
                'voucher_type_id' => 'required',
                'customer_id' => 'required',
                'state_type_id' => 'required',
                'warehouse_id' => 'required',
                'payment_form_id' => 'required',
                'date_of_issue' => 'required|date',
               // 'date_of_due' => 'required|date',
               // 'series' => 'required',
               // 'number' => 'required',
                'currency_id' => 'required',
                'payment_method_id' => 'required',
                'total_subtotal' => 'required|numeric',
                'total_tax' => 'required|numeric',
                'total_sale' => 'required|numeric',
                'product_ids' => 'required|array',
                'quantities' => 'required|array',
                'prices' => 'required|array'
            ]);

            $data = $request->all();
            // Generar el consecutivo ANTES de crear la venta
            $nextConsecutive = $company->getNextConsecutive();
            
            // Generar la serie basada en el prefijo de la empresa
            $series = $company->invoice_prefix ?? 'FV';
            
            // Crear la venta
            $sale = new Invoices();
            $sale->voucher_type_id = $data['voucher_type_id'];
            $sale->customer_id = $data['customer_id'];
            $sale->state_type_id = $data['state_type_id'];
            $sale->warehouse_id = $data['warehouse_id'];
            $sale->payment_form_id = $data['payment_form_id'];
            $sale->date_of_issue = $data['date_of_issue'];
            $sale->date_of_due = $data['date_of_due'];
            $sale->time_of_issue = now()->format('H:i:s');
            $sale->series = $series;
            $sale->number = $nextConsecutive;
            $sale->currency_id = $data['currency_id'];
            $sale->payment_method_id = $data['payment_method_id'];
            $sale->total_subtotal = $data['total_subtotal'];
            $sale->total_tax = $data['total_tax'];
            $sale->total_discount = $data['total_discount'] ?? 0;
            $sale->total_sale = $data['total_sale'];
            $sale->total_taxed = $data['total_taxed'] ?? 0;
            $sale->total_unaffected = $data['total_unaffected'] ?? 0;
            $sale->total_exonerated = $data['total_exonerated'] ?? 0;
            $sale->delivery_status = $data['delivery_status'] ?? 'Pendiente';
            $sale->shipping_method = $data['shipping_method'] ?? null;
            $sale->observations = $data['observations'] ?? null;
            $sale->company_id = $companyId;
            $sale->created_by = Auth::user()->id;
            
            if (!$sale->save()) {
                throw new \Exception('Error al guardar la venta');
            }

            // Generar número de factura
            // Generar número de factura con el formato correcto usando el consecutivo
            $sale->invoice_no = $company->getFormattedConsecutive($nextConsecutive);
            $sale->save();
            // Guardar los items de la venta
            if (isset($data['product_ids']) && is_array($data['product_ids'])) {
                foreach ($data['product_ids'] as $index => $productId) {
                    $quantity = $data['quantities'][$index] ?? 0;
                    $price = $data['prices'][$index] ?? 0;
                    $discount = $data['discounts'][$index] ?? 0;
                    $taxRate = $data['tax_rates'][$index] ?? 0;
                    $subtotal = $data['subtotals'][$index] ?? 0;
                    $taxAmount = $data['tax_amounts'][$index] ?? 0;

                    // Obtener información del producto
                    $product = ItemsModel::find($productId);
                    if (!$product) {
                        throw new \Exception("Producto no encontrado: {$productId}");
                    }

                    // Crear el item de venta
                    $saleItem = new InvoiceItems();
                    $saleItem->invoice_id = $sale->id;
                    $saleItem->item_id = $productId;
                    $saleItem->quantity = $quantity;
                    $saleItem->unit_price = $price;
                    $saleItem->total_price = $quantity * $price;
                    $saleItem->discount = $discount;
                    $saleItem->tax_id = $product->tax_id;
                    $saleItem->tax_rate = $taxRate;
                    $saleItem->tax_amount = $taxAmount;
                    $saleItem->subtotal = $subtotal;
                    $saleItem->total = $subtotal + $taxAmount;
                    $saleItem->is_taxed = $product->tax_id ? 1 : 0;
                    $saleItem->is_exonerated = 0;
                    $saleItem->is_unaffected = 0;
                    $saleItem->created_by = Auth::user()->id;
                    $saleItem->company_id = Auth::user()->company_id;

                    if (!$saleItem->save()) {
                        throw new \Exception("Error al guardar el item de venta: {$productId}");
                    }

                    // Actualizar inventario
                    $warehouseItem = InventoryModel::where('item_id', $productId)
                        ->where('warehouse_id', $data['warehouse_id'])
                        ->first();

                    if ($warehouseItem) {
                        $previousStock = $warehouseItem->stock;
                        $warehouseItem->stock -= $quantity;
                        $warehouseItem->save();
                        // Limpiar caché de inventario para la empresa
                        $this->inventoryCacheService->clearInventoryCache(Auth::user()->company_id);

                        // Registrar movimiento de inventario
                        $movement = new \App\Models\ItemMovementModel();
                        $movement->item_id = $productId;
                        $movement->warehouse_id = $data['warehouse_id'];
                        $movement->movement_type_id = 6; // Salida por venta
                        $movement->movement_date = now()->format('Y-m-d');
                        $movement->quantity = $quantity;
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
            if ($request->payment_method_id == 1) {
                $cashSession = CashRegisterSession::where('cash_register_id', $request->cash_register_id)
                    ->where('status', 'Open')
                    ->first();

                if (!$cashSession) {
                    throw new \Exception('No hay una sesión de caja abierta');
                }

                // Registrar movimiento de caja
                $cashMovement = new CashMovement([
                    'cash_register_session_id' => $cashSession->id,
                    'cash_movement_type_id' => 2, // Ingreso por venta
                    'amount' => $request->total_sale,
                    'description' => 'Venta #' . $sale->invoice_no,
                    'reference_document_type' => 'SALE',
                    'reference_document_number' => $sale->invoice_no,
                    'related_sale_id' => $sale->id,
                    'related_third_party_id' => $request->customer_id,
                    'transaction_time' => now(),
                    'user_id' => Auth::id(),
                    'company_id' => Auth::user()->company_id,
                    'created_by' => Auth::id()
                ]);

                if (!$cashMovement->save()) {
                    throw new \Exception('Error al registrar el movimiento de caja');
                }

                // Actualizar saldo de caja
                $cashSession->current_balance += $request->total_sale;
                $cashSession->expected_closing_balance += $request->total_sale;
                $cashSession->save();
            }

            // Registrar cuenta por cobrar si es crédito
            if ($request->payment_form_id == 2) {
                $accountsReceivable = new \App\Models\AccountsReceivable();
                $accountsReceivable->sale_id = $sale->id;
                $accountsReceivable->customer_id = $request->customer_id;
                $accountsReceivable->voucher_type_id = $request->voucher_type_id;
                $accountsReceivable->date_of_issue = $request->date_of_issue;
                $accountsReceivable->date_of_due = $request->date_of_due;
                $accountsReceivable->total_amount = $request->total_sale;
                $accountsReceivable->balance = $request->total_sale;
                $accountsReceivable->account_statuses_id = 1; // Pendiente
                $accountsReceivable->currency_id = $request->currency_id;
                $accountsReceivable->company_id = Auth::user()->company_id;
                $accountsReceivable->created_by = Auth::user()->id;
                $accountsReceivable->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venta registrada exitosamente',
                'sale_id' => $sale->id,
                'invoice_no' => $sale->invoice_no
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Error en venta: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la venta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
  /**
 * Display the specified sale with all related details.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function show($id) 
    {
        try {
            // Obtener la factura con todas sus relaciones
            $sale = Invoices::with([
                'voucherTypes', 
                'customers', 
                'stateTypes', 
                'paymentTypes', 
                'currencies', 
                'payment_method',
                'warehouses',
                'company',
                'users',
                'invoiceItems.item.tax', // Incluir los items con sus detalles y tax
                'invoiceItems.tax'
            ])
            ->where('id', $id)
            ->where('is_delete', 0)
            ->firstOrFail();
            
            // Verificar si hay cuentas por cobrar asociadas a esta venta
            $accountsReceivable = \App\Models\AccountsReceivable::where('sale_id', $id)
                ->where('is_delete', 0)
                ->first();
            
            // Asegurar que invoiceItems no sea null
            if (!$sale->invoiceItems) {
                $sale->setRelation('invoiceItems', collect([]));
            }
            
            // Pasar los datos a la vista
            return view('admin.sales.details', compact('sale', 'accountsReceivable'));
            
        } catch (\Exception $e) {
            Log::error('Error al mostrar detalles de factura: ' . $e->getMessage());
            return redirect()->route('admin.sales.list')
                ->with('error', 'No se pudo cargar la factura solicitada.');
        }
    }
    public function getDetails($id) 
    {
        try {
            // Obtener la factura con todas sus relaciones
            $sale = Invoices::with([
                'voucherTypes', 
                'customers', 
                'stateTypes', 
                'paymentTypes', 
                'currencies', 
                'payment_method',
                'warehouses',
                'company',
                'users',
                'invoiceItems.item.tax', // Incluir los items con sus detalles y tax
                'invoiceItems.tax'
            ])
            ->where('id', $id)
            ->where('is_delete', 0)
            ->firstOrFail();
            
            // Verificar si hay cuentas por cobrar asociadas a esta venta
            $accountsReceivable = \App\Models\AccountsReceivable::where('sale_id', $id)
                ->where('is_delete', 0)
                ->first();
            
            // Asegurar que invoiceItems no sea null
            if (!$sale->invoiceItems) {
                $sale->setRelation('invoiceItems', collect([]));
            }
            
            // Pasar los datos a la vista
            return view('admin.sales.details', compact('sale', 'accountsReceivable'));
            
        } catch (\Exception $e) {
            Log::error('Error al obtener detalles de factura: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'No se pudo cargar la factura solicitada.'
            ], 404);
        }
    }

    public function destroy(Invoices $sales)
    {
        //
    }

  /**
   * Get sales data with optional filters
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getSales(Request $request)
  {
      $query = Invoices::with(['customers', 'company', 'voucherTypes', 'warehouses', 'currencies', 
          'users', 'invoiceItems.item', 'invoiceItems.tax',
      'paymentForm', 'payment_method', 'stateTypes'])
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
      if ($request->has('state_type_id') && !empty($request->state_type_id)) {
          $query->where('state_type_id', $request->state_type_id);
      }
      
      $sales = $query->get();
      
      return response()->json($sales);
  }

  /**
 * Export sales to Excel
 *
 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
 */
public function exportExcel()
{
    return Excel::download(new SalesExport, 'ventas.xlsx');
}

/**
 * Export sales to PDF
 *
 * @return \Illuminate\Http\Response
 */
    public function exportPdf(Request $request)
    {
        $query = Invoices::with(['customers', 'paymentForm', 'payment_method', 'stateTypes'])
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
        if ($request->has('state_type_id') && !empty($request->state_type_id)) {
            $query->where('state_type_id', $request->state_type_id);
        }
        
        $sales = $query->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.sales.pdf.list', compact('sales'));
        return $pdf->download('ventas.pdf');
    }
    public function printPdf($id)
    {
        $sale = Invoices::with([
            'voucherTypes',
            'customers',
            'stateTypes',
            'paymentTypes',
            'currencies',
            'payment_method',
            'warehouses',
            'company',
            'users',
            'invoiceItems.item' // Include the sale items with their details
        ])
        ->where('id', $id)
        ->where('is_delete', 0)
        ->firstOrFail();
        
        // Load the PDF view with the data
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.sales.pdf', compact('sale'));
        
        // Download the PDF
        return $pdf->download('Venta-' . $sale->id . '.pdf');
    }
    // enviar correo
    public function sendEmail($id)
    {
        $sale = Invoices::with([
            'voucherTypes',
            'customers',
            'stateTypes',
            'paymentForm',
            'currencies',
            'payment_method',
            'warehouses',
            'company',
            'users',
            'invoiceItems.item' // Include the sale items with their details
        ])
        ->where('id', $id)
        ->where('is_delete', 0)
        ->firstOrFail();
        
        // Verificar si el cliente tiene correo electrónico
        if (!$sale->customers->email) {
            return response()->json([
                'success' => false,
                'message' => 'El cliente no tiene un correo electrónico registrado'
            ], 400);
        }

        // Load the PDF view with the data
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.sales.pdf', compact('sale'));
        
        try {
            // Send the PDF as an email attachment
            Mail::to($sale->customers->email)->send(new \App\Mail\SendInvoice($sale));
            
            return response()->json([
                'success' => true,
                'message' => 'Factura enviada correctamente al correo: ' . $sale->customers->email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el correo: ' . $e->getMessage()
            ], 500);
        }
    }
    // sistema pos
    public function listPos(){
        return view('admin.sales.pos');
    }
    
    /**
     * Display the professional POS dashboard interface
     *
     * @return \Illuminate\View\View
     */
    public function posDashboard()
    {
        // Get active cash register session for current user
        $cashRegisterSession = \App\Models\CashRegisterSession::where('user_id', Auth::id())
            ->where('status', 'Open')
            ->first();
            
        if (!$cashRegisterSession) {
            return redirect()->route('admin.cash_register_session.list')
                ->with('error', 'Debe abrir una caja registradora antes de usar el POS');
        }
        
        // Get the cash register
        $cashRegister = $cashRegisterSession->cashRegister;
        
        // Get first warehouse to show initial stock
        $firstWarehouse = \App\Models\WarehouseModel::where('is_delete', 0)->first();
        
        // Get all necessary data for POS interface
        $data = [
            'categories' => \App\Models\CategoryModel::where('is_delete', 0)->get(),
            'cashRegisters' => \App\Models\CashRegister::where('is_delete', 0)
                ->where('status', 1)
                ->get(),
            'products' => \App\Models\ItemsModel::where('is_delete', 0)
                ->where('status', 0)
                ->with(['category', 'tax', 'measure'])
                ->get()
                ->map(function($product) use ($firstWarehouse) {
                    // Get stock from item_warehouse table for the first warehouse
                    $stock = 0;
                    if ($firstWarehouse) {
                        $inventory = InventoryModel::where('item_id', $product->id)
                            ->where('warehouse_id', $firstWarehouse->id)
                            ->first();
                        $stock = $inventory ? $inventory->stock : 0;
                    }
                    
                    // Add stock information to product
                    $product->available_stock = $stock;
                    return $product;
                }),
            'customers' => \App\Models\PersonModel::where('is_delete', 0)
                ->where('type_third_id', 1)
                ->get(),
            'paymentMethods' => \App\Models\PaymentMethodModel::where('is_delete', 0)->get(),
            'paymentTypes' => \App\Models\PaymentTypeModel::where('is_delete', 0)->get(),
            'warehouses' => \App\Models\WarehouseModel::where('is_delete', 0)->get(),
            'cashRegister' => $cashRegister,
            'taxes' => \App\Models\TaxesModel::where('is_delete', 0)->get(),
            'initialWarehouse' => $firstWarehouse ? $firstWarehouse->id : null
        ];
        
        return view('admin.pos.dashboard', $data);
    }
    
    /**
     * Add item to POS cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function posAddItem(Request $request)
    {
        try {
            $item = \App\Models\ItemsModel::with(['tax', 'measure'])
                ->findOrFail($request->item_id);
                
            // Check inventory
            $inventory = \App\Models\InventoryModel::where('item_id', $item->id)
                ->where('warehouse_id', $request->warehouse_id)
                ->first();
                
            // Log inventory check
            \Illuminate\Support\Facades\Log::info('Inventory check:', [
                'item_id' => $item->id,
                'warehouse_id' => $request->warehouse_id,
                'inventory' => $inventory ? $inventory->toArray() : null,
                'requested_quantity' => $request->quantity
            ]);
                
            if (!$inventory) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay inventario disponible para este producto en la bodega seleccionada'
                ]);
            }
            
            if ($inventory->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Stock insuficiente. Stock disponible: {$inventory->stock}"
                ]);
            }
            
            // Return item details with calculated values
            return response()->json([
                'success' => true,
                'item' => $item,
                'quantity' => $request->quantity,
                'stock' => $inventory->stock,
                'subtotal' => $item->selling_price * $request->quantity,
                'tax_amount' => $item->tax ? ($item->selling_price * $request->quantity * $item->tax->rate / 100) : 0
            ]);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in posAddItem:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar el producto: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Process POS payment and create sale
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function posProcessPayment(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'customer_id' => 'required',
                'payment_method_id' => 'required',
                'payment_form_id' => 'required',
                'warehouse_id' => 'required',
                'items' => 'required|array',
                'total' => 'required|numeric',
                'subtotal' => 'required|numeric',
                'tax_amount' => 'required|numeric',
            ]);
            
            // Begin transaction
            DB::beginTransaction();
            
            // Obtener la empresa y generar el consecutivo
            $company = Companies::findOrFail(Auth::user()->company_id);
            $nextConsecutive = $company->getNextConsecutive();
            
            // Create sale
            $sale = new \App\Models\Invoices();
            $sale->customer_id = $request->customer_id;
            $sale->voucher_type_id = 8;
            $sale->state_type_id = 1;
            $sale->created_by = Auth::id();
            $sale->date_of_issue = now();
            $sale->currency_id = 170;
            $sale->payment_method_id = $request->payment_method_id;
            $sale->payment_form_id = $request->payment_form_id;
            $sale->warehouse_id = $request->warehouse_id;
            $sale->total_subtotal = $request->subtotal;
            $sale->total_tax = $request->tax_amount;
            $sale->total_discount = $request->discount ?? 0;
            $sale->total_sale = $request->total;
            $sale->payment_received = $request->received;
            $sale->payment_change = $request->change;
            $sale->observations = $request->notes;
            $sale->company_id = Auth::user()->company_id;
            $sale->save();
           
            
            // Generate invoice number using consecutive
            $sale->invoice_no = $company->getFormattedConsecutive($nextConsecutive);
            $sale->series = $company->invoice_prefix ?? 'FV';
            $sale->number = $nextConsecutive;
            $sale->save();
            // actualizar el movimiento de la caja
              // Registrar el movimiento en la caja y actualizar el saldo
              if ($request->payment_method_id == 1) { // Si es pago en efectivo
                $cashSession = CashRegisterSession::where('cash_register_id', $request->cash_register_id)
                    ->where('status', 'Open')
                    ->first();

                if ($cashSession) {
                    // Registrar el movimiento
                    $cashMovement = new CashMovement([
                        'cash_register_session_id' => $cashSession->id,
                        'cash_movement_type_id' => 2, // Ingreso por venta
                        'amount' => $request->total,
                        'description' => 'Venta #' . $sale->invoice_no,
                        'reference_document_type' => 'SALE',
                        'reference_document_number' => $sale->invoice_no,
                        'related_sale_id' => $sale->id,
                        'related_third_party_id' => $request->customer_id,
                        'transaction_time' => now(),
                        'user_id' => Auth::id(),
                        'company_id' => Auth::user()->company_id,
                        'created_by' => Auth::id()
                    ]);
                    $cashMovement->save();

                    // Actualizar el saldo de la sesión
                    $cashSession->current_balance += $request->total;
                   // $cashSession->expected_closing_balance += $request->total;
                    $cashSession->save();
                }
            }
        
            
            foreach ($request->items as $item) {
                // Get the item details to fetch tax_id and tax_rate
                $itemDetails = \App\Models\ItemsModel::with('tax')->find($item['id']);
                
                $saleItem = new \App\Models\InvoiceItems();
                $saleItem->invoice_id = $sale->id;
                $saleItem->item_id = $item['id'];
                $saleItem->quantity = $item['quantity'];
                $saleItem->unit_price = $item['price'];
                $saleItem->discount = $item['discount'] ?? 0;
                $saleItem->tax_id = $itemDetails->tax_id ?? null;
                $saleItem->tax_rate = $itemDetails->tax ? $itemDetails->tax->rate : 0;
                $saleItem->tax_amount = $item['tax_amount'] ?? 0;
                $saleItem->subtotal = $item['subtotal'];
                $saleItem->total = $item['total'];
                $saleItem->is_taxed = $itemDetails->tax_id ? 1 : 0;
                $saleItem->is_exonerated = 0;
                $saleItem->is_unaffected = 0;
                $saleItem->created_by = Auth::id();
                $saleItem->company_id = Auth::user()->company_id;
                $saleItem->save();
                
                // Update inventory
                $inventory = \App\Models\InventoryModel::where('item_id', $item['id'])
                    ->where('warehouse_id', $request->warehouse_id)
                    ->first();
                    
                if ($inventory) {
                    $inventory->stock -= $item['quantity'];
                    $inventory->save();
                    
                    // Record inventory movement
                    $movement = new \App\Models\ItemMovementModel();
                    $movement->item_id = $item['id'];
                    $movement->warehouse_id = $request->warehouse_id;
                    $movement->movement_type_id = 6;
                    $movement->movement_date = now()->format('Y-m-d');
                    $movement->quantity = $item['quantity'];
                    $movement->previous_stock = $inventory->stock + $item['quantity'];
                    $movement->new_stock = $inventory->stock;
                    $movement->reason = 'Venta POS #' . $sale->invoice_no;
                    $movement->reference_id = $sale->id;
                    $movement->reference_type = 'Salida';
                    $movement->created_by = Auth::id();
                    $movement->company_id = Auth::user()->company_id;
                    $movement->save();
                }
            }
                     
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Venta procesada correctamente',
                'sale_id' => $sale->id,
                'invoice_number' => $sale->invoice_number
            ]);
            
            
} catch (\Exception $e) {
\Illuminate\Support\Facades\DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago: ' . $e->getMessage()
            ], 500);
        }
    }
    

    
    /**
     * Generate and display receipt
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function posReceipt($id)
    {
        $sale = \App\Models\Invoices::with([
            'customers', 
            'payment_method', 
            'paymentTypes',
            'invoiceItems.item',
            'invoiceItems.item.tax',
            'invoiceItems.tax',
            'users',
            'company',
            'warehouses'
        ])->findOrFail($id);
        
        return view('admin.pos.receipt', compact('sale'));
    }
    public function posUpdateQuantity(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'item_id' => 'required|integer',
                'warehouse_id' => 'required|integer',
                'quantity' => 'required|integer|min:1',
            ]);
            
            // Get item details
            $item = \App\Models\ItemsModel::findOrFail($request->item_id);
            
            // Check inventory
            $inventory = \App\Models\InventoryModel::where('item_id', $item->id)
                ->where('warehouse_id', $request->warehouse_id)
                ->first();
                
            if (!$inventory || $inventory->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Inventario insuficiente para este producto'
                ]);
            }
            
            // Return success response with updated values
            return response()->json([
                'success' => true,
                'message' => 'Cantidad actualizada correctamente',
                'quantity' => $request->quantity,
                'subtotal' => $item->selling_price * $request->quantity,
                'tax_amount' => $item->tax ? ($item->selling_price * $request->quantity * $item->tax->rate / 100) : 0
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la cantidad: ' . $e->getMessage()
            ], 500);
        }
    }
    public function salesByCategory(Request $request)
{
    $query = InvoiceItems::with(['item.category', 'invoice'])
        ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
        ->join('items', 'invoice_items.item_id', '=', 'items.id')
        ->join('categories', 'items.category_id', '=', 'categories.id')
        ->select(
            'categories.category_name',
            \Illuminate\Support\Facades\DB::raw('DATE(sales.created_at) as sale_date'),
            \Illuminate\Support\Facades\DB::raw('SUM(invoiceItems.quantity) as total_quantity'),
            \Illuminate\Support\Facades\DB::raw('SUM(invoiceItems.total) as total_amount')
        );

    // Filtrar por fecha si se proporciona
    if ($request->has('start_date')) {
        $query->whereDate('sales.created_at', '>=', $request->start_date);
    }
    if ($request->has('end_date')) {
        $query->whereDate('sales.created_at', '<=', $request->end_date);
    }

    $salesData = $query->groupBy('categories.id', 'categories.category_name', 'sale_date')
        ->orderBy('sale_date')
        ->get();

    return view('admin.reports.sales-by-category', compact('salesData'));
}


// public function updateState(Request $request, $id)
// {
//     try {
//         $sale = Invoices::findOrFail($id);
//         $sale->state_type_id = $request->state_type_id;
//         $sale->save();

//         return response()->json([
//             'success' => true,
//             'message' => 'Estado de la venta actualizado correctamente'
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Error al actualizar el estado de la venta: ' . $e->getMessage()
//         ], 500);
//     }

// }

public function updateState(Request $request)
{
    DB::beginTransaction();
    
    try {
        $request->validate([
            'sale_id' => 'required|exists:invoices,id',
            'new_state' => 'required|integer|between:1,7'
        ]);

        $sale = Invoices::findOrFail($request->sale_id);
        $oldState = $sale->state_type_id;
        $newState = $request->new_state;

        // Validaciones de negocio según el estado actual y nuevo estado
        // if (!$this->validateStateTransition($oldState, $newState)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Transición de estado no permitida'
        //     ], 422);
        // }

        // Actualizar el estado
        $sale->state_type_id = $newState;
        $sale->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente',
            'data' => [
                'sale_id' => $sale->id,
                'old_state' => $oldState,
                'new_state' => $newState,
                'state_description' => $sale->stateType->description ?? 'N/A'
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al actualizar estado de venta: ' . $e->getMessage(), [
            'sale_id' => $request->sale_id,
            'new_state' => $request->new_state,
            'exception' => $e
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Error interno del servidor: ' . $e->getMessage() // ← Temporal para debugging
        ], 500);
    }
}

}
   
