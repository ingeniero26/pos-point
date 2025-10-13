<?php

namespace App\Http\Controllers;

use App\Models\OpportunityState;
use Illuminate\Http\Request;

class OpportunityStateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.opportunity_state.list');
    }

    public function getStates(Request $request) {
        $opportunityState = OpportunityState::where('is_delete', 0)->get();
        return response()->json($opportunityState);
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
        $opportunityState = new OpportunityState();
        $opportunityState->name = $request->name;
        $opportunityState->description = $request->description;
        $opportunityState->save();
        return response()->json(['message' => 'Registro creado con exito!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(OpportunityState $opportunityState)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $opportunityState = OpportunityState::find($id);
        return response()->json($opportunityState);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $opportunityState = OpportunityState::find($request->id);
        $opportunityState->name = $request->name;
        $opportunityState->description = $request->description;
        $opportunityState->save();
        return response()->json(['message' => 'Registro actualizado con exito!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $opportunityState = OpportunityState::find($id);
        $opportunityState->is_delete = 1;
        $opportunityState->save();
        return response()->json(['message' => 'Registro eliminado con exito!']);
    }
}
