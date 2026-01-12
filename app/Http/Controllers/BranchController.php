<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchType;
use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\DepartmentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        $departments = DepartmentModel::all()->pluck('name_department','id');
        $cities = CityModel::all()->pluck('city_name', 'id');
        $countries = CountryModel::all()->pluck('country_name','id');
        $branch_types = BranchType::all()->pluck('name','id');
        return view('admin.branch.list', compact('departments','cities','countries','branch_types'));
    }

    public function getBranches(){
        $branches = Branch::with('departments','cities','countries','company','branch_types')->get();
        // retornar json
        return response()->json($branches);
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
        //validar
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'country_id' => 'required',
            'department_id' => 'required',
            'city_id' => 'required',
        ]);
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->email = $request->email;
        $branch->phone = $request->phone;
        $branch->country_id = $request->country_id;
        $branch->department_id = $request->department_id;
        $branch->city_id = $request->city_id;
        $branch->created_by = Auth::user()->id;
        $branch->company_id = Auth::user()->company_id;
        $branch->save();
        return response()->json(['success' => 'Registro Creado con Éxito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $branch = Branch::find($id);
        if ($branch) {
            return response()->json($branch);
        } else {
            return response()->json(['error' => 'Sucursal no encontrada'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //validar
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'country_id' => 'required',
            'department_id' => 'required',
            'city_id' => 'required',
            'branch_type_id' => 'required', // Asegúrate de que este campo esté presente
        ]);
        $branch = Branch::find($id);
        if (!$branch) {
            return response()->json(['error' => 'Sucursal no encontrada'], 404);
        }
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->email = $request->email;
        $branch->phone = $request->phone;
        $branch->country_id = $request->country_id;
        $branch->department_id = $request->department_id;
        $branch->city_id = $request->city_id;
        $branch->branch_type_id = $request->branch_type_id; // Asegúrate de que este campo esté presente
        $branch->save();
        return response()->json(['success' => true, 'message' => 'Sucursal actualizada correctamente']);
    }
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $branch = Branch::find($id);
        if (!$branch) {
            return response()->json(['error' => 'Sucursal no encontrada'], 404);
        }
        $branch->delete();
        return response()->json(['success' => true, 'message' => 'Sucursal eliminada correctamente']);
    }

    public function toggleStatus($id)
    {
        $branch = Branch::find($id);
        if (!$branch) {
            return response()->json(['error' => 'Sucursal no encontrada'], 404);
        }
        $branch->status = $branch->status == 1 ? 0 : 1;
        $branch->save();
        return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente']);
    }
}
