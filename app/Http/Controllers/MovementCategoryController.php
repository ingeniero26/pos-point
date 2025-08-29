<?php

namespace App\Http\Controllers;

use App\Models\MovementCategory;
use Illuminate\Http\Request;

class MovementCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function getMovementCategories(){
        // retornar json
        $movementCategories = MovementCategory::all();
        return response()->json($movementCategories);
        

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
    public function show(MovementCategory $movementCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MovementCategory $movementCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MovementCategory $movementCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MovementCategory $movementCategory)
    {
        //
    }
}
