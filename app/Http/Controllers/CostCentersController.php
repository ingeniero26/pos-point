<?php

namespace App\Http\Controllers;

use App\Models\CostCenterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostCentersController extends Controller
{
    //
    public function list()
    {
        return view('admin.cost_center.list');
    }
    public function getCostCenters()
 {
     $costCenters = CostCenterModel::where('is_delete',0)->get();
     return response()->json($costCenters);
 }    
 public function store(Request $request) {
        $request->validate([
            'name' =>'required|string|max:255',
            ]);

        $category = new CostCenterModel();
        $category->code = $request->code;
        $category->name = $request->name;
        $category->budget = $request->budget;
        $category->created_by = Auth::user()->id;
        $category->company_id = Auth::user()->company_id;
        $category->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }
    public function edit($id) {
        $category = CostCenterModel::find($id);
        return response()->json($category);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' =>'required|string|max:255',
        ]);
        $category = CostCenterModel::find($id);
        $category->name = $request->name;
        $category->code = $request->code;
        $category->budget = $request->budget;

        $category->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    public function destroy($id) {
        $category = CostCenterModel::find($id);
        $category->is_delete = 1;
        $category->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
}
