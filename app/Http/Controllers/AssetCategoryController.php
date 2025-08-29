<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.asset_category.list');
    }
    public function getAssetCategories()
    {
        $assetCategories = AssetCategory::with('company')->get();
        return response()->json($assetCategories);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'depreciation_method' => 'required',
            'useful_life_years' => 'required',
            'depreciation_rate' => 'required',
        ]);
        $assetCategory = new AssetCategory();
        $assetCategory->name = $request->name;
        $assetCategory->description = $request->description;
        $assetCategory->depreciation_method = $request->depreciation_method;
        $assetCategory->useful_life_years = $request->useful_life_years;
        $assetCategory->depreciation_rate = $request->depreciation_rate;
        $assetCategory->created_by = Auth::user()->id;
        $assetCategory->company_id = Auth::user()->company_id;
        $assetCategory->save();
        return response()->json(['success' => 'Registro Creado con Exito']);
       
    }
    public function edit($id) {
        $assetCategory = AssetCategory::findOrFail($id);
        return response()->json($assetCategory);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'depreciation_method' => 'required',
            'useful_life_years' => 'required',
            'depreciation_rate' => 'required',
        ]);
       
        $assetCategory = AssetCategory::findOrFail($id);
        $assetCategory->name = $request->name;
        $assetCategory->description = $request->description;
        $assetCategory->depreciation_method = $request->depreciation_method;
        $assetCategory->useful_life_years = $request->useful_life_years;
        $assetCategory->depreciation_rate = $request->depreciation_rate;
        $assetCategory->updated_by = Auth::user()->id;
        $assetCategory->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }

   

    /**
     * Display the specified resource.
     */
    public function show(AssetCategory $assetCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $assetCategory = AssetCategory::findOrFail($id);
        $assetCategory->is_delete = 1;
        $assetCategory->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
}
