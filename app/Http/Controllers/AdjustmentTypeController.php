<?php

namespace App\Http\Controllers;

use App\Models\AdjustmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdjustmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.adjustment_types.list');
    }

    /**
     * Get all adjustment types
     */
    public function getAdjustmentTypes()
    {
        $adjustmentTypes = AdjustmentType::where('is_delete', 0)->get();
        return response()->json($adjustmentTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $adjustmentType = new AdjustmentType();
        $adjustmentType->type_name = $request->type_name;
        $adjustmentType->description = $request->description;
        $adjustmentType->company_id = Auth::user()->company_id;
        $adjustmentType->created_by = Auth::user()->id;
        $adjustmentType->save();

        return response()->json(['success' => 'Tipo de ajuste creado con éxito']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $adjustmentType = AdjustmentType::find($id);
        return response()->json($adjustmentType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $adjustmentType = AdjustmentType::find($id);
        $adjustmentType->type_name = $request->type_name;
        $adjustmentType->description = $request->description;
        $adjustmentType->updated_by = Auth::user()->id;
        $adjustmentType->save();

        return response()->json(['success' => 'Tipo de ajuste actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $adjustmentType = AdjustmentType::find($id);
        $adjustmentType->is_delete = 1;
        $adjustmentType->save();

        return response()->json(['success' => 'Tipo de ajuste eliminado con éxito']);
    }

    /**
     * Get all adjustment types for select options
     */
    public function getAllAdjustmentTypes()
    {
        try {
            $types = AdjustmentType::where('is_delete', 0)
                ->select('id', 'type_name', 'description')
                ->orderBy('type_name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $types
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los tipos de ajuste: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}