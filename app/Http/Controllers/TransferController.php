<?php

namespace App\Http\Controllers;

use App\Models\DetailTransferModel;
use App\Models\ItemsModel;
use App\Models\StatusTransferModel;
use App\Models\TransferModel;
use App\Models\WarehouseModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\InventoryModel;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Mailer\Transport\Transports;
use PDF;

class TransferController extends Controller
{
    //
    public function list()
    {
        $data['warehouses'] = WarehouseModel::where('is_delete', '=', 0)->get();
        return view('admin.transfer.list', $data);
    }

    public function create()
    {
        $data['warehouses'] = WarehouseModel::where('is_delete', '=', 0)->get();
        // items
        $data['items'] = ItemsModel::where('is_delete', '=', 0)
                                ->where('item_type_id','!=', 2)
        ->get();
        $data['status_transfer'] = StatusTransferModel::where('is_delete','=',0)->get();
        return view('admin.transfer.add', $data);
    }

    public function getTransfers(Request $request)
        {
            $query = TransferModel::with(['warehouse', 'warehouse_destination', 'statusTransfer', 'details'])
                ->where('is_delete', '=', 0);

            // Filtro por Fechas
            // if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            //     $query->whereBetween('transfer_date', [$request->fecha_inicio, $request->fecha_fin]);
            // }

            if ($request->has('fecha_inicio') || $request->has('fecha_fin')) {
                $fechaInicio = $request->fecha_inicio;
                $fechaFin = $request->fecha_fin;
        
                if ($fechaInicio && $fechaFin) {
                    $query->whereBetween('transfer_date', [$fechaInicio, $fechaFin]);
                } elseif ($fechaInicio) {
                    $query->where('transfer_date', '>=', $fechaInicio);
                } elseif ($fechaFin) {
                    $query->where('transfer_date', '<=', $fechaFin);
                }
            }
            // Filtro por Bodega
            // if ($request->has('bodega_id') && $request->bodega_id != '') {
            //     $query->where('warehouse_id', $request->bodega_id);
            // }

            $transfers = $query->orderBy('id', 'desc')->get();

            return response()->json($transfers);
        }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'transfer_date' => 'nullable|date',
            'description' => 'nullable|string|max:255',
            'status_transfer_id' => 'required|exists:status_transfer,id',
            'items' => 'required|array',
            //'items.*.itemId' => 'required|exists:items,id',
        // 'items.*.quantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Iniciar transacción de base de datos
        DB::beginTransaction();
        
        try {
            // Crear la transferencia
            $transfer = new TransferModel();
            $transfer->from_warehouse_id = $request->from_warehouse_id;
            $transfer->to_warehouse_id = $request->to_warehouse_id;
            $transfer->transfer_date = $request->transfer_date;
            $transfer->description = $request->description;
            $transfer->status_transfer_id = $request->status_transfer_id;
            $transfer->created_by = Auth::user()->id;// Usuario que crea la transferencia
            $transfer->save();

            // Procesar los items de la transferencia
            foreach ($request->items as $item) {
                if (!isset($item['itemId']) || !isset($item['quantity'])) {
                    continue; // Saltar este item e ir al siguiente
                }
                // aqui guarda traslado con su detalle
                $transferItem = new DetailTransferModel();
                $transferItem->transfer_id = $transfer->id;
                $transferItem->item_id = $item['itemId'];
                $transferItem->quantity = $item['quantity'];
                $transferItem->save();
                //actualizar inventario en el almacen origen y destino
                $itemModel = ItemsModel::find($item['itemId']);
                $warehouseFrom = WarehouseModel::find($request->from_warehouse_id);
                $warehouseTo = WarehouseModel::find($request->to_warehouse_id);

                // Verificar y actualizar el inventario de origen
                $inventoryFrom = InventoryModel::where('warehouse_id', $warehouseFrom->id)
                ->where('item_id', $itemModel->id)
                ->first();

                if ($inventoryFrom) {
                    $previousStockFrom = $inventoryFrom->stock;
                    $inventoryFrom->stock -= $item['quantity'];
                    $inventoryFrom->save();
                    
                    // Registrar movimiento de salida en item_movements
                    $itemMovementFrom = new \App\Models\ItemMovementModel();
                    $itemMovementFrom->item_id = $itemModel->id;
                    $itemMovementFrom->warehouse_id = $warehouseFrom->id;
                    $itemMovementFrom->movement_type_id = 3;
                    $itemMovementFrom->quantity = -$item['quantity']; // Negativo porque es salida
                    $itemMovementFrom->previous_stock = $previousStockFrom;
                    $itemMovementFrom->new_stock = $inventoryFrom->stock;
                    $itemMovementFrom->reason = 'Transferencia a bodega ' . $warehouseTo->warehouse_name;
                    $itemMovementFrom->reference_id = $transfer->id;
                    $itemMovementFrom->reference_type = 'Traslado';
                    $itemMovementFrom->created_by = Auth::user()->id;
                    $itemMovementFrom->company_id = Auth::user()->company_id;
                    $itemMovementFrom->is_delete = 0;
                    $itemMovementFrom->save();
                } else {
                    // Crear inventario en el almacén de origen
                    $inventoryFrom = new InventoryModel();
                    $inventoryFrom->warehouse_id = $warehouseFrom->id;
                    $inventoryFrom->item_id = $itemModel->id;
                    $inventoryFrom->stock = -$item['quantity'];
                    $inventoryFrom->created_by = Auth::user()->id;
                    $inventoryFrom->save();
                    
                    // Registrar movimiento de salida en item_movements
                    $itemMovementFrom = new \App\Models\ItemMovementModel();
                    $itemMovementFrom->item_id = $itemModel->id;
                    $itemMovementFrom->warehouse_id = $warehouseFrom->id;
                    $itemMovementFrom->movement_type_id = 3;
                    $itemMovementFrom->quantity = -$item['quantity']; // Negativo porque es salida
                    $itemMovementFrom->previous_stock = 0;
                    $itemMovementFrom->new_stock = -$item['quantity'];
                    $itemMovementFrom->reason = 'Transferencia a bodega ' . $warehouseTo->warehouse_name;
                    $itemMovementFrom->reference_id = $transfer->id;
                    $itemMovementFrom->reference_type = 'Traslado';
                    $itemMovementFrom->user_id = Auth::user()->id;
                    $itemMovementFrom->company_id = Auth::user()->company_id;
                    $itemMovementFrom->is_delete = 0;
                    $itemMovementFrom->save();
                }

                // Verificar y actualizar el inventario de destino
                $inventoryTo = InventoryModel::where('warehouse_id', $warehouseTo->id)
                ->where('item_id', $itemModel->id)
                ->first();

                if ($inventoryTo) {
                    $previousStockTo = $inventoryTo->stock;
                    $inventoryTo->stock += $item['quantity'];
                    $inventoryTo->save();
                    
                    // Registrar movimiento de entrada en item_movements
                    $itemMovementTo = new \App\Models\ItemMovementModel();
                    $itemMovementTo->item_id = $itemModel->id;
                    $itemMovementTo->warehouse_id = $warehouseTo->id;
                    $itemMovementTo->movement_type_id = 4;
                    $itemMovementTo->quantity = $item['quantity']; // Positivo porque es entrada
                    $itemMovementTo->previous_stock = $previousStockTo;
                    $itemMovementTo->new_stock = $inventoryTo->stock;
                    $itemMovementTo->reason = 'Transferencia desde bodega ' . $warehouseFrom->warehouse_name;
                    $itemMovementTo->reference_id = $transfer->id;
                    $itemMovementTo->reference_type = 'Traslado';
                    $itemMovementTo->user_id = Auth::user()->id;
                    $itemMovementTo->company_id = Auth::user()->company_id;
                    $itemMovementTo->is_delete = 0;
                    $itemMovementTo->save();
                } else {
                    // Crear inventario en el almacén de destino
                    $inventoryTo = new InventoryModel();
                    $inventoryTo->warehouse_id = $warehouseTo->id;
                    $inventoryTo->item_id = $itemModel->id;
                    $inventoryTo->stock = $item['quantity'];
                    $inventoryTo->created_by = Auth::user()->id;
                    $inventoryTo->save();
                    
                    // Registrar movimiento de entrada en item_movements
                    $itemMovementTo = new \App\Models\ItemMovementModel();
                    $itemMovementTo->item_id = $itemModel->id;
                    $itemMovementTo->warehouse_id = $warehouseTo->id;
                    $itemMovementTo->movement_type_id = 4;
                    $itemMovementTo->quantity = $item['quantity']; // Positivo porque es entrada
                    $itemMovementTo->previous_stock = 0;
                    $itemMovementTo->new_stock = $item['quantity'];
                    $itemMovementTo->reason = 'Transferencia desde bodega ' . $warehouseFrom->warehouse_name;
                    $itemMovementTo->reference_id = $transfer->id;
                    $itemMovementTo->reference_type = 'Traslado';
                    $itemMovementTo->created_by = Auth::user()->id;
                    $itemMovementTo->company_id = Auth::user()->company_id;
                    $itemMovementTo->is_delete = 0;
                    $itemMovementTo->save();
                }

            
            }
            
            // Confirmar la transacción
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Traslado guardado correctamente',
                'data' => $transfer
            ], 201);
            
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el traslado',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getTransferDetails($id) {
        $transfer = TransferModel::with(['warehouse', 'warehouse_destination','statusTransfer', 'details', 'details.item'])
                ->where('id', '=', $id)
                ->where('is_delete', '=', 0)
                ->first();
        return response()->json($transfer);
    }
    public function updateStatus(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'transfer_id' => 'required|exists:transfer,id',
            'new_status' => 'required|exists:status_transfer,id',
        ]);

        // Obtener el traslado
        $transfer = TransferModel::findOrFail($request->transfer_id);

        // Actualizar el estado
        $transfer->status_transfer_id = $request->new_status;
        $transfer->save();

        // Devolver una respuesta JSON
        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente',
        ]);
    }
    // general n tocar
    public function exportPdf() {
        $transfers = TransferModel::with(['warehouse', 'warehouse_destination','statusTransfer', 'details', 'details.item'])
                                ->where('is_delete', '=', 0)
                                ->orderBy('id', 'desc')
                                ->get();

        $pdf = PDF::loadView('admin.transfer_pdf.export_demo_transfer', ['transfers' => $transfers]);
        return $pdf->download('traslados.pdf');
    }

  // por id
  public function printPdf($id)
  {
      // Obtener el traslado con sus relaciones
      $transfer = TransferModel::with(['warehouse', 'warehouse_destination', 'statusTransfer', 'details.item'])
                ->where('id', $id)
                ->where('is_delete', 0)
                ->firstOrFail();

      // Cargar la vista del PDF con los datos del traslado
      $pdf = PDF::loadView('admin.transfer_pdf.single_transfer', compact('transfer'));
      // Descargar el PDF
      return $pdf->download('traslado-' . $transfer->id . '.pdf');
  }

  // por rango de fechas
   
    
}
