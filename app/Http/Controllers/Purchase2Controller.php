<?php

namespace App\Http\Controllers;

use App\Models\CurrenciesModel;
use App\Models\DocumentTypeModel;
use App\Models\InventoryModel;
use App\Models\ItemsModel;
use App\Models\PaymentMethodModel;
use App\Models\PaymentTypeModel;
use App\Models\PersonModel;
use App\Models\PurchaseItemsModel;
use App\Models\PurchaseModel;
use App\Models\StateTypeModel;
use App\Models\TmpPurchaseModel;
use App\Models\VoucherTypeModel;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class Purchase2Controller extends Controller
{
    //
    public function list()
    {

        return view('admin.purchases.list');
    }
    
    public function getPurchases(Request $request)
{
    $query = PurchaseModel::where('is_delete', '=', 0)
        ->with([
            'voucher_type',
            'suppliers' => function($q) {
                $q->select('id', 'company_name', 'first_name');
            },
            'state_type',
            'payment_types' => function($q) {
                $q->select('id', 'payment_type');
            },
            'payment_method' => function($q) {
                $q->select('id', 'name');
            },
            'purchase_items' => function($q) {
                $q->with(['item' => function($query) {
                    $query->select('id', 'product_name');
                }]);
            }
        ]);
    
    // Aplicar filtros
    $this->applyFilters($query, $request);
    
    // Obtener resultados ordenados
    $purchases = $query->orderBy('date_of_issue', 'desc')
                      ->orderBy('id', 'desc')
                      ->get();
    
    // Transformar los datos para la vista
    $transformed = $purchases->map(function($purchase) {
        return [
            'id' => $purchase->id,
            'date_of_issue' => $purchase->date_of_issue,
            'suppliers' => $purchase->suppliers,
            'invoice_no' => $purchase->invoice_no,
            'state_type' => $purchase->state_type,
            'payment_types' => $purchase->payment_types,
            'payment_method' => $purchase->payment_method,
            'total_subtotal' => $purchase->total_subtotal,
            'total_tax' => $purchase->total_tax,
            'total_discount' => $purchase->total_discount,
            'total_purchase' => $purchase->total_purchase,
            'items_count' => $purchase->purchase_items->count(),
            'created_at' => $purchase->created_at
        ];
    });
    
    return response()->json($transformed);
}

private function applyFilters($query, $request)
{
    // Filtrar por rango de fechas
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('date_of_issue', [
            $request->start_date, 
            $request->end_date
        ]);
    }
    
    // Filtrar por proveedor
    if ($request->filled('supplier_id')) {
        $query->where('supplier_id', $request->supplier_id);
    }
    
    // Filtrar por número de factura
    if ($request->filled('invoice_no')) {
        $query->where('invoice_no', 'like', '%' . $request->invoice_no . '%');
    }
    
    // Filtrar por estado
    if ($request->filled('state_type_id')) {
        $query->where('state_type_id', $request->state_type_id);
    }
}
    public function create()
    {
        $data['documentTypes'] = VoucherTypeModel::where('is_delete','=',0)->get();
        $data['warehouses'] = WarehouseModel::where('is_delete','=',0)->get();
        $data['stateTypes'] = StateTypeModel::where('is_delete','=',0)->get();
        $data['formPayments'] = PaymentTypeModel::where('is_delete','=',0)->get();
        $data['currencies'] = CurrenciesModel::where('is_delete','=',0)->get();
        $data['paymentMethods'] = PaymentMethodModel::where('is_delete','=',0)->get();
        $data['items'] = ItemsModel::where('is_delete','=',0)
        ->with(['category', 'tax']) // Asegúrate de que 'taxes' sea el nombre de la relación
        ->get();
        $data['suppliers'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 2)      
        ->get();
        $session_id = session()->getId();
        $data['session_id'] = $session_id;
        $tmp_purchase = TmpPurchaseModel::where('session_id','=',$session_id)->get();
        $data['tmp_purchase'] = $tmp_purchase;
        $data['cashRegisters'] = \App\Models\CashRegister::where('is_delete', '=', 0)
        ->where('status', '=', 1)
        ->get();
        return view('admin.purchases.add', $data);
    }
    public function search_items_purchase(Request $request)
    {
        $query = $request->input('query');

        $items = ItemsModel::where('product_name', 'like', "%{$query}%")
            ->orWhere('barcode', 'like', "%{$query}%")
            ->with(['category', 'tax']) // Asegúrate de que 'taxes' sea el nombre de la relación
            ->get();

        return response()->json($items);
    }
    public function updateState(Request $request)
{
    try {
        $purchase = PurchaseModel::findOrFail($request->purchase_id);
        $purchase->state_type_id = $request->state_id;
        // si es recahzado, anulada o por anular, que efectos tiene en el inventario
        if ($request->state_id == 5 || $request->state_id == 6 || $request->state_id == 7) {
            $purchase_items = PurchaseItemsModel::where('purchase_id', $purchase->id)->get();
            foreach ($purchase_items as $item) {
                $inventory = InventoryModel::where('item_id', $item->item_id)->first();
                if ($inventory) {
                    $inventory->stock -= $item->quantity;
                    $inventory->save();
                }
            }
        }
        $purchase->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el estado: ' . $e->getMessage()
        ], 500);
    }
}
    
    // para guardar la compra 
    public function store(Request $request)
    {
        try {
            // Pre-process numeric values before validation
            $input = $request->all();
            
            // Convert formatted numbers to proper numeric values for validation
            if (isset($input['total_subtotal'])) $input['total_subtotal'] = $this->convertToFloat($input['total_subtotal']);
            if (isset($input['total_tax'])) $input['total_tax'] = $this->convertToFloat($input['total_tax']);
            if (isset($input['total_discount'])) $input['total_discount'] = $this->convertToFloat($input['total_discount']);
            if (isset($input['total_purchase'])) $input['total_purchase'] = $this->convertToFloat($input['total_purchase']);
            
            // Replace the request data with the processed data
            $request->replace($input);
            
            // Now validate with the processed values
            $request->validate([
                'total_subtotal' => 'required|numeric',
                'total_tax' => 'required|numeric',
                'total_discount' => 'required|numeric',
                'total_purchase' => 'required|numeric',
            ]);
            $session_id= session()->getId();
    
            // Create a new PurchaseModel instance
            $purchase = new PurchaseModel();
            $purchase->voucher_type_id = $request->voucher_type_id;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->created_by = Auth::user()->id;
            $purchase->state_type_id = $request->state_type_id;
            $purchase->payment_form_id = $request->payment_form_id;
            $purchase->invoice_no = $request->invoice_no;
            $purchase->date_of_issue = $request->date_of_issue;
            $purchase->date_of_due = $request->date_of_due;
            $purchase->time_of_issue = now()->format('H:i:s');
            $purchase->series = $request->series;
            $purchase->number = $request->number;
            $purchase->currency_id = $request->currency_id;
            $purchase->payment_method_id = $request->payment_method_id;
    
            // The values are already converted, so we can assign them directly
            $purchase->total_subtotal = $request->total_subtotal;
            $purchase->total_tax = $request->total_tax;
            $purchase->total_discount = $request->total_discount;
            $purchase->total_purchase = $request->total_purchase;
     // Save the warehouse ID to the purchase
            $purchase->warehouse_id = $request->warehouse_id;
     
            $purchase->observations = $request->observations;
            $purchase->company_id = Auth::user()->company_id;
            $purchase->save();
            // registro en la caja si es efectivo la compra
            if ($request->payment_method_id == 1) {
                // consultar la caja si esta abierta y su saldo
                $cashRegisterSession = \App\Models\CashRegisterSession::where('status', 'Open')
                    ->where('company_id', Auth::user()->company_id)
                    ->first();

                if ($cashRegisterSession) {
                    // si existe la caja abierta, realizar el movimiento de la caja
                    $cashMovement = new \App\Models\CashMovement();
                    $cashMovement->cash_register_session_id = $cashRegisterSession->id;
                    // Asegurarse de usar un ID de tipo de movimiento que sea EGRESO
                    // $movementType = \App\Models\TypeMovementCash::where('type', 'EGRESO')
                    // ->where('is_system_generated', true)
                    // ->where('name', 'Pago a Proveedor')
                    // ->where('company_id', $request->company_id)
                    // ->where('is_delete', 0)
                    // ->first();
                    
                    // if (!$movementType) {
                    //     return response()->json([
                    //         'success' => false,
                    //         'message' => 'No se encontró un tipo de movimiento válido para egresos'
                    //     ], 422);
                    // }
                    
                    $cashMovement->cash_movement_type_id = 8;
                    $cashMovement->amount = -$request->total_purchase; // Modificar aquí, hacer el monto negativo para egresos
                    $cashMovement->description = 'Compra de productos';
                    $cashMovement->reference_document_type = 'Compra';
                    $cashMovement->reference_document_number = $purchase->id;
                    $cashMovement->related_purchase_id = $purchase->id;
                    $cashMovement->related_third_party_id = $request->supplier_id;
                    $cashMovement->transaction_time = now();
                    $cashMovement->user_id = Auth::user()->id;
                    $cashMovement->company_id = Auth::user()->company_id;
                    $cashMovement->created_by = Auth::user()->id;
                    $cashMovement->save();

                    // Actualizar el saldo de la caja usando la misma sesión encontrada
                    $cashRegisterSession->current_balance -= $request->total_purchase;
                    $cashRegisterSession->save();
                }
            }
          
           

            if ($request->payment_form_id == 2) { // Asumiendo que 2 es el ID para crédito
                $accountsPayable = new \App\Models\AccountsPayableModel();
                $accountsPayable->purchase_id = $purchase->id;
                $accountsPayable->supplier_id = $request->supplier_id;
                $accountsPayable->voucher_type_id = $request->voucher_type_id;
                $accountsPayable->invoice_no = $request->invoice_no;
                $accountsPayable->date_of_issue = $request->date_of_issue;
                $accountsPayable->date_of_due = $request->date_of_due;
                $accountsPayable->total_amount = $request->total_purchase;
                $accountsPayable->balance = $request->total_purchase; // Inicialmente, el monto pendiente es igual al total
                $accountsPayable->account_statuses_id = 1; // Estado inicial: pendiente
                $accountsPayable->currency_id = $request->currency_id;
                $accountsPayable->company_id = Auth::user()->company_id;
                $accountsPayable->created_by = Auth::user()->id;
                $accountsPayable->save();
            }
        
            // // consultar la caja si esta abierta y su saldo y depue
          

            $tmp_compras = TmpPurchaseModel::where('session_id','=',$session_id)->get();
            foreach ($tmp_compras as $tmp_compra) {

                $purchase_items =  new PurchaseItemsModel();
                $purchase_items->purchase_id = $purchase->id;
                $purchase_items->item_id = $tmp_compra->item_id;
                // insertar la bodega
               // $purchase_items->warehouse_id = $tmp_compra->warehouse_id;
              
                $purchase_items->quantity = $tmp_compra->quantity;
                $purchase_items->cost_price = $tmp_compra->cost_price;
                $purchase_items->discount_percent = $tmp_compra->discount_percent;
                $purchase_items->save();
                 
                  // Buscar el inventario para el producto y la bodega
                  $inventory = InventoryModel::where('item_id', $tmp_compra->item_id)
                                              ->where('warehouse_id', $request->warehouse_id)
                                              ->first();

                  if ($inventory) {
                      // Si el inventario existe, actualizar el stock
                      $previous_stock = $inventory->stock;
                      $inventory->stock += $tmp_compra->quantity;
                      $inventory->save();
                      
                      // Registrar el movimiento en item_movements
                      $itemMovement = new \App\Models\ItemMovementModel();
                      $itemMovement->item_id = $tmp_compra->item_id;
                      $itemMovement->warehouse_id = $request->warehouse_id;
                      $itemMovement->movement_type_id = 2;
                      $itemMovement->quantity = $tmp_compra->quantity;
                      $itemMovement->previous_stock = $previous_stock;
                      $itemMovement->new_stock = $inventory->stock;
                      $itemMovement->reason = 'Compra de producto';
                      $itemMovement->reference_id = $purchase->id;
                      $itemMovement->reference_type = 'Entrada';
                      $itemMovement->created_by = Auth::user()->id;
                      $itemMovement->company_id = Auth::user()->company_id;
                      $itemMovement->is_delete = 0;
                      $itemMovement->save();
                  } else {
                      // Si no existe, crear un nuevo registro
                      $newInventory = new InventoryModel();
                      $newInventory->item_id = $tmp_compra->item_id;
                      // Usar el warehouse_id del request en lugar del tmp_compra
                      $newInventory->warehouse_id = $request->warehouse_id;
                      $newInventory->stock = $tmp_compra->quantity;
                      // Agregar company_id para consistencia
                      $newInventory->company_id = Auth::user()->company_id;
                      $newInventory->save();
                      
                      // Registrar el movimiento inicial en item_movements
                      $itemMovement = new \App\Models\ItemMovementModel();
                      $itemMovement->item_id = $tmp_compra->item_id;
                      $itemMovement->warehouse_id = $request->warehouse_id;
                      $itemMovement->movement_type_id = 2;
                      $itemMovement->quantity = $tmp_compra->quantity;
                      $itemMovement->previous_stock = 0;
                      $itemMovement->new_stock = $tmp_compra->quantity;
                      $itemMovement->reason = 'Compra inicial de producto';
                      $itemMovement->reference_id = $purchase->id;
                      $itemMovement->reference_type = 'Entrada';
                      $itemMovement->created_by = Auth::user()->id;
                      $itemMovement->company_id = Auth::user()->company_id;
                      $itemMovement->is_delete = 0;
                      $itemMovement->save();


                  }
                  //// insertar el movimiento en la caja
            }
            // eliminar los daos de la tabla temporal
            TmpPurchaseModel::where('session_id','=',$session_id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Factura de compra guardada correctamente',
                'purchase_id' => $purchase->id
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la factura: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Convierte un valor con comas a un número float válido.
     *
     * @param string $value
     * @return float
     */
    private function convertToFloat($value)
    {
        // Eliminar comas y convertir a float
        return (float)str_replace(',', '', $value);
    }
    public function show($id) 
    {
        // Obtener la factura de compra con todas sus relaciones
        $purchase = PurchaseModel::with([
            'voucher_type', 
            'suppliers', 
            'state_type', 
            'payment_types', 
            'currencies', 
            'payment_method',
            'warehouses',
            'company',
            'users',
            'purchase_items.item' // Incluir los items de la compra con sus detalles
        ])
        ->where('id', $id)
        ->where('is_delete', 0)
        ->firstOrFail();
        
        // Verificar si hay cuentas por pagar asociadas a esta compra
        $accountsPayable = \App\Models\AccountsPayableModel::where('purchase_id', $id)
            ->with('account_states')
            ->first();
        
        // Pasar los datos a la vista
        return view('admin.purchases.details', compact('purchase', 'accountsPayable'));
    }
    public function printPdf($id){
        $purchase = PurchaseModel::with([
            'voucher_type',
           'suppliers',
           'state_type',
            'payment_types',
            'currencies',
            'payment_method',
            'warehouses',
            'company',
            'users',
            'purchase_items.item' // Incluir los items de la compra con sus detalles
        ])
        ->where('id', $id)
        ->where('is_delete', 0)
        ->firstOrFail();
        // Verificar si hay cuentas por pagar asociadas a esta compra
        $accountsPayable = \App\Models\AccountsPayableModel::where('purchase_id', $id)
            ->with('account_states')
            ->first();
            // Cargar la vista del PDF con los datos
            $pdf = PDF::loadView('admin.purchases.pdf', compact('purchase', 'accountsPayable'));
        //return view('admin.purchases.pdf', compact('purchase', 'accountsPayable'));
        // descargar el pdf
        return $pdf->download('Compra-' . $purchase->id . '.pdf');
     }

      // compra desde la orden compras
      /**
 * Generate a purchase from a purchase order
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function generateFromOrder(Request $request)
{
    try {
        // Validate request
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
        ]);

        // Get the purchase order
        $purchaseOrder = \App\Models\PurchaseOrder::with(['suppliers', 'purchase_order_items', 'purchase_order_items.items'])
            ->findOrFail($request->purchase_order_id);
            
        // Check if purchase order is in a valid state to generate purchase
        $validStates = [2,3, 4, 5]; // Approved, Sent to Supplier, In Process
        if (!in_array($purchaseOrder->status_order_id, $validStates)) {
            return response()->json([
                'success' => false,
                'message' => 'La orden de compra debe estar en estado Aprobada, Enviada al Proveedor o En Proceso para generar una compra.'
            ]);
        }
        
        // Check if a purchase already exists for this order
        $existingPurchase = PurchaseModel::where('purchase_order_id', $purchaseOrder->id)->first();
        if ($existingPurchase) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una compra generada para esta orden.',
                'purchase_url' => url('admin/purchase/view/' . $existingPurchase->id)
            ]);
        }
        
        // Begin transaction
        \DB::beginTransaction();
        
        // Create new purchase
        $purchase = new PurchaseModel();
        $purchase->supplier_id = $purchaseOrder->supplier_id;
        $purchase->voucher_type_id = 1; // Default type (e.g., Factura)
        $purchase->purchase_order_id = $purchaseOrder->id;
        $purchase->invoice_no = $purchaseOrder->invoice_no;
        $purchase->date_of_issue = now()->format('Y-m-d');
        $purchase->date_of_due = now()->addDays(30)->format('Y-m-d'); // Default 30 days due date
        $purchase->state_type_id = 1; // Default status (e.g., Registered)
        $purchase->payment_method_id = 1; // Default payment method (e.g., Cash)
        $purchase->payment_form_id = 1; // Default payment term (e.g., Immediate)
        $purchase->warehouse_id = $purchaseOrder->warehouse_id;
        $purchase->total_subtotal = $purchaseOrder->subtotal;
        $purchase->total_tax = $purchaseOrder->tax_amount;
        $purchase->total_purchase = $purchaseOrder->total;
        $purchase->observations = 'Generado automáticamente desde la orden de compra #' . $purchaseOrder->id;
        $purchase->company_id = Auth::user()->company_id;
        $purchase->created_by = Auth::user()->id;
        $purchase->save();
       
        
        
        // Create purchase items from purchase order items
        foreach ($purchaseOrder->purchase_order_items as $orderItem) {
            $purchaseItem = new PurchaseItemsModel();
            $purchaseItem->purchase_id = $purchase->id;
            // Change from product_id to item_id to match the field name in purchase_order_items table
            $purchaseItem->item_id = $orderItem->item_id;
            $purchaseItem->quantity = $orderItem->quantity;
            $purchaseItem->cost_price = $orderItem->unit_price;
            $purchaseItem->discount_percent = 0; // Default discount
            $purchaseItem->save();
            
            // Update inventory - also update the item_id reference here
            $inventory = InventoryModel::where('item_id', $orderItem->item_id)
                ->where('warehouse_id', $purchaseOrder->warehouse_id)
                ->first();
                
            if ($inventory) {
                $previous_stock = $inventory->stock;
                $inventory->stock += $orderItem->quantity;
                $inventory->save();
                
                // Record inventory movement
                $itemMovement = new \App\Models\ItemMovementModel();
                $itemMovement->item_id = $orderItem->item_id;
                $itemMovement->warehouse_id = $purchaseOrder->warehouse_id;
                $itemMovement->movement_type_id = 2; // Purchase
                $itemMovement->quantity = $orderItem->quantity;
                $itemMovement->previous_stock = $previous_stock;
                $itemMovement->new_stock = $inventory->stock;
                $itemMovement->reason = 'Compra generada desde orden #' . $purchaseOrder->id;
                $itemMovement->reference_id = $purchase->id;
                $itemMovement->reference_type = 'Entrada';
                $itemMovement->created_by = Auth::user()->id;
                $itemMovement->company_id = Auth::user()->company_id;
                $itemMovement->is_delete = 0;
                $itemMovement->save();
            } else {
                // Create new inventory record
                $newInventory = new InventoryModel();
                $newInventory->item_id = $orderItem->item_id;
                $newInventory->warehouse_id = $purchaseOrder->warehouse_id;
                $newInventory->stock = $orderItem->quantity;
                $newInventory->company_id = Auth::user()->company_id;
                $newInventory->save();
                
                // Record inventory movement
                $itemMovement = new \App\Models\ItemMovementModel();
                $itemMovement->item_id = $orderItem->item_id;
                $itemMovement->warehouse_id = $purchaseOrder->warehouse_id;
                $itemMovement->movement_type_id = 2; // Purchase
                $itemMovement->quantity = $orderItem->quantity;
                $itemMovement->previous_stock = 0;
                $itemMovement->new_stock = $orderItem->quantity;
                $itemMovement->reason = 'Compra inicial generada desde orden #' . $purchaseOrder->id;
                $itemMovement->reference_id = $purchase->id;
                $itemMovement->reference_type = 'Entrada';
                $itemMovement->created_by = Auth::user()->id;
                $itemMovement->company_id = Auth::user()->company_id;
                $itemMovement->is_delete = 0;
                $itemMovement->save();
            }
        }
        
        // Update purchase order status to "Facturada" (8)
        $purchaseOrder->status_order_id = 8; // Facturada
        $purchaseOrder->save();
        
        // Commit transaction
        \DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Compra generada correctamente',
            'purchase_id' => $purchase->id,
            'purchase_url' => url('admin/purchase/view/' . $purchase->id)
        ]);
        
    } catch (\Exception $e) {
        // Rollback transaction
        \DB::rollBack();
        
        return response()->json([
            'success' => false,
            'message' => 'Error al generar la compra: ' . $e->getMessage()
        ]);
    }
}


}
