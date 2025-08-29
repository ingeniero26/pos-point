<?php

namespace App\Http\Controllers;

use App\Models\TypeItemsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemTypesController extends Controller
{
    //
    public function list() {
        return view('admin.items_type.list');
    }
    public function getItemTypes() {
        $itemType = TypeItemsModel::where('is_delete', 0)->get();
        return response()->json($itemType);
    }
    public function store(Request $request) 
    {
        $itemType = new TypeItemsModel();
        $itemType->name = $request->name;
        $itemType->description = $request->description;
        $itemType->created_by = Auth::user()->id;
        $itemType->save();
        return response()->json(['message' => 'Registro creado con exito!']);
    }
    public function edit($id) {
        $itemType = TypeItemsModel::find($id);
        return response()->json($itemType);
    }
    public function update(Request $request, $id) {
        $itemType = TypeItemsModel::find($id);
        $itemType->name = $request->name;
        $itemType->description = $request->description;
        $itemType->updated_by = Auth::user()->id;
        $itemType->save();
        return response()->json(['message' => 'Registro actualizado con exito!']);
    }
    public function destroy($id) {
        $itemType = TypeItemsModel::find($id);
        $itemType->is_delete = 1;
        $itemType->save();
        return response()->json(['message' => 'Registro eliminado con exito!']);
    }
}
