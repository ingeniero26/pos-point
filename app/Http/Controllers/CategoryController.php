<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    public function list(Request $request)
    {
        
        return view('admin.category.list');
    }

    public function getCategories()
    {
        $categories = CategoryModel::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' =>'required|string|max:255',
        ]);

        $category = new CategoryModel();
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->slug = $request->slug;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        $category->company_id = Auth::user()->company_id;
        $category->created_by = Auth::user()->id;
        $category->save();
        // si viene el slug desde el formulario


        return response()->json(['success' => 'Registro Creado con Exito']);
    }

    public function edit($id)
    {
        $category = CategoryModel::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' =>'required|string|max:255',
            'slug' => 'required|unique:categories,slug,'.$id,
        ]);

        $category = CategoryModel::find($id);
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->slug = $request->slug;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        $category->company_id = Auth::user()->company_id;
        $category->created_by = Auth::user()->id;
        $category->save();

        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }

    public function destroy($id)
    {
        $category = CategoryModel::findOrFail($id);
        $category->is_delete = 1;
        $category->save();

        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
    

}
