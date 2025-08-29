<?php

namespace App\Http\Controllers;

use App\Models\ColorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorsController extends Controller
{
    //
    public function index()
    {
        return view('admin.colors.list');
    }

    public function getColorList()
    {
       // $colors = ColorModel::all();
        $colors = ColorModel::where('is_delete', 0)->get();
        return response()->json($colors);
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name_color' =>'required|string|max:255',
            'code' =>'required|string|max:255',
        ]);

        // Create a new color
        $color = new ColorModel();
        $color->name_color = $request->name_color;
        $color->code = $request->code;
        $color->created_by = Auth::user()->id;
        $color->company_id = Auth::user()->company_id;
        $color->save();

        // Redirect to the color list page with a success message
        return response()->json(['success' => 'Registro Creado con Éxito']);
    }

    public function edit($id)
    {
        $color = ColorModel::find($id);
        return response()->json($color);
    }

    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'name_color' =>'required|string|max:255',
            'code' =>'required|string|max:255',
        ]);

        // Update the color
        $color = ColorModel::find($id);
        $color->name_color = $request->name_color;
        $color->code = $request->code;
        $color->updated_by = Auth::user()->id;
        $color->save();

        // Redirect to the color list page with a success message
        return response()->json(['success' => 'Registro Actualizado con Éxito']);
    }

    public function destroy($id)
    {
        // Delete the color
        $color = ColorModel::find($id);
        $color->is_delete = 1;
        $color->save();

        // Redirect to the color list page with a success message
        return response()->json(['success' => 'Registro Eliminado con Éxito']);
    }
}
