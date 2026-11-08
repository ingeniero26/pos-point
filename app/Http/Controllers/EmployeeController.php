<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PersonModel;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    
    public function list()
    {
        //
        return view('admin.employees.list');
    }
 
    
    public function getEmployees() {
        // mostrar las personas tipo empleado
        $employees = PersonModel::where('type_third_id', 4)->get();
        return response()->json($employees);

    }
    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
