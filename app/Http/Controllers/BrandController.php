<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    //
    
        public function list(Request $request)
        {
            return view('admin.brand.list');
        }
        public function getBrands(Request $request)
        {
            $brand = BrandModel::all();
            return response()->json($brand);
        }
        public function store(Request $request)
        {
            $request->validate([
                'brand_name' =>'required|string|max:255',
            ]);
    
            $category = new BrandModel();
            $category->brand_name = $request->brand_name;
            $category->created_by = Auth::user()->id;
            $category->company_id = Auth::user()->company_id;
            //$category->description = $request->description;
            $category->save();
    
            return response()->json(['success' => 'Registro Creado con Exito']);
        }

        public function edit($id)
        {
            $brand = BrandModel::find($id);
            return response()->json($brand);
        }
    
        public function update(Request $request, $id)
        {
            $request->validate([
                'brand_name' =>'required|string|max:255',
            ]);
    
            $category = BrandModel::find($id);
            $category->brand_name = $request->brand_name;
           // $category->description = $request->description;
            $category->save();
    
            return response()->json(['success' => 'Registro Actualizado con Exito']);
        }
        
    public function destroy($id)
    {
        $category = BrandModel::findOrFail($id);
        $category->delete();

        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
    
    
}
