<?php

namespace App\Http\Controllers;

use App\Models\ContactTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.contact_types.list');
    }

    public function getContactTypes()
    {
         $typeContact = ContactTypes::where('is_delete',0)->get();
     return response()->json($typeContact);
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
        $typeContact = new ContactTypes();
        $typeContact->name = $request->name;
        $typeContact->description = $request->description;
        $typeContact->colour = $request->colour;
        $typeContact->status = $request->status;
           $typeContact->created_by = Auth::user()->id;
        $typeContact->company_id = Auth::user()->company_id;
        $typeContact->save();
        return response()->json(['message' => 'Registro creado con exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $typeContact = ContactTypes::find($id);
        return response()->json($typeContact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
        $typeContact = ContactTypes::find($id);
        $typeContact->name = $request->name;
        $typeContact->description = $request->description;
        $typeContact->colour = $request->colour;
        $typeContact->status = $request->status;
        $typeContact->updated_by = Auth::user()->id;
        $typeContact->save();
        return response()->json(['message' => 'Registro actualizado con exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        $typeContact = ContactTypes::find($id);
        $typeContact->is_delete = 1;
        $typeContact->save();
        return response()->json(['message' => 'Registro eliminado con exito']);
    }

      public function toggleStatus($id) {
        $typeRegimen = ContactTypes::find($id);
        $typeRegimen->status =!$typeRegimen->status;
        $typeRegimen->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
}
