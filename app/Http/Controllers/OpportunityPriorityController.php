<?php

namespace App\Http\Controllers;

use App\Models\OpportunityPriority;
use Illuminate\Http\Request;

class OpportunityPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.oportunity_prority.list');
    }

     public function getPriorities() {
        $priority = OpportunityPriority::where('is_delete', 0)->get();
        return response()->json($priority);
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

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $priority = OpportunityPriority::find($id);
        return response()->json($priority);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $priority = OpportunityPriority::find($id);
        return response()->json($priority);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
         $itemType = OpportunityPriority::find($id);
        $itemType->name = $request->name;
        $itemType->color = $request->color;
        $itemType->description = $request->description;
       
        $itemType->save();
        return response()->json(['message' => 'Registro actualizado con exito!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpportunityPriority $opportunityPriority)
    {
        //
    }
}
