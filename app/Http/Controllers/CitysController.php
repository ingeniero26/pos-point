<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\DepartmentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitysController extends Controller
{
    //
    public function list()
    {
        $departments = DepartmentModel::all()->pluck('name_department','id');

        return view('admin.city.list', compact('departments'));
      
    }
    public function getCities()
    {
        $citys = CityModel::with(['departments'])
            ->get();
            return response()->json($citys);

    }
    public function store(Request $request)
    {
        $request->validate([
            'city_name' =>'required|string|max:255',
        ]);

        $taxes = new CityModel();
        $taxes->department_id = $request->department_id;
        $taxes->city_name = $request->city_name;
        $taxes->created_by = Auth::user()->id;
        $taxes->company_id = Auth::user()->company_id;
 
        $taxes->save();

        return response()->json(['success' => 'Registro Creado con Exito']);
    }
    public function edit($id)
    {
        $city = CityModel::findOrFail($id);
        return response()->json($city);
    
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'city_name' =>'required|string|max:255',
            'department_id' =>'required|exists:departments,id',
       
            
        ]);
        
        $product = CityModel::findOrFail($id);
        $product -> update($validated);

    }
    public function destroy($id)
    {
        $product = CityModel::find($id);
        $product->delete();
        return response()->json(['success' => 'Registro Eliminado con Éxito']);
    }

    public function toggleStatus(Request $request, $id)
    {
        $city = CityModel::find($id);
        if ($city) {
            $city->status = $request->status;
            $city->save();
            return response()->json(['success' => 'Estado cambiado exitosamente.']);
        } else {
            return response()->json(['error' => 'Ciudad no encontrada.'], 404);
        }
    }


}
