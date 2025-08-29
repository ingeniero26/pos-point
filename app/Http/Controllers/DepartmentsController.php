<?php

namespace App\Http\Controllers;

use App\Models\CountryModel;
use App\Models\DepartmentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentsController extends Controller
{
    //
    public function list()
    {
        $countries = CountryModel::all()->pluck('country_name','id');
        return view('admin.department.list', compact('countries'));
    }

    public function getDepartments()
    {   
        $query = DepartmentModel::with(['countries']);
        // Get all departments from the database and include the related country data
        $departments = $query->get();

        // Return the departments as JSON
        return response()->json($departments);
      
    }
    public function store(Request $request) 
    {
        // Validate the incoming request
        $request->validate([
            'name_department' =>'required|max:255',
            'country_id' =>'required',
           
        ]);
        // Create a new department with the validated data
        $department = new DepartmentModel();
        $department->name_department = $request->name_department;
        $department->country_id = $request->country_id;
        $department->created_by = Auth::user()->id;
        $department->company_id = Auth::user()->company_id;
        $department->save();
        return response()->json(['message' => 'Registro creado con exito']);
    }
    public function edit($id)
    {
        $departments = DepartmentModel::findOrFail($id);
        return response()->json($departments);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_department' =>'required|string|max:255',
            'country_id' =>'required',
        ]);

        $department = DepartmentModel::findOrFail($id);
        $department->name_department = $request->name_department;
        $department->country_id = $request->country_id;
      
        $department->save();

        return response()->json(['success' => 'Registro Actualizado con Exito']);
    }
    public function destroy($id)
    {
        $taxes = DepartmentModel::findOrFail($id);
        $taxes->is_delete = 1;
        $taxes->save();

        return response()->json(['success' => 'Registro Eliminado con Exito']);
    }
 
    
}
