<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\CurrenciesModel;
use App\Models\InventoryModel;
use App\Models\InventoryMovementModel;
use App\Models\InvoiceGroup;
use App\Models\ItemMovementModel;
use App\Models\ItemsModel;
use App\Models\ItemsTaxesModel;
use App\Models\ItemWarehouseModel;
use App\Models\ItemWrehouseModel;
use App\Models\MeasureModel;
use App\Models\SubCategory;
use App\Models\TaxesModel;
use App\Models\TypeItemsModel;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;

class ItemsController extends Controller
{
    //
    // public function productList()
    // {
    //     $categories = CategoryModel::all()->pluck('category_name','id');
    //     $warehouses = WarehouseModel::all()->pluck('warehouse_name','id');
    //     $brands = BrandModel::all()->pluck('brand_name', 'id');
    //     $measures = MeasureModel::all()->pluck('measure_name', 'id');
    //     $taxes = TaxesModel::all()->pluck('tax_name', 'id');
    //     $items_type = TypeItemsModel::all()->pluck('name', 'id');
    //     $currencies = CurrenciesModel::all()->pluck('currency_name', 'id');

    //     // currencies

    //    return view('admin.items.list', compact('categories','warehouses','brands',
    //     'measures','taxes','items_type','currencies'));
    // }

    public function productList()
    {
        // Usar cache para datos que no cambian frecuentemente (5 minutos)
        $categories = Cache::remember('categories_list', 300, function () {
            return CategoryModel::all()->pluck('category_name', 'id');
        });
        $subcategories = Cache::remember('subcategories_list', 300, function () {
            return SubCategory::all()->pluck('name', 'id');
        });

        $warehouses = Cache::remember('warehouses_list', 300, function () {
            return WarehouseModel::all()->pluck('warehouse_name', 'id');
        });

        $brands = Cache::remember('brands_list', 300, function () {
            return BrandModel::all()->pluck('brand_name', 'id');
        });

        $measures = Cache::remember('measures_list', 300, function () {
            return MeasureModel::all()->pluck('measure_name', 'id');
        });

        $invoice_groups = Cache::remember('invoice_groups_list', 300, function () {
            return InvoiceGroup::all()->pluck('name', 'id');
        });

        $taxes = Cache::remember('taxes_list', 300, function () {
            return TaxesModel::all()->pluck('tax_name', 'id');
        });

        $items_type = Cache::remember('items_type_list', 300, function () {
            return TypeItemsModel::all()->pluck('name', 'id');
        });

        $currencies = Cache::remember('currencies_list', 300, function () {
            return CurrenciesModel::all()->pluck('currency_name', 'id');
        });

        return view('admin.items.list', compact(
            'categories',
            'subcategories',
            'warehouses',
            'brands',
            'measures',
            'invoice_groups',
            'taxes',
            'items_type',
            'currencies'
        ));
    }

    public function getProducts()
    {
        $items = ItemsModel::with([
            'category:id,category_name',
            'subcategory:id,name',
            'brand:id,brand_name',
            'measure:id,measure_name',
            'invoice_groups:id,name',
            'tax:id,tax_name,rate',
            'items_type:id,name',
            'currencies:id,currency_name'
        ])
            ->select([
                'id', 'item_type_id', 'product_name', 'slug', 'barcode', 'internal_code',
                'sku','reference',    'category_id', 'sub_category_id', 'currency_id',  'expiration_date',
                'description', 'short_description',  'aditional_information',
                'shipping_returns','brand_id','measure_id', 'invoice_group_id',
                'cost_price', 'selling_price','percentage_profit',    'tax_id',
                'price_total',  'status',
                'created_at',
                'updated_at'
            ])
            ->get();

        return response()->json($items);
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',

            'category_id' => 'required|integer',
            'series_enabled' => 'nullable|boolean',
            'batch_management' => 'nullable|boolean',

        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            // Guardar producto
            $product_name = trim($request->product_name);
            $product = new ItemsModel();
            $product->item_type_id = $request->item_type_id;
            $product->product_name = $product_name;
            $product->barcode = $request->barcode;
            $product->internal_code = $request->internal_code;

            $product->sku = $request->sku;
            $product->reference = $request->reference;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->currency_id = $request->currency_id;
            $product->expiration_date = $request->expiration_date;
            // si maneja series
            $product->series_enabled = $request->has('series_enabled') ? 1 : 0; 
            // si maneja lotes
            $product->batch_management = $request->has('batch_management') ? 1 : 0;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->aditional_information = $request->aditional_information;
            $product->shipping_returns = $request->shipping_returns;
            // maneja inventario
           // $product->inventory_enabled=$request->inventory_enabled;
            $product->brand_id = $request->brand_id;
            $product->measure_id = $request->measure_id;
            $product->invoice_group_id = $request->invoice_group_id; // Asegurarse de que este campo exista en el formulario
            $product->cost_price = $request->cost_price;
            $product->selling_price = $request->selling_price;
            $product->percentage_profit = $request->percentage_profit;
            $product->tax_id = $request->tax_id;
            $product->price_total = $request->price_total;
            $product->created_by = Auth::user()->id;
            $product->company_id = Auth::user()->company_id;

            $product->save();
            $slug = Str::slug($product_name, '-');
            $chekSlug = ItemsModel::checkSlug($slug);
            if (empty($chekSlug)) {
                $product->slug = $slug;
                $product->save();
            } else {
                $new_slug = $slug . '-' . $product->id;
                $product->slug = $new_slug;
                $product->save();
            }

            // inserta en tabla intermedia q almacena  itemps con su impuesto
            $itemTaxes = new ItemsTaxesModel();
            $itemTaxes->item_id = $product->id;
            $itemTaxes->tax_id = $request->tax_id;
            $itemTaxes->created_by = Auth::user()->id;
            $itemTaxes->save();


            // Verificar si el tipo de producto no es "Service"
            if ($request->item_type_id !== '2') {
                // Verificar si ya existe un registro para este item en la bodega
                $existingInventory = InventoryModel::where('item_id', $product->id)
                    ->where('warehouse_id', $request->warehouse_id)
                    ->where('is_delete', 0)
                    ->lockForUpdate() // Bloquear el registro para evitar condiciones de carrera
                    ->first();

                if (!$existingInventory) {
                    try {
                        // Verificar nuevamente después de bloquear para evitar condiciones de carrera
                        $doubleCheck = InventoryModel::where('item_id', $product->id)
                            ->where('warehouse_id', $request->warehouse_id)
                            ->where('is_delete', 0)
                            ->first();

                        if (!$doubleCheck) {
                            // Guardar inventario solo si no existe
                            $inventory = new InventoryModel();
                            $inventory->item_id = $product->id;
                            $inventory->warehouse_id = $request->warehouse_id;
                            $inventory->stock = $request->input('stock', 0);
                            $inventory->min_quantity = $request->min_quantity;
                            $inventory->max_quantity = $request->max_quantity;
                            $inventory->reorder_level = $request->reorder_level;
                            $inventory->created_by = Auth::user()->id;
                            $inventory->company_id = Auth::user()->company_id;
                            $inventory->is_delete = 0;
                            $inventory->save();

                            // Registrar el movimiento inicial solo si hay stock y es un nuevo registro
                            if ($request->input('stock', 0) > 0) {
                                // Verificar si ya existe un movimiento inicial para este item
                                $existingMovement = InventoryMovementModel::where('item_id', $product->id)
                                    ->where('warehouse_id', $request->warehouse_id)
                                    ->where('movement_type_id', 1)
                                    ->where('reference_type', 'Nuevo')
                                    ->where('is_delete', 0)
                                    ->first();

                                if (!$existingMovement) {
                                    $itemWarehouse = new InventoryMovementModel();
                                    $itemWarehouse->item_id = $product->id;
                                    $itemWarehouse->warehouse_id = $request->warehouse_id;
                                    $itemWarehouse->quantity = $request->input('stock', 0);
                                    $itemWarehouse->previous_stock = 0;
                                    $itemWarehouse->new_stock = $request->input('stock', 0);
                                    $itemWarehouse->movement_type_id = 1; // Tipo: Entrada inicial
                                    $itemWarehouse->movement_date = now();
                                    $itemWarehouse->reference_type = 'Nuevo';
                                    $itemWarehouse->created_by = Auth::user()->id;
                                    $itemWarehouse->company_id = Auth::user()->company_id;
                                    $itemWarehouse->is_delete = 0;
                                    $itemWarehouse->save();
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        \Log::error('Error al crear inventario: ' . $e->getMessage());
                        throw $e;
                    }
                }
            }

            \Illuminate\Support\Facades\DB::commit();

            return response()->json(['success' => 'Registro Creado con Éxito']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            return response()->json(['error' => 'Error al crear el registro: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $product = ItemsModel::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'item_type_id' => 'required',
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'brand_id' => 'required',
            'measure_id' => 'required',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'tax_id' => 'required',
            'price_total' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $product = ItemsModel::findOrFail($id);
            $product->item_type_id = $request->item_type_id;
            $product->product_name = $request->product_name;
            $product->barcode = $request->barcode;
            $product->internal_code = $request->internal_code;
            $product->sku = $request->sku;
            $product->reference = $request->reference;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->currency_id = $request->currency_id;
            $product->expiration_date = $request->expiration_date;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->aditional_information = $request->aditional_information;
            $product->shipping_returns = $request->shipping_returns;
            $product->brand_id = $request->brand_id;
            $product->measure_id = $request->measure_id;
            $product->invoice_group_id = $request->invoice_group_id; // Asegurarse de que este campo exista en el formulario
            $product->cost_price = $request->cost_price;
            $product->selling_price = $request->selling_price;
            $product->tax_id = $request->tax_id;
            $product->price_total = $request->price_total;
            $product->updated_by = Auth::user()->id;
            $product->save();

            // Actualizar la relación con impuestos
            $itemTax = ItemsTaxesModel::where('item_id', $id)->first();
            if ($itemTax) {
                $itemTax->tax_id = $request->tax_id;
                $itemTax->updated_by = Auth::user()->id;
                $itemTax->save();
            } else {
                $itemTax = new ItemsTaxesModel();
                $itemTax->item_id = $id;
                $itemTax->tax_id = $request->tax_id;
                $itemTax->created_by = Auth::user()->id;
                $itemTax->save();
            }

            DB::commit();
            return response()->json(['success' => 'Registro Actualizado con Éxito']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar el registro: ' . $e->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        $product = ItemsModel::find($id);
        $product->is_delete = 1;
        $product->save();
        return response()->json(['success' => 'Registro Eliminado con Éxito']);
    }

    public function show($id)
    {
        $item = ItemsModel::with('category', 'brand', 'measure', 'tax', 'items_type')->find($id);
        if ($item) {
            return view('admin.items.show', compact('item'));
        } else {
            return redirect()->route('admin.items.list')->with('error', 'Item(producto) no encontrado.');
        }
    }
    public function toggleStatus(Request $request, $id)
    {
        $item = ItemsModel::find($id);
        if ($item) {
            $item->status = $request->status;
            $item->save();
            return response()->json(['success' => 'Estado cambiado exitosamente.']);
        } else {
            return response()->json(['error' => 'Cliente no encontrada.'], 404);
        }
    }

    // searchItems
    public function searchItems(Request $request)
    {
        $query = $request->input('query');

        $items = ItemsModel::where('product_name', 'like', "%{$query}%")
            ->orWhere('barcode', 'like', "%{$query}%")
            ->with(['category', 'tax'])
            ->select('id', 'barcode', 'product_name', 'description', 'cost_price', 'selling_price', 'tax_id', 'category_id')
            ->limit(10)
            ->get();

        // Transform the data to include tax_rate from the relationship
        $transformedItems = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'barcode' => $item->barcode,
                'product_name' => $item->product_name,
                'description' => $item->description,
                'price' => $item->selling_price,
                'cost_price' => $item->cost_price,
                'tax_rate' => $item->tax ? $item->tax->rate : 0,
                'category' => $item->category ? $item->category->category_name : ''
            ];
        });

        return response()->json($transformedItems);
    }
    public function checkBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        $barcode = ItemsModel::where('barcode', $barcode)->first();
        if ($barcode) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    public function checkInternalCode(Request $request)
    {
        $internalCode = $request->input('internal_code');
        $internalCode = ItemsModel::where('internal_code', $internalCode)->first();
        if ($internalCode) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function fetch(Request $request)
    {
        $items = ItemsModel::with(['category', 'measure', 'tax'])
            ->where('is_delete', 0)
            ->select(['id', 'barcode', 'product_name', 'category_id', 'measure_id', 'cost_price', 'selling_price', 'tax_id', 'status', 'created_at', 'updated_at'])
            ->orderBy('id', 'desc');

        return DataTables::of($items)
            ->addColumn('profit', function ($item) {
                return $item->selling_price - $item->cost_price;
            })
            ->addColumn('selling_price_with_tax', function ($item) {
                return $item->selling_price * (1 + ($item->tax->tax_percentage / 100));
            })
            ->addColumn('action', function ($item) {
                return view('admin.items.actions', ['item' => $item])->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Get items by warehouse with inventory information
     */
    public function itemsByWarehouse(Request $request)
    {
        try {
            $warehouse_id = $request->input('warehouse_id');
            $search = $request->input('search', '');

            if (!$warehouse_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse ID is required',
                    'data' => []
                ], 400);
            }

            // Base query for items with inventory in the specified warehouse
            $query = ItemsModel::with([
                'category:id,category_name',
                'brand:id,brand_name',
                'measure:id,measure_name',
                'tax:id,tax_name,rate',
                'items_type:id,name'
            ])
                ->join('item_warehouse', 'items.id', '=', 'item_warehouse.item_id')
                ->where('items.is_delete', 0)
                ->where('item_warehouse.is_delete', 0)
                ->where('item_warehouse.warehouse_id', $warehouse_id)
                ->where('items.item_type_id', '!=', 2) // Exclude services
                ->select([
                    'items.id',
                    'items.barcode',
                    'items.internal_code',
                    'items.sku',
                    'items.product_name',
                    'items.description',
                    'items.cost_price',
                    'items.selling_price',
                    'items.category_id',
                    'items.brand_id',
                    'items.measure_id',
                    'items.tax_id',
                    'items.item_type_id',
                    'items.status',
                    'item_warehouse.stock',
                    'item_warehouse.min_quantity',
                    'item_warehouse.max_quantity',
                    'item_warehouse.reorder_level'
                ]);

            // Apply search filter if provided
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('items.product_name', 'like', "%{$search}%")
                        ->orWhere('items.barcode', 'like', "%{$search}%")
                        ->orWhere('items.internal_code', 'like', "%{$search}%")
                        ->orWhere('items.sku', 'like', "%{$search}%");
                });
            }

            // Get items with pagination support
            $perPage = $request->input('per_page', 50);
            $items = $query->orderBy('items.product_name', 'asc')
                ->paginate($perPage);

            // Transform the data to include calculated fields
            $transformedItems = $items->getCollection()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'code' => $item->barcode ?: $item->internal_code ?: $item->sku,
                    'barcode' => $item->barcode,
                    'internal_code' => $item->internal_code,
                    'sku' => $item->sku,
                    'name' => $item->product_name,
                    'description' => $item->description,
                    'cost' => (float) $item->cost_price,
                    'price' => (float) $item->selling_price,
                    'stock' => (float) $item->stock,
                    'min_quantity' => (float) $item->min_quantity,
                    'max_quantity' => (float) $item->max_quantity,
                    'reorder_level' => (float) $item->reorder_level,
                    'category' => $item->category ? $item->category->category_name : null,
                    'brand' => $item->brand ? $item->brand->brand_name : null,
                    'measure' => $item->measure ? $item->measure->measure_name : null,
                    'tax_rate' => $item->tax ? (float) $item->tax->rate : 0,
                    'tax_name' => $item->tax ? $item->tax->tax_name : null,
                    'item_type' => $item->items_type ? $item->items_type->name : null,
                    'status' => $item->status,
                    'is_low_stock' => $item->stock <= $item->reorder_level,
                    'stock_status' => $this->getStockStatus($item->stock, $item->min_quantity, $item->reorder_level),
                    'formatted_cost' => number_format($item->cost_price, 2),
                    'formatted_price' => number_format($item->selling_price, 2),
                    'profit_margin' => $item->selling_price > 0 ?
                        round((($item->selling_price - $item->cost_price) / $item->selling_price) * 100, 2) : 0
                ];
            });

            // Update the collection in the paginator
            $items->setCollection($transformedItems);

            return response()->json([
                'success' => true,
                'message' => 'Items retrieved successfully',
                'data' => $transformedItems,
                'pagination' => [
                    'current_page' => $items->currentPage(),
                    'last_page' => $items->lastPage(),
                    'per_page' => $items->perPage(),
                    'total' => $items->total(),
                    'from' => $items->firstItem(),
                    'to' => $items->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in itemsByWarehouse: ' . $e->getMessage(), [
                'warehouse_id' => $warehouse_id ?? null,
                'search' => $search ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving items: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Get stock status based on current stock and thresholds
     */
    private function getStockStatus($currentStock, $minQuantity, $reorderLevel)
    {
        if ($currentStock <= 0) {
            return 'out_of_stock';
        } elseif ($currentStock <= $reorderLevel) {
            return 'low_stock';
        } elseif ($currentStock <= $minQuantity) {
            return 'warning';
        } else {
            return 'in_stock';
        }
    }

    /**
     * Get items by warehouse for select dropdown (simplified version)
     */
    public function itemsByWarehouseSimple(Request $request)
    {
        try {
            $warehouse_id = $request->input('warehouse_id');
            $search = $request->input('search', '');

            if (!$warehouse_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse ID is required',
                    'data' => []
                ], 400);
            }

            $query = ItemsModel::join('item_warehouse', 'items.id', '=', 'item_warehouse.item_id')
                ->where('items.is_delete', 0)
                ->where('item_warehouse.is_delete', 0)
                ->where('item_warehouse.warehouse_id', $warehouse_id)
                ->where('items.item_type_id', '!=', 2) // Exclude services
                ->where('items.status', 1) // Only active items
                ->select([
                    'items.id',
                    'items.barcode',
                    'items.internal_code',
                    'items.sku',
                    'items.product_name',
                    'items.cost_price',
                    'item_warehouse.stock'
                ]);

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('items.product_name', 'like', "%{$search}%")
                        ->orWhere('items.barcode', 'like', "%{$search}%")
                        ->orWhere('items.internal_code', 'like', "%{$search}%")
                        ->orWhere('items.sku', 'like', "%{$search}%");
                });
            }

            $items = $query->orderBy('items.product_name', 'asc')
                ->limit(100)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'code' => $item->barcode ?: $item->internal_code ?: $item->sku,
                        'name' => $item->product_name,
                        'cost' => (float) $item->cost_price,
                        'stock' => (float) $item->stock,
                        'display_name' => $item->product_name . ' (' . ($item->barcode ?: $item->internal_code ?: $item->sku) . ')'
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $items
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in itemsByWarehouseSimple: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving items',
                'data' => []
            ], 500);
        }
    }

    /**
     * Get item details with inventory for a specific warehouse
     */
    public function getItemByWarehouse(Request $request)
    {
        try {
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');

            if (!$item_id || !$warehouse_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item ID and Warehouse ID are required'
                ], 400);
            }

            $item = ItemsModel::with([
                'category:id,category_name',
                'brand:id,brand_name',
                'measure:id,measure_name',
                'tax:id,tax_name,rate'
            ])
                ->join('item_warehouse', 'items.id', '=', 'item_warehouse.item_id')
                ->where('items.id', $item_id)
                ->where('item_warehouse.warehouse_id', $warehouse_id)
                ->where('items.is_delete', 0)
                ->where('item_warehouse.is_delete', 0)
                ->select([
                    'items.*',
                    'item_warehouse.stock',
                    'item_warehouse.min_quantity',
                    'item_warehouse.max_quantity',
                    'item_warehouse.reorder_level'
                ])
                ->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in the specified warehouse'
                ], 404);
            }

            $itemData = [
                'id' => $item->id,
                'code' => $item->barcode ?: $item->internal_code ?: $item->sku,
                'barcode' => $item->barcode,
                'internal_code' => $item->internal_code,
                'sku' => $item->sku,
                'name' => $item->product_name,
                'description' => $item->description,
                'cost' => (float) $item->cost_price,
                'price' => (float) $item->selling_price,
                'stock' => (float) $item->stock,
                'min_quantity' => (float) $item->min_quantity,
                'max_quantity' => (float) $item->max_quantity,
                'reorder_level' => (float) $item->reorder_level,
                'category' => $item->category ? $item->category->category_name : null,
                'brand' => $item->brand ? $item->brand->brand_name : null,
                'measure' => $item->measure ? $item->measure->measure_name : null,
                'tax_rate' => $item->tax ? (float) $item->tax->rate : 0,
                'stock_status' => $this->getStockStatus($item->stock, $item->min_quantity, $item->reorder_level)
            ];

            return response()->json([
                'success' => true,
                'data' => $itemData
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getItemByWarehouse: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving item details'
            ], 500);
        }
    }

    /**
     * Search products by term in a specific warehouse
     */
    public function searchProducts(Request $request)
    {
        try {
            $warehouse_id = $request->input('warehouse_id');
            $search = $request->input('search', '');

            if (!$warehouse_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse ID is required',
                    'data' => []
                ], 400);
            }

            if (empty($search)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search term is required',
                    'data' => []
                ], 400);
            }

            // Search products in the specified warehouse
            $query = ItemsModel::with([
                'category:id,category_name',
                'brand:id,brand_name',
                'measure:id,measure_name',
                'tax:id,tax_name,rate'
            ])
                ->join('item_warehouse', 'items.id', '=', 'item_warehouse.item_id')
                ->where('items.is_delete', 0)
                ->where('item_warehouse.is_delete', 0)
                ->where('item_warehouse.warehouse_id', $warehouse_id)
                ->where('items.item_type_id', '!=', 2) // Exclude services
                ->where('items.status', 1) // Only active items
                ->select([
                    'items.id',
                    'items.barcode',
                    'items.internal_code',
                    'items.sku',
                    'items.product_name',
                    'items.description',
                    'items.cost_price',
                    'items.selling_price',
                    'items.category_id',
                    'items.brand_id',
                    'items.measure_id',
                    'items.tax_id',
                    'item_warehouse.stock',
                    'item_warehouse.min_quantity',
                    'item_warehouse.max_quantity',
                    'item_warehouse.reorder_level'
                ]);

            // Apply search filters
            $query->where(function ($q) use ($search) {
                $q->where('items.product_name', 'like', "%{$search}%")
                    ->orWhere('items.barcode', 'like', "%{$search}%")
                    ->orWhere('items.internal_code', 'like', "%{$search}%")
                    ->orWhere('items.sku', 'like', "%{$search}%")
                    ->orWhere('items.description', 'like', "%{$search}%");
            });

            $items = $query->orderBy('items.product_name', 'asc')
                ->limit(20) // Limit results for performance
                ->get();

            \Log::info('Search products query result count: ' . $items->count());
            \Log::info('Search parameters', ['warehouse_id' => $warehouse_id, 'search' => $search]);

            // Transform the data
            $transformedItems = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'code' => $item->barcode ?: $item->internal_code ?: $item->sku,
                    'barcode' => $item->barcode,
                    'internal_code' => $item->internal_code,
                    'sku' => $item->sku,
                    'name' => $item->product_name,
                    'product_name' => $item->product_name,
                    'description' => $item->description,
                    'cost' => (float) $item->cost_price,
                    'cost_price' => (float) $item->cost_price,
                    'price' => (float) $item->selling_price,
                    'selling_price' => (float) $item->selling_price,
                    'stock' => (float) $item->stock,
                    'min_quantity' => (float) $item->min_quantity,
                    'max_quantity' => (float) $item->max_quantity,
                    'reorder_level' => (float) $item->reorder_level,
                    'category' => $item->category ? $item->category->category_name : null,
                    'brand' => $item->brand ? $item->brand->brand_name : null,
                    'measure' => $item->measure ? $item->measure->measure_name : null,
                    'tax_rate' => $item->tax ? (float) $item->tax->rate : 0,
                    'tax_name' => $item->tax ? $item->tax->tax_name : null,
                    'is_low_stock' => $item->stock <= $item->reorder_level,
                    'stock_status' => $this->getStockStatus($item->stock, $item->min_quantity, $item->reorder_level),
                    'formatted_cost' => number_format($item->cost_price, 2),
                    'formatted_price' => number_format($item->selling_price, 2),
                    'display_name' => $item->product_name . ' (' . ($item->barcode ?: $item->internal_code ?: $item->sku) . ')'
                ];
            });

            \Log::info('Transformed items count: ' . $transformedItems->count());
            \Log::info('First few items: ', $transformedItems->take(2)->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Products found successfully',
                'data' => $transformedItems,
                'count' => $transformedItems->count(),
                'search_term' => $search
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in searchProducts: ' . $e->getMessage(), [
                'warehouse_id' => $warehouse_id ?? null,
                'search' => $search ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error searching products: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

       public function getSubcategories(Request $request) {
        $categoryId = $request->input('category_id'); // Obtener el ID del departamento desde la solicitud
        // Obtener las ciudades que pertenecen al departamento seleccionado
        $subcategories = SubCategory::where('category_id', $categoryId)->pluck('name', 'id');
        // Devolver las ciudades en formato JSON
        return response()->json(['subcategories' => $subcategories]);
    }
}
