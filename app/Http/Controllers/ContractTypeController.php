<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use Illuminate\Http\Request;

class ContractTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.contract_types.list');
    }

    public function getContractTypes()
    {
        $contractTypes = ContractType::all();
        return response()->json($contractTypes);
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50'],
            'status' => ['sometimes', 'boolean'],
        ]);

        $contractType = new ContractType();
        $contractType->name = $validated['name'];
        $contractType->code = $validated['code'];
        $contractType->status = $validated['status'] ?? 1;
        $contractType->save();

        return response()->json([
            'success' => 'Tipo de contrato creado correctamente.',
            'contractType' => $contractType,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $contractType = ContractType::find($id);
        return response()->json($contractType);
    }
   
    public function edit($id)
    {
        $contractType = ContractType::findOrFail($id);
        return response()->json($contractType);
    }
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50'],
            'status' => ['sometimes', 'boolean'],
        ]);

        $contractType = ContractType::findOrFail($id);
        $contractType->name = $validated['name'];
        $contractType->code = $validated['code'];
        $contractType->status = $validated['status'] ?? 1;
        $contractType->save();

        return response()->json([
            'success' => 'Tipo de contrato actualizado correctamente.',
            'contractType' => $contractType,
        ]);
    }
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contractType = ContractType::findOrFail($id);
        $contractType->delete();

        return response()->json(['success' => 'Tipo de contrato eliminado correctamente.']);
    }
    
    public function toggleStatus($id)
    {
        $contractType = ContractType::findOrFail($id);
        $contractType->status = !$contractType->status;
        $contractType->save();

        return response()->json(['success' => 'Estado del tipo de contrato actualizado correctamente.']);
    }
}
