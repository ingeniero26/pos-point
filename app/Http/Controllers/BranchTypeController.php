<?php

namespace App\Http\Controllers;

use App\Models\BranchType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        return view ('admin.branch_type.list');
        
    }
    public function getBranchTypes()
    {
        //activas
        $branchTypes = BranchType::all();
        return response()->json($branchTypes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $branchType = new BranchType();
        $branchType->name = $request->name;
        $branchType->description = $request->description;
        $branchType->company_id = Auth::user()->company_id;
        $branchType->created_by = Auth::user()->id;
        $branchType->save();
        return response()->json(['success' => true, 'message' => 'Tipo de sucursal creado correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(BranchType $branchType)
    {
        //
        return response()->json($branchType);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $branchType = BranchType::find($id);
        if ($branchType) {
            return response()->json($branchType);
        } else {
            return response()->json(['error' => 'Tipo de sucursal no encontrado'], 404);
        }
    }
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $branchType = BranchType::find($id);
        if (!$branchType) {
            return response()->json(['error' => 'Tipo de sucursal no encontrado'], 404);
        }
        $branchType->name = $request->name;
        $branchType->description = $request->description;
        $branchType->company_id = Auth::user()->company_id;
        $branchType->created_by = Auth::user()->id;
        $branchType->save();
        return response()->json(['success' => true, 'message' => 'Tipo de sucursal actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $branchType = BranchType::find($id);
        if (!$branchType) {
            return response()->json(['error' => 'Tipo de sucursal no encontrado'], 404);
        }
        $branchType->delete();
        return response()->json(['success' => true, 'message' => 'Tipo de sucursal eliminado correctamente']);
    }
    public function toggleStatus($id)
    {
        //
        $branchType = BranchType::find($id);
        if (!$branchType) {
            return response()->json(['error' => 'Tipo de sucursal no encontrado'], 404);
        }
        $branchType->status = !$branchType->status; // Cambia el estado
        $branchType->save();
        return response()->json(['success' => true, 'message' => 'Estado del tipo de sucursal actualizado correctamente']);
    }
}
