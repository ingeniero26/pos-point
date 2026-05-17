<?php

namespace App\Http\Controllers;

use App\Models\ReturnReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.return_reasons.list');
    }

    public function getReturnReasons() {
        $returnReason = ReturnReason::where('is_delete', 0)->get();
        return response()->json($returnReason);
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
         $returnReason = new ReturnReason();
        $returnReason->name = $request->input('name');
        $returnReason->description = $request->input('description');
        $returnReason->created_by = Auth::user()->id;
        $returnReason->company_id = Auth::user()->company_id;
        $returnReason->save();
        return response()->json(['message' => 'Eps created successfully', 'eps' => $returnReason], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
         $eps = ReturnReason::find($id);
        if (!$eps) {
            return response()->json(['error' => 'Registro no Encontrado']);;
        }
        return response()->json($eps);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
         $returnReason = ReturnReason::find($id);
        if (!$returnReason) {
            return response()->json(['error' => 'Registro no Encontrado']);
        }
        $returnReason->name = $request->input('name');
        $returnReason->description = $request->input('description');
        $returnReason->save();
        return response()->json(['message' => 'Registro Actualizado', 'eps' => $returnReason]);
    }

       public function destroy($id)
    {
        $branchType = ReturnReason::find($id);
        if (!$branchType) {
            return response()->json(['error' => 'Tipo de devolucion no encontrado'], 404);
        }
        $branchType->is_delete = 1;
        $branchType->save();
        return response()->json(['success' => true, 'message' => 'Tipo devolucion eliminado correctamente']);
    }
    public function toggleStatus($id)
    {
        //
        $branchType = ReturnReason::find($id);
        if (!$branchType) {
            return response()->json(['error' => 'Tipo de devolucion no encontrado'], 404);
        }
        $branchType->status = !$branchType->status; // Cambia el estado
        $branchType->save();
        return response()->json(['success' => true, 'message' => 'Estado del tipo de devolucion actualizado correctamente']);
    }
}
