<?php

namespace App\Http\Controllers;

use App\Models\ContactSource;
use Illuminate\Http\Request;

class ContactSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.contact_sources.list');
    }

    public function getContactSources()
    {
         $contactSource = ContactSource::where('is_delete',0)->get();
     return response()->json($contactSource);
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
        $contactSource = new ContactSource();
        $contactSource->name = $request->name;
        $contactSource->description = $request->description;
        $contactSource->status = $request->status;
        $contactSource->save();
        return response()->json(['message' => 'Registro creado con exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactSource $contactSource)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $contactSource = ContactSource::find($id);
        return response()->json($contactSource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $contactSource = ContactSource::find($id);
        $contactSource->name = $request->name;
        $contactSource->description = $request->description;
        $contactSource->status = $request->status;
        $contactSource->save();
        return response()->json(['message' => 'Registro actualizado con exito']);
    }
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $contactSource = ContactSource::find($id);
        $contactSource->is_delete = 1;
        $contactSource->save();
        return response()->json(['message' => 'Registro eliminado con exito']);
    }

    public function toggleStatus($id)
    {
        $contactSource = ContactSource::find($id);
        if ($contactSource) {
            $contactSource->status = $contactSource->status == 1 ? 0 : 1;
            $contactSource->save();
            return response()->json(['message' => 'Estado actualizado con exito']);
        } else {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
    }
    
    
}
