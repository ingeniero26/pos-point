<?php

namespace App\Http\Controllers;

use App\Models\ArlProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArlProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.arl_providers.list');
    }
    public function getArlProviders()
    {
        $arlProviders = ArlProvider::with('company','created_by')->get();
        return response()->json($arlProviders);
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
        $arlProvider = new ArlProvider();
        $arlProvider->code = $request->input('code');
        $arlProvider->name = $request->input('name');
        $arlProvider->nit = $request->input('nit');
        $arlProvider->phone = $request->input('phone');
        $arlProvider->email = $request->input('email');
        $arlProvider->address = $request->input('address');
        $arlProvider->risk_class = $request->input('risk_class');
        $arlProvider->created_by = Auth::user()->id;
        $arlProvider->company_id = Auth::user()->company_id;
        $arlProvider->save();
        return response()->json(['message' => 'ARL Provider created successfully', 'arlProvider' => $arlProvider], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $arlProvider = ArlProvider::with('company','created_by')->find($id);
        return response()->json($arlProvider);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $arlProvider = ArlProvider::find($id);
        if (!$arlProvider) {
            return response()->json(['error' => 'Registro no Encontrado']);
        }
        return response()->json($arlProvider);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $arlProvider = ArlProvider::find($id);
        if (!$arlProvider) {
            return response()->json(['error' => 'Registro no Encontrado']);
        }
        $arlProvider->code = $request->input('code');
        $arlProvider->name = $request->input('name');
        $arlProvider->nit = $request->input('nit');
        $arlProvider->phone = $request->input('phone');
        $arlProvider->email = $request->input('email');
        $arlProvider->address = $request->input('address');
        $arlProvider->risk_class = $request->input('risk_class');
        $arlProvider->save();
        return response()->json(['message' => 'ARL Provider updated successfully', 'arlProvider' => $arlProvider]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $arlProvider = ArlProvider::find($id);
        if (!$arlProvider) {
            return response()->json(['error' => 'Registro no Encontrado']);
        }
        $arlProvider->delete();
        return response()->json(['message' => 'ARL Provider deleted successfully']);
    }
    public function toggleStatus($id)
    {
        $arlProvider = ArlProvider::find($id);
        if (!$arlProvider) {
            return response()->json(['error' => 'Registro no Encontrado']);
        }
        $arlProvider->status = !$arlProvider->status;
        $arlProvider->save();
        return response()->json(['message' => 'Status updated successfully', 'status' => $arlProvider->status]);
    }
}
