<?php

namespace App\Http\Controllers;

use App\Models\TypeLiabilityModel;
use Illuminate\Http\Request;

class TypeLiabilityController extends Controller
{
    //
    public function list()
    {
        return view('admin.type_liability.list');
    }
    public function getTypeLiabilities() {
        $typeLiabilities = TypeLiabilityModel::all();
        return response()->json($typeLiabilities);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'liability_name' =>'required|string|max:255',
        ]);

        $type_liability = new TypeLiabilityModel();
        $type_liability->code = $request->code;
        $type_liability->liability_name = $request->liability_name;
      
        $type_liability->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }
    public function edit($id) {
        $type_liability = TypeLiabilityModel::find($id);
        return response()->json($type_liability);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'liability_name' =>'required|string|max:255',
        ]);

        $type_liability = TypeLiabilityModel::find($id);
        $type_liability->code = $request->code;
        $type_liability->liability_name = $request->liability_name;
        $type_liability->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);

    }
    public function destroy($id)
    {
        $type_liability = TypeLiabilityModel::find($id);
        $type_liability->delete();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }

    public function toggleStatus($id)
    {
        $type_liability = TypeLiabilityModel::find($id);
        $type_liability->status =!$type_liability->status;
        $type_liability->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
}
