<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
       
        $areas = Area::all()->pluck('name','id');
        return view('admin.positions.list', compact('areas'));
    }

    public function getPositions()
    {
        $positions = Position::with(['area' => function($query) {
            $query->where('is_delete', 0);
        }])
        ->where('is_delete', false)
        ->where('company_id', Auth::user()->company_id)
        ->get();
        
        return response()->json(['data' => $positions], 200);
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
        // Validate that the selected area belongs to the user's company
        $area = Area::
            where('id', $request->input('area_id'))
            ->where('company_id', Auth::user()->company_id)
            ->where('is_delete', 0)
            ->first();
            
        if (!$area) {
            return response()->json(['error' => 'Área no válida o no pertenece a su empresa'], 400);
        }
        
        $position = new Position();
        $position->name = $request->input('name');
        $position->description = $request->input('description');
        $position->area_id = $request->input('area_id');
        $position->level = $request->input('level');
        $position->min_salary = $request->input('min_salary');
        $position->max_salary = $request->input('max_salary');
        $position->requirements = $request->input('requirements');
        $position->responsibilities = $request->input('responsibilities');
        $position->company_id = Auth::user()->company_id;
        $position->created_by = Auth::user()->id;
        $position->status = $request->input('status', true);
        $position->save();
        
        return response()->json(['success' => 'Cargo creado exitosamente', 'position' => $position], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $position = Position::where('id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->where('is_delete', false)
            ->firstOrFail();

        return response()->json($position);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $position = Position::where('id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->where('is_delete', false)
            ->firstOrFail();

        // Validate that the selected area belongs to the user's company
        $area = Area::
            where('id', $request->input('area_id'))
            ->where('company_id', Auth::user()->company_id)
            ->where('is_delete', 0)
            ->first();
            
        if (!$area) {
            return response()->json(['error' => 'Área no válida o no pertenece a su empresa'], 400);
        }

        $position->name = $request->input('name');
        $position->description = $request->input('description');
        $position->area_id = $request->input('area_id');
        $position->level = $request->input('level');
        $position->min_salary = $request->input('min_salary');
        $position->max_salary = $request->input('max_salary');
        $position->requirements = $request->input('requirements');
        $position->responsibilities = $request->input('responsibilities');
        $position->status = $request->input('status', $position->status);
        $position->save();

        return response()->json(['success' => 'Cargo actualizado exitosamente', 'position' => $position]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $position = Position::where('id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->where('is_delete', false)
            ->firstOrFail();

        $position->is_delete = true;
        $position->save();

        return response()->json(['success' => 'Cargo eliminado exitosamente']);
    }

    public function toggleStatus($id)
    {
        $position = Position::where('id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->where('is_delete', false)
            ->firstOrFail();

        $position->status = !$position->status;
        $position->save();

        return response()->json(['success' => 'Estado del cargo actualizado exitosamente']);
    }
}
