<?php

namespace App\Http\Controllers;

use App\Models\InventoryAdjustment;
use App\Models\InventoryAdjustmentDetail;
use App\Models\WarehouseModel;
use App\Models\AdjustmentType;
use App\Models\AdjustmentReason;
use App\Models\ItemsModel;
use App\Models\InventoryModel;
use App\Models\InventoryMovementModel;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;




class InventoryAjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        return view('admin.inventory_ajusts.list');
    }

    public function getInventoryAjusts(Request $request)
    {
        $query = InventoryAdjustment::with(['warehouse', 'adjustmentType', 'reasonAdjustment', 'createdBy', 'userApproval'])
            ->orderBy('id', 'desc');

        // Apply date from filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('adjustment_date', '>=', $request->date_from);
        }

        // Apply date to filter
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('adjustment_date', '<=', $request->date_to);
        }


        $inventoryAdjustment = $query->get()->where('is_delete', '=', 0);
        return response()->json($inventoryAdjustment);
    }


    public function create()
    {
        $data['warehouses'] = WarehouseModel::where('is_delete', '=', 0)->get();
        $data['adjustmentTypes'] = AdjustmentType::where('is_delete', '=', 0)->get();
        $data['reasonAdjustments'] = AdjustmentReason::where('is_delete', '=', 0)->get();
        return view('admin.inventory_ajusts.add', $data);
    }
    public function getItemsWithCache(Request $request)
    {
        try {
            $term = $request->input('term');

            if (empty($term) || strlen($term) < 2) {
                return response()->json([
                    'message' => 'El término de búsqueda debe tener al menos 2 caracteres.',
                    'data' => []
                ], 400);
            }

            $term = trim($term);
            $cacheKey = 'items_search_' . md5($term);

            // Intentar obtener desde caché (válido por 10 minutos)
            $result = Cache::remember($cacheKey, 600, function () use ($term) {
                $searchTerm = "%{$term}%";

                return ItemsModel::select([
                    'items.id',
                    'items.internal_code',
                    'items.barcode',
                    'items.product_name',
                    'items.selling_price',
                    'items.cost_price',
                    'taxes.rate as tax_rate',
                    'categories.category_name',
                    DB::raw('(SELECT COALESCE(SUM(iw.stock), 0) FROM item_warehouse iw WHERE iw.item_id = items.id) as total_stock')
                ])
                    ->leftJoin('taxes', 'items.tax_id', '=', 'taxes.id')
                    ->leftJoin('categories', 'items.category_id', '=', 'categories.id')
                    ->where(function ($query) use ($searchTerm) {
                        $query->where('items.product_name', 'like', $searchTerm)
                            ->orWhere('items.barcode', 'like', $searchTerm)
                            ->orWhere('items.internal_code', 'like', $searchTerm);
                    })
                    ->where('items.active', true)
                    ->orderBy('items.product_name')
                    ->limit(100)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'code' => $item->internal_code ?? $item->barcode,
                            'name' => $item->product_name,
                            'sale_price' => (float) $item->selling_price,
                            'cost_price' => (float) $item->cost_price,
                            'stock' => (int) $item->total_stock,
                            'tax_rate' => $item->tax_rate ? (float) $item->tax_rate : 0.0,
                            'category' => $item->category_name ?? ''
                        ];
                    });
            });

            return response()->json([
                'message' => 'Items obtenidos exitosamente.',
                'data' => $result,
                'total' => $result->count()
            ], 200, [
                'Content-Type' => 'application/json; charset=utf-8'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getItemsWithCache: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error interno del servidor.',
                'error' => config('app.debug') ? $e->getMessage() : 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate main adjustment data
        $validatedData = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'adjustment_type_id' => 'required|exists:adjustment_types,id',
            'reason_adjustment_id' => 'nullable|exists:adjustment_reason,id',
            'adjustment_date' => 'required|date',
            'comments' => 'nullable|string|max:65535',
            'support_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'products_data' => 'required|string', // JSON string of products
            'save_as_draft' => 'nullable|boolean'
        ]);

        // Validate and decode products data
        $productsData = json_decode($request->products_data, true);

        if (!$productsData || !is_array($productsData) || empty($productsData)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Debe agregar al menos un producto al ajuste.');
        }

        DB::beginTransaction();
        try {
            // Generate adjustment number automatically
            $adjustmentNumber = InventoryAdjustment::generateAdjustmentNumber();

            // Calculate total value from products
            $totalValue = 0;
            foreach ($productsData as $product) {
                $adjustmentQuantity = floatval($product['adjustment_quantity'] ?? 0);
                $unitCost = floatval($product['unit_cost'] ?? 0);
                $totalValue += abs($adjustmentQuantity) * $unitCost;
            }

            // Prepare adjustment data
            $adjustmentData = [
                'adjustment_number' => $adjustmentNumber,
                'warehouse_id' => $validatedData['warehouse_id'],
                'adjustment_type_id' => $validatedData['adjustment_type_id'],
                'reason_adjustment_id' => $validatedData['reason_adjustment_id'],
                'adjustment_date' => $validatedData['adjustment_date'],
                'comments' => $validatedData['comments'],
                'total_value' => $totalValue,
                'status' => $request->save_as_draft ? 'draft' : 'pending',
                'created_by' => Auth::id(),
                'company_id' => Auth::user()->company_id,
            ];

            // Handle support document upload
            if ($request->hasFile('support_document')) {
                $file = $request->file('support_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('inventory-adjustments', $filename, 'public');
                $adjustmentData['support_document'] = $path;
            }

            // Create the main adjustment record
            $adjustment = InventoryAdjustment::create($adjustmentData);

            // Create adjustment details for each product
            foreach ($productsData as $product) {
                $adjustmentQuantity = floatval($product['adjustment_quantity'] ?? 0);
                $currentStock = floatval($product['current_stock'] ?? 0);
                $unitCost = floatval($product['unit_cost'] ?? 0);

                // Skip products with zero adjustment quantity
                if ($adjustmentQuantity == 0) {
                    continue;
                }

                // Validate product data before creating detail
                if (empty($product['id'])) {
                    \Log::error('Product ID is empty when creating adjustment detail', [
                        'product_data' => $product,
                        'adjustment_id' => $adjustment->id
                    ]);
                    throw new \Exception('Product ID is required for adjustment detail');
                }

                // Debug logging before creating adjustment detail
                \Log::info('Creating adjustment detail', [
                    'adjustment_id' => $adjustment->id,
                    'item_id' => $product['id'],
                    'system_quantity' => $currentStock,
                    'physical_quantity' => $currentStock + $adjustmentQuantity,
                    'unit_cost' => $unitCost,
                    'product_data' => $product
                ]);

                // Create adjustment detail
                $detail = InventoryAdjustmentDetail::create([
                    'inventory_adjustment_id' => $adjustment->id,
                    'item_id' => $product['id'],
                    'system_quantity' => $currentStock,
                    'physical_quantity' => $currentStock + $adjustmentQuantity,
                    'unit_cost' => $unitCost,
                    'batch' => $product['batch'] ?? null,
                    'expiration_date' => $product['expiration_date'] ?? null,
                    'comments' => $product['comments'] ?? null,
                    'created_by' => Auth::id(),
                    'company_id' => Auth::user()->company_id,
                ]);

                \Log::info('Adjustment detail created', [
                    'detail_id' => $detail->id,
                    'detail_item_id' => $detail->item_id,
                    'detail_data' => $detail->toArray()
                ]);

                // If adjustment is not draft, update inventory immediately
                if (!$request->save_as_draft) {
                    // Debug logging before calling updateInventoryStock
                    \Log::info('About to call updateInventoryStock from store method', [
                        'product_id' => $product['id'],
                        'warehouse_id' => $validatedData['warehouse_id'],
                        'adjustment_quantity' => $adjustmentQuantity,
                        'adjustment_id' => $adjustment->id,
                        'product_data' => $product
                    ]);

                    $this->updateInventoryStock(
                        $product['id'],
                        $validatedData['warehouse_id'],
                        $adjustmentQuantity,
                        $adjustment->id
                    );
                }
            }
            // Log the adjustment creation
            \Log::info('Inventory adjustment created', [
                'adjustment_id' => $adjustment->id,
                'adjustment_number' => $adjustmentNumber,
                'products_count' => count($productsData),
                'total_value' => $totalValue,
                'status' => $adjustmentData['status'],
                'created_by' => Auth::id()
            ]);

            DB::commit();
            $message = $request->save_as_draft
                ? 'Ajuste de inventario guardado como borrador exitosamente.'
                : 'Ajuste de inventario creado exitosamente.';

            return redirect()
                ->route('admin.inventory_ajusts.show', $adjustment->id)
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded file if exists
            if (isset($adjustmentData['support_document'])) {
                Storage::disk('public')->delete($adjustmentData['support_document']);
            }

            \Log::error('Error creating inventory adjustment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['support_document'])
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el ajuste de inventario: ' . $e->getMessage());
        }
    }

    /**
     * Update inventory stock for a specific item in a warehouse
     */
    private function updateInventoryStock($itemId, $warehouseId, $adjustmentQuantity, $adjustmentId)
    {
        try {
            // Debug logging to check parameters
            \Log::info('updateInventoryStock called with parameters', [
                'item_id' => $itemId,
                'warehouse_id' => $warehouseId,
                'adjustment_quantity' => $adjustmentQuantity,
                'adjustment_id' => $adjustmentId,
                'item_id_type' => gettype($itemId),
                'warehouse_id_type' => gettype($warehouseId)
            ]);

            // Validate parameters
            if (empty($itemId) || empty($warehouseId)) {
                \Log::error('Invalid parameters for updateInventoryStock', [
                    'item_id' => $itemId,
                    'warehouse_id' => $warehouseId,
                    'adjustment_id' => $adjustmentId
                ]);
                throw new \Exception('Item ID and Warehouse ID are required');
            }
            // Find the inventory record
            $inventory = \App\Models\InventoryModel::where('item_id', $itemId)
                ->where('warehouse_id', $warehouseId)
                ->where('is_delete', 0)
                ->first();

            if ($inventory) {
                // Update the stock
                $newStock = $inventory->stock + $adjustmentQuantity;
                $inventory->update(['stock' => max(0, $newStock)]); // Prevent negative stock

                // Create inventory movement record
                \App\Models\InventoryMovementModel::create([
                    'item_id' => $itemId,
                    'warehouse_id' => $warehouseId,
                    'movement_type_id' => $adjustmentQuantity > 0 ? 1 : 2, // 1 = Entry, 2 = Exit
                    'quantity' => abs($adjustmentQuantity),
                    'previous_stock' => $inventory->stock - $adjustmentQuantity,
                    'new_stock' => $newStock,
                    'movement_date' => now(),
                    'reference_type' => 'Ajuste',
                    'reference_id' => $adjustmentId, // Reference to the adjustment record
                    'created_by' => Auth::id(),
                    'company_id' => Auth::user()->company_id,
                    'is_delete' => 0
                ]);

                \Log::info('Inventory updated', [
                    'adjustment_id' => $adjustmentId,
                    'item_id' => $itemId,
                    'warehouse_id' => $warehouseId,
                    'adjustment_quantity' => $adjustmentQuantity,
                    'previous_stock' => $inventory->stock - $adjustmentQuantity,
                    'new_stock' => $newStock
                ]);
            } else {
                \Log::warning('Inventory record not found', [
                    'adjustment_id' => $adjustmentId,
                    'item_id' => $itemId,
                    'warehouse_id' => $warehouseId
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error updating inventory stock', [
                'adjustment_id' => $adjustmentId,
                'item_id' => $itemId,
                'warehouse_id' => $warehouseId,
                'adjustment_quantity' => $adjustmentQuantity,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $inventoryAdjustment = InventoryAdjustment::with([
            'warehouse',
            'adjustmentType',
            'reasonAdjustment',
            'createdBy',
            'userApproval',
            'company',
            'adjustmentDetails.item'
        ])->findOrFail($id);

        return view('admin.inventory_ajusts.show', compact('inventoryAdjustment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryAdjustment $inventoryAdjustment): View
    {
        // Verificar si puede ser editado
        if (!$inventoryAdjustment->canBeEdited()) {
            abort(403, 'Este ajuste no puede ser editado en su estado actual.');
        }

        $warehouses = WarehouseModel::select('id', 'warehouse_name')->get();
        $adjustmentTypes = AdjustmentType::select('id', 'name')->get();
        $reasonAdjustments = AdjustmentReason::select('id', 'name')->get();

        return view('inventory-adjustments.edit', compact(
            'inventoryAdjustment',
            'warehouses',
            'adjustmentTypes',
            'reasonAdjustments'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryAdjustment $inventoryAdjustment): RedirectResponse
    {
        // Verificar si puede ser editado
        if (!$inventoryAdjustment->canBeEdited()) {
            return redirect()
                ->back()
                ->with('error', 'Este ajuste no puede ser editado en su estado actual.');
        }

        $validatedData = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'adjustment_type_id' => 'required|exists:adjustment_types,id',
            'reason_adjustment_id' => 'nullable|exists:adjustment_reason,id',
            'adjustment_date' => 'required|date',
            'comments' => 'nullable|string|max:65535',
            'support_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'total_value' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Manejar archivo de soporte
            if ($request->hasFile('support_document')) {
                // Eliminar archivo anterior si existe
                if ($inventoryAdjustment->support_document) {
                    Storage::disk('public')->delete($inventoryAdjustment->support_document);
                }

                $file = $request->file('support_document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('inventory-adjustments', $filename, 'public');
                $validatedData['support_document'] = $path;
            }

            $inventoryAdjustment->update($validatedData);

            DB::commit();

            return redirect()
                ->route('inventory-adjustments.show', $inventoryAdjustment)
                ->with('success', 'Ajuste de inventario actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el ajuste de inventario: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryAdjustment $inventoryAdjustment): RedirectResponse
    {
        // Solo permitir eliminar si está en borrador
        if (!$inventoryAdjustment->isDraft()) {
            return redirect()
                ->back()
                ->with('error', 'Solo se pueden eliminar ajustes en estado borrador.');
        }

        try {
            // Eliminar archivo de soporte si existe
            if ($inventoryAdjustment->support_document) {
                Storage::disk('public')->delete($inventoryAdjustment->support_document);
            }

            $inventoryAdjustment->delete();

            return redirect()
                ->route('inventory-adjustments.index')
                ->with('success', 'Ajuste de inventario eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el ajuste de inventario: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar estado del ajuste
     */
    public function changeStatus(Request $request, InventoryAdjustment $inventoryAdjustment): JsonResponse
    {
        $request->validate([
            'status' => [
                'required',
                Rule::in([
                    InventoryAdjustment::STATUS_PENDING,
                    InventoryAdjustment::STATUS_APPROVED,
                    InventoryAdjustment::STATUS_REJECTED,
                    InventoryAdjustment::STATUS_APPLIED
                ])
            ],
            'comments' => 'nullable|string|max:65535'
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $inventoryAdjustment->status;
            $newStatus = $request->status;

            // Validar transiciones de estado
            if (!$this->isValidStatusTransition($oldStatus, $newStatus)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transición de estado no válida.'
                ], 400);
            }

            // Actualizar el ajuste
            $updateData = ['status' => $newStatus];

            // Si se aprueba o rechaza, registrar quien lo hizo y cuándo
            if (in_array($newStatus, [InventoryAdjustment::STATUS_APPROVED, InventoryAdjustment::STATUS_REJECTED])) {
                $updateData['user_approval_id'] = Auth::id();
                $updateData['approval_date'] = now();
            }

            // Actualizar comentarios si se proporcionan
            if ($request->filled('comments')) {
                $updateData['comments'] = $request->comments;
            }

            $inventoryAdjustment->update($updateData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente.',
                'data' => [
                    'status' => $inventoryAdjustment->status,
                    'status_label' => $inventoryAdjustment->status_label
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validar transiciones de estado válidas
     */
    // private function isValidStatusTransition(string $currentStatus, string $newStatus): bool
    // {
    //     $validTransitions = [
    //         InventoryAdjustment::STATUS_DRAFT => [
    //             InventoryAdjustment::STATUS_PENDING
    //         ],
    //         InventoryAdjustment::STATUS_PENDING => [
    //             InventoryAdjustment::STATUS_APPROVED,
    //             InventoryAdjustment::STATUS_REJECTED
    //         ],
    //         InventoryAdjustment::STATUS_APPROVED => [
    //             InventoryAdjustment::STATUS_APPLIED
    //         ],
    //         InventoryAdjustment::STATUS_REJECTED => [
    //             InventoryAdjustment::STATUS_PENDING
    //         ]
    //     ];

    //     return in_array($newStatus, $validTransitions[$currentStatus] ?? []);
    // }

    /**
     * Obtener datos para dashboard/reportes
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total' => InventoryAdjustment::count(),
            'draft' => InventoryAdjustment::draft()->count(),
            'pending' => InventoryAdjustment::pending()->count(),
            'approved' => InventoryAdjustment::approved()->count(),
            'applied' => InventoryAdjustment::applied()->count(),
            'rejected' => InventoryAdjustment::rejected()->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Approve an adjustment
     */
    public function approve(Request $request, $id): JsonResponse
    {
        try {
            $adjustment = InventoryAdjustment::findOrFail($id);

            if ($adjustment->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden aprobar ajustes en estado pendiente.'
                ], 400);
            }

            $adjustment->update([
                'status' => 'approved',
                'user_approval_id' => Auth::id(),
                'approval_date' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ajuste aprobado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar el ajuste: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete adjustments
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron ajustes para eliminar.'
                ], 400);
            }

            $adjustments = InventoryAdjustment::whereIn('id', $ids)->get();

            foreach ($adjustments as $adjustment) {
                if ($adjustment->status !== 'draft') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Solo se pueden eliminar ajustes en estado borrador.'
                    ], 400);
                }
            }

            InventoryAdjustment::whereIn('id', $ids)->update(['is_delete' => 1]);

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' ajuste(s) eliminado(s) exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar los ajustes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk approve adjustments
     */
    public function bulkApprove(Request $request): JsonResponse
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron ajustes para aprobar.'
                ], 400);
            }

            $adjustments = InventoryAdjustment::whereIn('id', $ids)->get();

            foreach ($adjustments as $adjustment) {
                if ($adjustment->status !== 'pending') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Solo se pueden aprobar ajustes en estado pendiente.'
                    ], 400);
                }
            }

            InventoryAdjustment::whereIn('id', $ids)->update([
                'status' => 'approved',
                'user_approval_id' => Auth::id(),
                'approval_date' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' ajuste(s) aprobado(s) exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar los ajustes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Print PDF for adjustment
     */
    public function printPdf($id)
    {
        try {
            $adjustment = InventoryAdjustment::with([
                'warehouse',
                'adjustmentType',
                'reasonAdjustment',
                'createdBy',
                'userApproval'
            ])->findOrFail($id);

            // Here you would generate the PDF
            // For now, return a simple response
            return response()->json([
                'success' => true,
                'message' => 'PDF generation not implemented yet.',
                'data' => $adjustment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export to Excel
     */
    public function exportExcel()
    {
        // Implementation for Excel export
        return response()->json([
            'success' => true,
            'message' => 'Excel export not implemented yet.'
        ]);
    }

    /**
     * Export to PDF
     */
    public function exportPdf()
    {
        // Implementation for PDF export
        return response()->json([
            'success' => true,
            'message' => 'PDF export not implemented yet.'
        ]);
    }

    /**
     * Export to CSV
     */
    public function exportCsv()
    {
        // Implementation for CSV export
        return response()->json([
            'success' => true,
            'message' => 'CSV export not implemented yet.'
        ]);
    }

    /**
     * Update adjustment status
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected,applied',
                'comments' => 'nullable|string|max:65535'
            ]);

            $adjustment = InventoryAdjustment::with('adjustmentDetails')->findOrFail($id);

            // Check if status transition is valid
            $currentStatus = $adjustment->status;
            $newStatus = $request->status;

            if (!$this->isValidStatusTransition($currentStatus, $newStatus)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transición de estado no válida.'
                ], 400);
            }

            DB::beginTransaction();

            // Update adjustment data
            $updateData = [
                'status' => $newStatus
            ];

            // If approving or rejecting, record who did it and when
            if (in_array($newStatus, ['approved', 'rejected'])) {
                $updateData['user_approval_id'] = Auth::id();
                $updateData['approval_date'] = now();
            }

            // Add comments if provided
            if ($request->filled('comments')) {
                $updateData['comments'] = $adjustment->comments . "\n\n" .
                    "[" . now()->format('d/m/Y H:i') . " - " . Auth::user()->name . "]: " .
                    $request->comments;
            }

            $adjustment->update($updateData);

            // If approving, update inventory
            if ($newStatus === 'approved' && $currentStatus !== 'approved') {
                \Log::info('Starting inventory update for approval', [
                    'adjustment_id' => $adjustment->id,
                    'adjustment_details_count' => $adjustment->adjustmentDetails->count(),
                    'warehouse_id' => $adjustment->warehouse_id
                ]);

                foreach ($adjustment->adjustmentDetails as $detail) {
                    $adjustmentQuantity = $detail->physical_quantity - $detail->system_quantity;
                    if ($adjustmentQuantity != 0) {
                        // Debug logging before calling updateInventoryStock
                        \Log::info('About to call updateInventoryStock from updateStatus method', [
                            'detail_item_id' => $detail->item_id,
                            'adjustment_warehouse_id' => $adjustment->warehouse_id,
                            'adjustment_quantity' => $adjustmentQuantity,
                            'adjustment_id' => $adjustment->id,
                            'detail_data' => $detail->toArray()
                        ]);

                        $this->updateInventoryStock(
                            $detail->item_id,
                            $adjustment->warehouse_id,
                            $adjustmentQuantity,
                            $adjustment->id
                        );
                    }
                }
            }

            DB::commit();

            $statusLabels = [
                'pending' => 'Pendiente',
                'approved' => 'Aprobado',
                'rejected' => 'Rechazado',
                'applied' => 'Aplicado'
            ];

            return response()->json([
                'success' => true,
                'message' => "Ajuste marcado como {$statusLabels[$newStatus]} exitosamente.",
                'data' => [
                    'status' => $newStatus,
                    'status_label' => $statusLabels[$newStatus]
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error updating adjustment status', [
                'adjustment_id' => $id,
                'new_status' => $request->status ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if status transition is valid
     */
    private function isValidStatusTransition($currentStatus, $newStatus): bool
    {
        $validTransitions = [
            'draft' => ['pending'],
            'pending' => ['approved', 'rejected'],
            'approved' => ['applied'],
            'rejected' => ['pending'],
            'applied' => [] // Final state
        ];

        return in_array($newStatus, $validTransitions[$currentStatus] ?? []);
    }
}
