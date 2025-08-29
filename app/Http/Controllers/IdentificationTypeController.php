<?php

namespace App\Http\Controllers;

use App\Models\IdentificationTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdentificationTypeController extends Controller
{
    //
    public function list()
    {
        return view('admin.identification_type.list');
    }
    public function getTypeIdentities()
    {
        $types = IdentificationTypeModel::all();
        return response()->json($types);
    }

    public function store(Request $request) {
        // Validate the input
        $request->validate([
            'identification_name' =>'required|string|max:255',
            'abbreviation' =>'required|string|max:255',
        ]);

        // Create a new identification type
        $type = new IdentificationTypeModel();
        $type->identification_name = $request->identification_name;
        $type->abbreviation = $request->abbreviation;
        $type->created_by = Auth::user()->id;
        $type->company_id = Auth::user()->company_id;
        $type->save();

        return response()->json(['success' => 'Registro Creado con Exito']);   
     }
     public function edit($id)
     {
         $type = IdentificationTypeModel::find($id);
         if (!$type) {
             return response()->json(['error' => 'Registro no Encontrado']);
         }
         return response()->json($type);
     }
     public function update(Request $request, $id) {
        // Validate the input
        $request->validate([
            'identification_name' =>'required|string|max:255',
            'abbreviation' =>'required|string|max:255',
        ]);

        // Find the identification type by ID
        $type = IdentificationTypeModel::find($id);
        if (!$type) {
            return response()->json(['error' => 'Registro no Encontrado']);
        }

        // Update the identification type
        $type->identification_name = $request->identification_name;
        $type->abbreviation = $request->abbreviation;
        $type->save();

        return response()->json(['success' => 'Registro Actualizado con Exito']);
     }
     public function destroy($id)
     {
         // Find the identification type by ID
         $type = IdentificationTypeModel::find($id);
         if (!$type) {
             return response()->json(['error' => 'Registro no Encontrado']);
         }

         // Delete the identification type
         $type->delete();

         return response()->json(['success' => 'Registro Eliminado con Exito']);
     }
}
