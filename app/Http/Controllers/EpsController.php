<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\Eps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EpsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        $cities = CityModel::all()->pluck('city_name','id');
        return view('admin.eps.list', compact('cities'));
    }

    public function getEps(Request $request)
    {
        //
         $query = Eps::with(['city','company','creatorUser']);
        // Get all departments from the database and include the related country data
        $eps = $query->get();

        // Return the departments as JSON
        return response()->json($eps);
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
        $eps = new Eps();
        $eps->nit = $request->input('nit');
        $eps->name_eps = $request->input('name_eps');
        $eps->city_id = $request->input('city_id');
        $eps->address = $request->input('address');
        $eps->phone = $request->input('phone');
        $eps->email = $request->input('email');
        $eps->created_by = Auth::user()->id;
        $eps->company_id = Auth::user()->company_id;
        $eps->save();
        return response()->json(['message' => 'Eps created successfully', 'eps' => $eps], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $eps = Eps::find($id);
        return response()->json($eps);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $eps = Eps::find($id);
        if (!$eps) {
            return response()->json(['error' => 'Registro no Encontrado']);;
        }
        return response()->json($eps);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $eps = Eps::find($id);
        if (!$eps) {
            return response()->json(['error' => 'Registro no Encontrado']);
        }
        $eps->nit = $request->input('nit');
        $eps->name_eps = $request->input('name_eps');
        $eps->city_id = $request->input('city_id');
        $eps->address = $request->input('address');
        $eps->phone = $request->input('phone');
        $eps->email = $request->input('email');
        $eps->save();
        return response()->json(['message' => 'Eps updated successfully', 'eps' => $eps]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $eps = Eps::find($id);
        if (!$eps) {
            return response()->json(['error' => 'Registro no Encontrado']);;
        }
        $eps->delete();
        return response()->json(['message' => 'Eps deleted successfully']);
    }

    public function toggleStatus($id)
    {
        $eps = Eps::find($id);
        if (!$eps) {
            return response()->json(['error' => 'Registro no Encontrado'], 404);
        }

        // Toggle the status
        $eps->status = $eps->status == 1 ? 0 : 1;
        $eps->save();

        return response()->json(['success' => 'Estado cambiado exitosamente.']);
    }
}
