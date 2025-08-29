/**
 * Save a new product from POS interface
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
public function saveProduct(Request $request)
{
    try {
        // Validate request
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create new product
        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_code = $request->product_code ?? $this->generateProductCode();
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->cost_price = $request->cost_price;
        $product->selling_price = $request->selling_price;
        $product->tax_id = $request->tax_id;
        $product->description = $request->description;
        $product->status = 1; // Active
        $product->save();

        // Add initial stock if provided
        if ($request->has('initial_stock') && $request->initial_stock > 0) {
            $inventory = new Inventory();
            $inventory->product_id = $product->id;
            $inventory->warehouse_id = $request->warehouse_id;
            $inventory->quantity = $request->initial_stock;
            $inventory->save();
        }

        // Calculate tax amount if applicable
        $taxAmount = 0;
        if ($request->tax_id) {
            $tax = Tax::find($request->tax_id);
            if ($tax) {
                $taxAmount = ($request->selling_price * $tax->rate) / 100;
            }
        }

        // Load relationships
        $product->load('category', 'unit', 'tax');

        return response()->json([
            'success' => true,
            'message' => 'Product saved successfully',
            'product' => $product,
            'tax_amount' => $taxAmount
        ]);
    } catch (\Exception $e) {
        \Log::error('Error saving product: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error saving product: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Generate a unique product code
 *
 * @return string
 */
private function generateProductCode()
{
    $prefix = 'P';
    $lastProduct = Product::orderBy('id', 'desc')->first();
    $nextId = $lastProduct ? $lastProduct->id + 1 : 1;
    return $prefix . str_pad($nextId, 5, '0', STR_PAD_LEFT);
}