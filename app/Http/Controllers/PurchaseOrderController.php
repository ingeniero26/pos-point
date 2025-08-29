<?php

namespace App\Http\Controllers;

use App\Mail\PurchaseOrderEmail;
use App\Models\CurrenciesModel;
use App\Models\ItemsModel;
use App\Models\PersonModel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItemModel;
use App\Models\StatusOrder;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderController extends Controller
{
    //
    public function  list()
    {
        return view('admin.purchase_order.list');
    }
    public  function  getPurchaseOrders()
    {
        $purchaseOrders = PurchaseOrder::with([
           'suppliers',
            'warehouses',
           'status_order',
            'purchase_order_items.items.measure',
            'users'
        ])->where('is_delete', '=', 0)
            ->get();
        return response()->json($purchaseOrders);
    }
    public  function add()
    {
        $data['suppliers'] = PersonModel::where('is_delete', '=', 0)
        ->where('type_third_id','=', 2)      
        ->get();
        // status_order
        $data['status_order'] = StatusOrder::where('is_delete','=',0)->get();
        $data['currencies'] = CurrenciesModel::where('is_delete','=',0)->get();
        $data['warehouses'] = WarehouseModel::where('is_delete','=',0)->get();

        return view('admin.purchase_order.add', $data);
    }
    public function getItems()
    {
        $items = ItemsModel::where('is_delete', 0)
            ->with(['category', 'measure', 'tax'])
            ->get();
            
        return response()->json($items);
    }
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:persons,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'order_date' => 'required|date',
            'expected_date' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();
            
            // Create purchase order
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->supplier_id = $request->supplier_id;
            $purchaseOrder->warehouse_id = $request->warehouse_id;
            // Remove this line as we'll set the prefix after saving
            // $purchaseOrder->prefix = 'OC-'. str_pad($purchaseOrder->id, 6, '0', STR_PAD_LEFT);
            $purchaseOrder->order_date = $request->order_date;
            $purchaseOrder->expected_date = $request->expected_date;
            //
            $purchaseOrder->notes = $request->notes;
            $purchaseOrder->status_order_id = $request->status_order_id; // pending, received, cancelled
            $purchaseOrder->created_by = Auth::id();
            $purchaseOrder->company_id = session('company_id', 1);
            $purchaseOrder->is_delete = 0;
            
            // Calculate totals
            $subtotal = 0;
            $tax_amount = 0;
            
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['price'];
                $tax_amount += $item['quantity'] * $item['price'] * ($item['tax_rate'] / 100);
            }
            
            $purchaseOrder->subtotal = $subtotal;
            $purchaseOrder->tax_amount = $tax_amount;
            $purchaseOrder->total = $subtotal + $tax_amount;
            $purchaseOrder->save();
            
            // Now set the prefix with the actual ID and update the record
            $purchaseOrder->prefix = 'OC-' . str_pad($purchaseOrder->id, 6, '0', STR_PAD_LEFT);
            $purchaseOrder->save();
            //contcatenar el numero de orden con este campo prefix
            $purchaseOrder->prefix = 'OC-' . str_pad($purchaseOrder->id, 6, '0', STR_PAD_LEFT);
            
            // Create purchase order items
            foreach ($request->items as $item) {
                $orderItem = new PurchaseOrderItemModel();
                $orderItem->purchase_order_id = $purchaseOrder->id;
                $orderItem->item_id = $item['item_id'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->tax_rate = $item['tax_rate'];
                $orderItem->tax_amount = $item['quantity'] * $item['price'] * ($item['tax_rate'] / 100);
                $orderItem->subtotal = $item['quantity'] * $item['price'];
                $orderItem->total = $orderItem->subtotal + $orderItem->tax_amount;
                $orderItem->save();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Orden de compra creada exitosamente',
                'purchase_order_id' => $purchaseOrder->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la orden de compra: ' . $e->getMessage()
            ], 500);
        }
    }
    public function viewOrder($id)
    {
        $purchaseOrder = PurchaseOrder::with([
            'suppliers', 
            'warehouses', 
            'status_order',
            'purchase_order_items.items.measure',
            'users'
        ])->findOrFail($id);
        
        return view('admin.purchase_order.view', compact('purchaseOrder'));
    }
    public function edit($id){
        // Get suppliers but filter for type_third_id = 2 (vendors/suppliers)
        $data['suppliers'] = PersonModel::where('is_delete', '=', 0)
            ->where('type_third_id', '=', 2)
            ->get();
        
        // Rename status_order to statuses to match the view
        $data['statuses'] = StatusOrder::where('is_delete', '=', 0)->get();
        
        // Get warehouses
        $data['warehouses'] = WarehouseModel::where('is_delete', '=', 0)->get();
        
        // Get all products for the dropdown
        $data['products'] = ItemsModel::where('is_delete', '=', 0)
            ->with(['measure', 'tax'])
            ->get();
        
        // Get purchase order with related data
        $data['purchaseOrder'] = PurchaseOrder::with([
            'purchase_order_items.items.measure',
            'purchase_order_items.items.tax',
            'suppliers',
            'warehouses',
            'status_order',
            'users'
        ])->findOrFail($id);
        
        return view('admin.purchase_order.edit', $data);
    }
    /**
     * Export purchase order to PDF
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function printPdf($id)
    {
        try {
            // Add debug logging
            Log::info('Starting PDF generation for purchase order ID: ' . $id);
            
            $purchaseOrder = PurchaseOrder::with([
                'suppliers', 
                'warehouses', 
                'purchase_order_items.items.measure',
                'users',
                'status_order',
                'company',
                'purchase_order_items.items.tax',
                'currencies'
            ])->findOrFail($id);
            
            // Check if the view exists
            if (!view()->exists('admin.purchase_order.pdf')) {
                Log::error('PDF view template not found: admin.purchase_order.pdf');
                return response()->json(['error' => 'PDF template not found'], 500);
            }
            
            // Verify data is loaded correctly
            Log::info('Purchase order data loaded: ' . json_encode([
                'id' => $purchaseOrder->id,
                'prefix' => $purchaseOrder->prefix,
                'items_count' => $purchaseOrder->purchase_order_items->count()
            ]));
            
            $pdf = PDF::loadView('admin.purchase_order.pdf', [
                'purchaseOrder' => $purchaseOrder
            ]);
            
            // Set paper size and orientation
            $pdf->setPaper('a4', 'portrait');
            
            // Generate a filename
            $filename = 'orden_compra_' . $purchaseOrder->prefix . '.pdf';
            
            Log::info('PDF generated successfully, downloading as: ' . $filename);
            
            // Return the PDF as a download
            return $pdf->stream($filename);
            
        } catch (\Exception $e) {
    Log::error('Error generating PDF: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'error' => 'Error al generar el PDF: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    /**
     * Get purchase order details for email
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetails($id)
    {
        try {
            $purchaseOrder = PurchaseOrder::with([
                'suppliers', 
                'warehouses', 
                'status_order',
                'purchase_order_items.items.measure',
                'users'
            ])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $purchaseOrder
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener detalles: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Send purchase order by email
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmail(Request $request)
    {
        try {
            $request->validate([
                'purchase_order_id' => 'required|exists:purchase_orders,id',
                'email_to' => 'required|email',
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);

            Log::info('Starting email process for purchase order ID: ' . $request->purchase_order_id);

            $purchaseOrder = PurchaseOrder::with([
                'suppliers',
                'warehouses',
                'purchase_order_items.items.measure',
                'users',
                'status_order',
                'company',
                'purchase_order_items.items.tax',
                'currencies'
            ])->findOrFail($request->purchase_order_id);

            // Generate PDF
            $pdf = PDF::loadView('admin.purchase_order.pdf', [
                'purchaseOrder' => $purchaseOrder
            ]);

            // Set paper size and orientation
            $pdf->setPaper('a4', 'portrait');

            // Generate a filename
            $filename = 'orden_compra_' . $purchaseOrder->prefix . '.pdf';

            // Prepare email data
            $emailData = [
                'message' => $request->message,
                'subject' => $request->subject,
                'purchaseOrder' => $purchaseOrder,
                'orderPrefix' => $purchaseOrder->prefix,
                'orderDate' => $purchaseOrder->order_date ? date('d/m/Y', strtotime($purchaseOrder->order_date)) : 'N/A',
                'expectedDate' => $purchaseOrder->expected_date ? date('d/m/Y', strtotime($purchaseOrder->expected_date)) : 'N/A',
                'total' => number_format($purchaseOrder->total, 0, ',', '.'),
                'userName' => $purchaseOrder->users ? $purchaseOrder->users->name : 'Administrador',
                'companyName' => $purchaseOrder->company && $purchaseOrder->company->company_name ?
                    $purchaseOrder->company->company_name : ''
            ];

            Log::info('Email data prepared, sending email to: ' . $request->email_to);

            // Send email using the Mailable class
            Mail::to($request->email_to)
                ->send(new PurchaseOrderEmail($emailData, $pdf, $filename));

            Log::info('Email sent successfully');
            
            // Update purchase order status to "enviada" (sent)
            // First, find the status ID for "enviada" or similar status
            $sentStatus = StatusOrder::where('name', 'like', '%enviada%')
                ->orWhere('name', 'like', '%sent%')
                ->first();
                
            if ($sentStatus) {
                $purchaseOrder->status_order_id = $sentStatus->id;
                $purchaseOrder->save();
                Log::info('Purchase order status updated to: ' . $sentStatus->name);
            } else {
                Log::warning('Could not find "enviada" status to update purchase order');
            }

            return response()->json([
                'success' => true,
                'message' => 'Email enviado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending purchase order email: ' . $e->getMessage());
            Log::error('Error line: ' . $e->getLine());
            Log::error('Error file: ' . $e->getFile());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el email: ' . $e->getMessage()
            ], 500);
        }
    }
}
