<?php

namespace App\Http\Controllers;

use App\Models\MeasureModel;
use Illuminate\Http\Request;

class MeasuresController extends Controller
{
    //
    public function list(Request $request)
    {
        return view('admin.measure.list');
    }
    
    public function getMeasures(Request $request)
    {
        $brand = MeasureModel::all();
        return response()->json($brand);
    }
    public function store(Request $request)
    {
        $request->validate([
            'measure_name' =>'required|string|max:255',
        ]);

        $category = new MeasureModel();
        $category->code = $request->code;
        $category->measure_name = $request->measure_name;
        $category->abbreviation = $request->abbreviation;
        $category->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }

    public function edit($id)
    {
        $brand = MeasureModel::find($id);
        return response()->json($brand);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'measure_name' =>'required|string|max:255',
        ]);

        $category = MeasureModel::find($id);
        $category->code = $request->code;
        $category->measure_name = $request->measure_name;
        $category->abbreviation = $request->abbreviation;
        $category->save();

        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    
public function destroy($id)
{
    $category = MeasureModel::findOrFail($id);
    $category->is_delete = 1;
    $category->save();

    return response()->json(['success' => 'Registro Eliminado con Exito']);
}
}
