<?php

namespace App\Http\Controllers;

use App\Models\ReceiptType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function list()
    {
        //
        return view('admin.receipt_types.list');
    }
    public function getReceiptTypes()
    {
        $receiptTypes = ReceiptType::all();
        return response()->json($receiptTypes);
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
        $request->validate([
            'code' => 'required|string|max:10|unique:receipt_types,code',
            'name' => 'required|string|max:255',
            'prefix' => 'required|string|max:255',
        ]);

        $category = new ReceiptType();
        $category->code = $request->code;
        $category->name = $request->name;
        $category->prefix = $request->prefix;
        $category->current_sequential = $request->current_sequential;
        $category->modify_third_parties = $request->modify_third_parties;
        $category->modify_inventories = $request->modify_inventories;
        $category->company_id = Auth::user()->company_id;
        $category->created_by = Auth::user()->id;
        $category->save();
        // si viene el slug desde el formulario


        return response()->json(['success' => 'Registro Creado con Exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReceiptType $receiptType)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $receiptType = ReceiptType::find($id);
        return response()->json($receiptType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $receiptType = ReceiptType::find($id);
        $receiptType->code = $request->code;
        $receiptType->name = $request->name;
        $receiptType->prefix = $request->prefix;
        $receiptType->current_sequential = $request->current_sequential;
        $receiptType->modify_third_parties = $request->modify_third_parties;
        $receiptType->modify_inventories = $request->modify_inventories;

        $receiptType->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $receiptType = ReceiptType::find($id);
        $receiptType->delete();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
}
