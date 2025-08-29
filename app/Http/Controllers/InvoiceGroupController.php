<?php

namespace App\Http\Controllers;

use App\Models\InvoiceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.invoice_group.list');
    }

    public function getInvoiceGroups()
    {
        $invoiceGroups = InvoiceGroup::with(['company', 'createdBy'])->get();
        return response()->json($invoiceGroups);
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
        // Validate the incoming request
        $request->validate([
            'dian_code' => 'required|max:255',
            'name' => 'required|max:255'
        ]);
        $invoiceGroup = new InvoiceGroup();
        $invoiceGroup->dian_code = $request->dian_code;
        $invoiceGroup->name = $request->name;
        $invoiceGroup->taxes = $request->taxes;
        $invoiceGroup->vat_rate = $request->vat_rate;
        $invoiceGroup->ica_rete = $request->ica_rete;
        $invoiceGroup->account = $request->account;
        $invoiceGroup->created_by = Auth::user()->id;
        $invoiceGroup->company_id = Auth::user()->company_id;
        $invoiceGroup->save();
        return response()->json(['message' => 'Registro creado con exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $invoiceGroup = InvoiceGroup::findOrFail($id);
        return response()->json($invoiceGroup);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //  
        $invoiceGroup = InvoiceGroup::findOrFail($id);
        return response()->json($invoiceGroup);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'dian_code' => 'required|max:255',
            'name' => 'required|max:255'
        ]);
        $invoiceGroup = InvoiceGroup::findOrFail($id);
        $invoiceGroup->dian_code = $request->dian_code;
        $invoiceGroup->name = $request->name;
        $invoiceGroup->taxes = $request->taxes;
        $invoiceGroup->vat_rate = $request->vat_rate;
        $invoiceGroup->ica_rete = $request->ica_rete;
        $invoiceGroup->account = $request->account;
    
        $invoiceGroup->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $invoiceGroup = InvoiceGroup::findOrFail($id);
        $invoiceGroup->is_delete = 1; // Assuming you have a soft delete mechanism
        $invoiceGroup->save();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }

    public function toggleStatus($id)
    {
        $invoiceGroup = InvoiceGroup::findOrFail($id);
        $invoiceGroup->is_active = !$invoiceGroup->is_active;
        $invoiceGroup->save();
        return response()->json(['success' => 'Estado Actualizado con Exito']);
    }
}
