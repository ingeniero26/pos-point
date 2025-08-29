<?php

namespace App\Http\Controllers;

use App\Models\TypeMovementCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeMovementCashController extends Controller
{
    public function list()
    {
        return view('admin.type_movement_cash_register.list');
    }

    /**
     * Get all movement types for datatable
     */
    public function getMovementCategories()
    {
        $movementType = TypeMovementCash::where('is_delete', 0)->get();
        return response()->json($movementType);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Normaliza el valor de 'type' a mayúsculas antes de validar
        $request->merge([
            'type' => strtoupper($request->input('type'))
        ]);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:INGRESO,EGRESO',
            'description' => 'nullable|string',
            'requires_third_party' => 'boolean',
            'is_system_generated' => 'boolean'
        ]);

        // Create a new movement type
        $movementType = new TypeMovementCash();
        $movementType->name = $request->name;
        $movementType->type = $request->type;
        $movementType->description = $request->description;
        $movementType->requires_third_party = $request->requires_third_party ?? false;
        $movementType->is_system_generated = $request->is_system_generated ?? false;
        $movementType->company_id = 1; // Ajustar según la lógica de tu aplicación
        $movementType->created_by = Auth::id();
        $movementType->save();

        return response()->json(['success' => 'Tipo de Movimiento Creado con Éxito']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $movementType = TypeMovementCash::find($id);
        return response()->json($movementType);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $movementType = TypeMovementCash::find($id);
        return response()->json($movementType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:INGRESO,EGRESO',
            'description' => 'nullable|string',
            'requires_third_party' => 'boolean',
            'is_system_generated' => 'boolean'
        ]);

        // Update the movement type
        $movementType = TypeMovementCash::find($id);
        $movementType->name = $request->name;
        $movementType->type = $request->type;
        $movementType->description = $request->description;
        $movementType->requires_third_party = $request->requires_third_party ?? false;
        $movementType->is_system_generated = $request->is_system_generated ?? false;
        $movementType->save();

        return response()->json(['success' => 'Tipo de Movimiento Actualizado con Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Soft delete the movement type
        $movementType = TypeMovementCash::find($id);
        $movementType->is_delete = 1;
        $movementType->save();

        return response()->json(['success' => 'Tipo de Movimiento Eliminado con Éxito']);
    }
}
