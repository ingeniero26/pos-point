<?php

namespace App\Http\Controllers;

use App\Models\TypeLiabilityModel;
use App\Models\TypeRegimenModel;
use Illuminate\Http\Request;

class TypeRegimenController extends Controller
{
    //
    public function list() {
        return view('admin.type_regimen.list');
    }
    public function getTypeLiabilities() {
        $typeLiabilities = TypeRegimenModel::all();
        return response()->json($typeLiabilities);
    }
    public function store(Request $request){

        $request->validate([
            'name' =>'required|string|max:255',
        ]);

        $taxes = new TypeRegimenModel();
        $taxes->code = $request->code;
        $taxes->regimen_name = $request->regimen_name;
      
        $taxes->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }
    public function edit($id) {
        $typeRegimen = TypeRegimenModel::find($id);
        return response()->json($typeRegimen);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' =>'required|string|max:255',
        ]);
        $typeRegimen = TypeRegimenModel::find($id);
        $typeRegimen->code = $request->code;
        $typeRegimen->regimen_name = $request->regimen_name;
        $typeRegimen->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    public function destroy($id) {
        $typeRegimen = TypeRegimenModel::find($id);
        $typeRegimen->delete();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
    public function toggleStatus($id) {
        $typeRegimen = TypeRegimenModel::find($id);
        $typeRegimen->status =!$typeRegimen->status;
        $typeRegimen->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }


}
