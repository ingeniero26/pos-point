<?php

namespace App\Http\Controllers;

use App\Models\PensionFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PensionFoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.pensions.list');
    }

    public function getPensions()
    {
        $pensionFunds = PensionFound::with('company','created_by')->get();
        return response()->json($pensionFunds);
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
        $pensionFunds = new PensionFound();
        $pensionFunds->code = $request->input('code');
        $pensionFunds->name = $request->input('name');
        $pensionFunds->nit = $request->input('nit');
        $pensionFunds->phone = $request->input('phone');
        $pensionFunds->email = $request->input('email');
        $pensionFunds->address = $request->input('address');
        $pensionFunds->created_by = Auth::user()->id;
        $pensionFunds->company_id = Auth::user()->company_id;
        $pensionFunds->save();
        return response()->json(['message' => 'Pension Fund created successfully', 'pensionFund' => $pensionFunds], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $pensionFund = PensionFound::with('company','created_by')->find($id);
        if (!$pensionFund) {
            return response()->json(['message' => 'Pension Fund not found'], 404);
        }
        return response()->json($pensionFund);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $pensionFund = PensionFound::find($id);
        if (!$pensionFund) {
            return response()->json(['error' => 'Registro no Encontrado']);;
        }
        return response()->json($pensionFund);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $pensionFund = PensionFound::find($id);
        if (!$pensionFund) {
            return response()->json(['error' => 'Registro no Encontrado']);;
        }
        $pensionFund->code = $request->input('code');
        $pensionFund->name = $request->input('name');
        $pensionFund->nit = $request->input('nit');
        $pensionFund->phone = $request->input('phone');
        $pensionFund->email = $request->input('email');
        $pensionFund->address = $request->input('address');
        $pensionFund->save();
        return response()->json(['message' => 'Pension Fund updated successfully', 'pensionFund' => $pensionFund]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $pensionFund = PensionFound::find($id);
        if (!$pensionFund) {
            return response()->json(['error' => 'Registro no Encontrado']);;
        }
        $pensionFund->delete();
        return response()->json(['message' => 'Pension Fund deleted successfully']);
    }

    public function toggleStatus($id)
    {
        $pensionFund = PensionFound::find($id);
        if (!$pensionFund) {
            return response()->json(['error' => 'Registro no Encontrado']);;
        }
        $pensionFund->status = !$pensionFund->status;
        $pensionFund->save();
        return response()->json(['message' => 'Status updated successfully', 'status' => $pensionFund->status]);
    }
}
