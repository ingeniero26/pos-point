<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
       
        $categories = CategoryModel::all()->pluck('category_name','id');
        return view('admin.sub_category.list', compact('categories'));
    }
    public function getSubCategories()
    {
        $subCategories = SubCategory::with('category')->get();
        return response()->json($subCategories);
    }

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);
         $name = trim($request->name);
        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->description = $request->description;
       // $subCategory->slug = $request->slug;
        $subCategory->meta_title = $request->meta_title;
        $subCategory->meta_description = $request->meta_description;
        $subCategory->meta_keywords = $request->meta_keywords;
        $subCategory->company_id = Auth::user()->company_id;
        $subCategory->created_by = Auth::user()->id;
        // Si viene el slug desde el formulario, se usa, si no, se genera uno automáticamente
           $slug = Str::slug($name, '-');
            $chekSlug = SubCategory::checkSlug($slug);
            if (empty($chekSlug)) {
                $subCategory->slug = $slug;
                $subCategory->save();
            } else {
                $new_slug = $slug . '-' . $subCategory->id;
                $subCategory->slug = $new_slug;
                $subCategory->save();
            }
      
        $subCategory->save();
        return response()->json(['success' => 'Registro creado con éxito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $subCategory = SubCategory::find($id);
        if (!$subCategory) {
            return response()->json(['error' => 'SubCategory not found'], 404);
        }
        return response()->json($subCategory);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);
        $subCategory = SubCategory::find($id);
        if (!$subCategory) {
            return response()->json(['error' => 'SubCategory not found'], 404);
        }
        $subCategory->category_id = $request->category_id;
        $subCategory->name = $request->name;
        $subCategory->description = $request->description;
        $subCategory->slug = $request->slug;
        $subCategory->meta_title = $request->meta_title;
        $subCategory->meta_description = $request->meta_description;
        $subCategory->meta_keywords = $request->meta_keywords;
        $subCategory->company_id = Auth::user()->company_id;
        $subCategory->created_by = Auth::user()->id;
        // Si viene el slug desde el formulario, se usa, si no, se genera uno automáticamente
        $subCategory->save();
        return response()->json(['success' => 'Registro actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $subCategory = SubCategory::findOrFail($id);
        if (!$subCategory) {
            return response()->json(['error' => 'SubCategory not found'], 404);
        }
        $subCategory->is_delete = 1;
        $subCategory->save();
        return response()->json(['success' => 'Registro eliminado con éxito']);
    }
}
