<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryModel;
use App\Models\ItemsModel;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    public function getStock(Request $request)
    {
        try {
            // Validar que se reciba el warehouse_id
            $request->validate([
                'warehouse_id' => 'required|integer|exists:warehouses,id'
            ]);

            // Verificar que el almacén exista y esté activo
            $warehouse = WarehouseModel::where('id', $request->warehouse_id)
                ->where('is_delete', 0)
                ->first();

            if (!$warehouse) {
                return response()->json([
                    'success' => false,
                    'message' => 'Almacén no encontrado o inactivo'
                ], 404);
            }

            // Obtener el stock con información adicional del producto
            $stock = InventoryModel::with(['item' => function($query) {
                $query->select('id', 'name', 'code', 'price', 'currency_id')
                    ->with(['currencies' => function($query) {
                        $query->select('id', 'name', 'symbol');
                    }]);
            }])
            ->where('warehouse_id', $request->warehouse_id)
            ->select('item_id', 'stock', 'min_quantity', 'max_quantity', 'reorder_level')
            ->get()
            ->map(function($item) {
                return [
                    'product_id' => $item->item_id,
                    'stock' => $item->stock,
                    'min_quantity' => $item->min_quantity,
                    'max_quantity' => $item->max_quantity,
                    'reorder_level' => $item->reorder_level,
                    'product_name' => $item->item->name,
                    'product_code' => $item->item->code,
                    'price' => $item->item->price,
                    'currency' => [
                        'id' => $item->item->currencies->id,
                        'name' => $item->item->currencies->name,
                        'symbol' => $item->item->currencies->symbol
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'warehouse' => [
                    'id' => $warehouse->id,
                    'name' => $warehouse->name
                ],
                'stock' => $stock
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al obtener stock: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el stock'
            ], 500);
        }
    }
} 