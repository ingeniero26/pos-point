<?php

namespace App\Http\Controllers;

use App\Models\NotesConcept;
use Illuminate\Http\Request;

class NotesConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.notes_concept.list');
    }
    public function getNotesConcepts()
    {
        // $notesConcepts = NotesConcept::all();
        $notesConcepts = NotesConcept::orderBy('id', 'desc')->get();
        return response()->json($notesConcepts);
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
        $notesConcept = new NotesConcept();
        $notesConcept->code = $request->code;
        $notesConcept->name = $request->name;
        $notesConcept->description = $request->description;
        $notesConcept->note_type = $request->note_type;
        $notesConcept->save();
        return response()->json(['success' => 'Registro Creado con Exito']);

    }

    /**
     * Display the specified resource.
     */
    public function show(NotesConcept $notesConcept)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $notesConcept = NotesConcept::find($id);
        return response()->json($notesConcept);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $notesConcept = NotesConcept::find($id);
        $notesConcept->code = $request->code;
        $notesConcept->name = $request->name;
        $notesConcept->description = $request->description;
        $notesConcept->note_type = $request->note_type;
        $notesConcept->save();
        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notesConcept = NotesConcept::find($id);
        $notesConcept->delete();
        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
}
