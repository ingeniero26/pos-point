<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseModel; // Assuming Warehouse model exists in your app/Models directory
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    //
    public function index()
    {
        return view('admin.warehouse.list');
    }

    public function getWarehouses()
    {
        // Implement your logic to fetch warehouses from your database
        $warehouses = WarehouseModel::where('is_delete', 0)->get();
        // Return the fetched warehouses as a JSON response
        return response()->json($warehouses);
    }
    public function store(Request $request)
    {
        // Implement your logic to store a new warehouse in your database
        $request->validate([
            'warehouse_name' =>'required|string|max:255',
        ]);

        $warehouse = new WarehouseModel;
        $warehouse->warehouse_name = $request->warehouse_name;
        $warehouse->address = $request->address;
        $warehouse->company_id = Auth::user()->company_id;
        $warehouse->created_by = Auth::user()->id;
        $warehouse->save();
        // Return a success message as a JSON response
        return response()->json(['message' => 'Bodega registrada con exito']);
    }
    public function edit($id)
    {
        // Implement your logic to fetch a specific warehouse by its ID and return it as a JSON response
        $warehouse = WarehouseModel::find($id);
        return response()->json($warehouse);
    }
    public function update(Request $request, $id)
    {
        // Implement your logic to update a specific warehouse by its ID in your database
        $request->validate([
            'warehouse_name' =>'required|string|max:255',
        ]);

        $warehouse = WarehouseModel::find($id);
        $warehouse->warehouse_name = $request->warehouse_name;
        $warehouse->address = $request->address;
        $warehouse->updated_by = Auth::user()->id;
        $warehouse->save();
        // Return a success message as a JSON response
        return response()->json(['message' => 'Bodega actualizada con exito']);
    }
    public function destroy($id)
    {
        // Implement your logic to delete a specific warehouse by its ID in your database
        $warehouse = WarehouseModel::find($id);
        $warehouse->is_delete = 1;
        $warehouse->save();
        // Return a success message as a JSON response
        return response()->json(['message' => 'Bodega eliminada con exito']);
    }

    /**
     * Get all warehouses for select options
     */
    public function getAllWarehouses()
    {
        try {
            $warehouses = WarehouseModel::where('is_delete', 0)
                ->select('id', 'warehouse_name')
                ->orderBy('warehouse_name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $warehouses
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las bodegas: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
