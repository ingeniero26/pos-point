<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoryExport;
use App\Models\InventoryModel;
use App\Models\ItemMovementModel;
use App\Models\TypeMovementItems;

class InventoryController extends Controller
{
    /**
     * Mostrar vista de inventario
     */
    public function list()
    {
        return view('admin.inventory.list');
    }

    /**
     * Obtener inventario con paginación y filtros optimizados
     */
    public function getInventory(Request $request)
    {
        try {
            // Crear clave de caché única basada en los filtros
            $cacheKey = 'inventory_' . Auth::user()->company_id . '_' . 
                       md5($request->get('search', '') . 
                           $request->get('warehouse_id', '') . 
                           $request->get('category_id', '') . 
                           $request->get('per_page', 50) . 
                           $request->get('page', 1));

            // Intentar obtener del caché primero
            $inventory = Cache::remember($cacheKey, 300, function () use ($request) {
                $query = InventoryModel::where('is_delete', 0)
                    ->where('company_id', Auth::user()->company_id)
                    ->with([
                        'item:id,product_name,sku,reference,barcode,cost_price,selling_price,category_id,tax_id,measure_id',
                        'item.category:id,category_name',
                        'item.tax:id,tax_name,rate',
                        'item.measure:id,measure_name',
                        'warehouse:id,warehouse_name',
                        'company:id,company_name'
                    ])
                    ->orderBy('id', 'asc');

                // Aplicar filtros si se proporcionan
                if ($request->has('search') && !empty($request->search)) {
                    $search = $request->search;
                    $query->whereHas('item', function($q) use ($search) {
                        $q->where('product_name', 'like', "%{$search}%")
                          ->orWhere('sku', 'like', "%{$search}%")
                          ->orWhere('reference', 'like', "%{$search}%");
                    });
                }

                if ($request->has('warehouse_id') && !empty($request->warehouse_id)) {
                    $query->where('warehouse_id', $request->warehouse_id);
                }

                if ($request->has('category_id') && !empty($request->category_id)) {
                    $query->whereHas('item', function($q) use ($request) {
                        $q->where('category_id', $request->category_id);
                    });
                }

                // Paginación
                $perPage = $request->get('per_page', 50);
                return $query->paginate($perPage);
            });

            return response()->json($inventory);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el inventario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verificar stock de un item específico
     */
    public function checkStock(Request $request)
    {
        try {
            $inventory = InventoryModel::where('item_id', $request->item_id)
                ->where('warehouse_id', $request->warehouse_id)
                ->where('company_id', Auth::user()->company_id)
                ->where('is_delete', 0)
                ->select('id', 'stock', 'min_quantity', 'max_quantity')
                ->first();

            if ($inventory) {
                return response()->json([
                    'success' => true,
                    'stock' => $inventory->stock,
                    'min_quantity' => $inventory->min_quantity,
                    'max_quantity' => $inventory->max_quantity
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se encontró inventario para este item'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar stock: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ajustar inventario con transacción de base de datos
     */
    public function adjustInventory(Request $request)
    {
        try {
            DB::beginTransaction();

            $inventory = InventoryModel::where('id', $request->inventory_id)
                ->where('company_id', Auth::user()->company_id)
                ->lockForUpdate()
                ->first();

            if (!$inventory) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Inventario no encontrado'
                ], 404);
            }

            $previousStock = $inventory->stock;
            
            // Calcular nuevo stock basado en el tipo de ajuste
            switch ($request->adjustment_type) {
                case 'add':
                    $newStock = $previousStock + $request->quantity;
                    break;
                case 'subtract':
                    $newStock = $previousStock - $request->quantity;
                    if ($newStock < 0) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'El stock no puede ser negativo'
                        ]);
                    }
                    break;
                case 'set':
                    $newStock = $request->quantity;
                    break;
                default:
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Tipo de ajuste inválido'
                    ]);
            }
            
            // Actualizar inventario
            $inventory->stock = $newStock;
            $inventory->save();
            
            // Obtener ID del tipo de movimiento para ajuste
            $movementTypeId = TypeMovementItems::where('name', 'Ajuste')
                ->value('id') ?? 1;
            
            // Registrar movimiento de inventario
            $movement = new ItemMovementModel();
            $movement->item_id = $inventory->item_id;
            $movement->warehouse_id = $inventory->warehouse_id;
            $movement->movement_type_id = $movementTypeId;
            $movement->movement_date = now()->format('Y-m-d');
            $movement->quantity = $request->quantity;
            $movement->previous_stock = $previousStock;
            $movement->new_stock = $newStock;
            $movement->reason = $request->reason;
            $movement->reference_type = $request->adjustment_type == 'add' ? 'Entrada' : 
                                       ($request->adjustment_type == 'subtract' ? 'Salida' : 'Nuevo');
            $movement->created_by = Auth::user()->id;
            $movement->company_id = Auth::user()->company_id;
            $movement->is_delete = 0;
            $movement->save();
            
            // Limpiar caché de inventario para la empresa
            $this->clearInventoryCache(Auth::user()->company_id);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Inventario ajustado correctamente',
                'previous_stock' => $previousStock,
                'new_stock' => $newStock
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al ajustar el inventario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener historial de movimientos de inventario con paginación
     */
    public function getInventoryHistory($id, Request $request)
    {
        try {
            $inventory = InventoryModel::where('id', $id)
                ->where('company_id', Auth::user()->company_id)
                ->select('id', 'item_id', 'warehouse_id')
                ->first();

            if (!$inventory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Inventario no encontrado'
                ], 404);
            }
            
            $query = ItemMovementModel::where('item_id', $inventory->item_id)
                ->where('warehouse_id', $inventory->warehouse_id)
                ->where('company_id', Auth::user()->company_id)
                ->where('is_delete', 0)
                ->with([
                    'movementType:id,name',
                    'user:id,name',
                    'item:id,product_name'
                ])
                ->orderBy('created_at', 'desc');

            // Paginación para el historial
            $perPage = $request->get('per_page', 20);
            $movements = $query->paginate($perPage);

            // Transformar datos para la respuesta
            $movements->getCollection()->transform(function($movement) {
                return [
                    'id' => $movement->id,
                    'created_at' => $movement->created_at->format('d/m/Y H:i'),
                    'movement_type' => $movement->movementType ? $movement->movementType->name : 'Ajuste',
                    'quantity' => $movement->quantity,
                    'previous_stock' => $movement->previous_stock,
                    'new_stock' => $movement->new_stock,
                    'reason' => $movement->reason,
                    'user' => $movement->user ? ['name' => $movement->user->name] : null,
                    'item_name' => $movement->item ? $movement->item->product_name : 'N/A'
                ];
            });
            
            return response()->json($movements);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el historial: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar inventario a PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $query = InventoryModel::where('is_delete', 0)
                ->where('company_id', Auth::user()->company_id)
                ->with([
                    'item:id,product_name,sku,reference,barcode,cost_price,selling_price,category_id,tax_id,measure_id',
                    'item.category:id,name',
                    'item.tax:id,name,percentage',
                    'item.measure:id,name',
                    'warehouse:id,warehouse_name',
                    'company:id,name'
                ])
                ->orderBy('id', 'asc');

            // Aplicar filtros si se proporcionan
            if ($request->has('warehouse_id') && !empty($request->warehouse_id)) {
                $query->where('warehouse_id', $request->warehouse_id);
            }

            if ($request->has('category_id') && !empty($request->category_id)) {
                $query->whereHas('item', function($q) use ($request) {
                    $q->where('category_id', $request->category_id);
                });
            }

            $inventory = $query->get();
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.inventory.pdf', compact('inventory'));
            return $pdf->download('inventario.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar inventario a Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $query = InventoryModel::where('is_delete', 0)
                ->where('company_id', Auth::user()->company_id)
                ->with([
                    'item:id,product_name,sku,reference,barcode,cost_price,selling_price,category_id,tax_id,measure_id',
                    'item.category:id,name',
                    'item.tax:id,name,percentage',
                    'item.measure:id,name',
                    'warehouse:id,warehouse_name',
                    'company:id,name'
                ])
                ->orderBy('id', 'asc');

            // Aplicar filtros si se proporcionan
            if ($request->has('warehouse_id') && !empty($request->warehouse_id)) {
                $query->where('warehouse_id', $request->warehouse_id);
            }

            if ($request->has('category_id') && !empty($request->category_id)) {
                $query->whereHas('item', function($q) use ($request) {
                    $q->where('category_id', $request->category_id);
                });
            }

            $inventory = $query->get();
            
            return Excel::download(new InventoryExport($inventory), 'inventario.xlsx');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar Excel: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de inventario
     */
    public function getInventoryStats()
    {
        try {
            $stats = DB::table('item_warehouse as iw')
                ->join('items as i', 'iw.item_id', '=', 'i.id')
                ->where('iw.is_delete', 0)
                ->where('iw.company_id', Auth::user()->company_id)
                ->selectRaw('
                    COUNT(*) as total_items,
                    SUM(iw.stock) as total_stock,
                    COUNT(CASE WHEN iw.stock <= iw.min_quantity THEN 1 END) as low_stock_items,
                    COUNT(CASE WHEN iw.stock = 0 THEN 1 END) as out_of_stock_items,
                    AVG(iw.stock) as avg_stock
                ')
                ->first();

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Limpiar el caché de inventario de la empresa
     */
    protected function clearInventoryCache($companyId)
    {
        // Solución universal: limpiar todo el caché (¡afecta toda la app!)
        Cache::flush();
    }
}
