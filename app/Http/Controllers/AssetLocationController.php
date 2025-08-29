<?php

namespace App\Http\Controllers;

use App\Models\AssetLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AssetLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        return view('admin.asset_location.list');
    }
    
    public function getAssetLocations()
    {   
        // retornar todos los registros de la tabla asset_locations no eliminados

        $assetLocations = AssetLocation::where('is_delete', '0')
        ->orderBy('id', 'desc')
        ->get();
        return response()->json($assetLocations);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validateData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'nullable',
            'responsible_person' => 'nullable',
            'status' => 'nullable',
        ]);
        $assetLocation = new AssetLocation();
        $assetLocation->name = $validateData['name'];
        $assetLocation->description = $validateData['description'];
        $assetLocation->address = $validateData['address'];
        $assetLocation->responsible_person = $validateData['responsible_person'];
        $assetLocation->status = $validateData['status'];
        $assetLocation->created_by = Auth::user()->id;
        $assetLocation->company_id = Auth::user()->company_id;
        $assetLocation->save();
        return response()->json(['success' => 'Registro Creado con Exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetLocation $assetLocation)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $assetLocation = AssetLocation::findOrFail($id);
        return response()->json($assetLocation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $validateData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'nullable',
            'responsible_person' => 'nullable',
            'status' => 'nullable',
        ]);
        $assetLocation = AssetLocation::findOrFail($id);
        $assetLocation->name = $validateData['name'];
        $assetLocation->description = $validateData['description'];
        $assetLocation->address = $validateData['address'];
        $assetLocation->responsible_person = $validateData['responsible_person'];
        $assetLocation->status = $validateData['status'];
        $assetLocation->updated_by = Auth::user()->id;
        $assetLocation->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $assetLocation = AssetLocation::findOrFail($id);
        $assetLocation->is_delete = 1;
        $assetLocation->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
}
