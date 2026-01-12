<?php

namespace App\Http\Controllers;

use App\Models\UserTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.user_types.list');
    }

    public function getUserTypes()
    {
        // Implement your logic to fetch user types from your database
        $userTypes = UserTypes::all();
        // Return the fetched user types as a JSON response
        return response()->json($userTypes);
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
        $userType = new UserTypes();
        $userType->name = $request->name;
        $userType->description = $request->description;
        $userType->company_id = Auth::user()->company_id;
        $userType->created_by = Auth::user()->id;
        $userType->save();
         return response()->json(['message' => 'Tipo usuario registrado con exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $userType = UserTypes::find($id);
        return response()->json($userType);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $userType = UserTypes::find($id);
        if(!$userType){
            return response()->json(['message' => 'Tipo usuario no encontrado'], 404);
        }
        return response()->json($userType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $userType = UserTypes::find($id);
        $userType->name = $request->name;
        $userType->description = $request->description;
        $userType->save();
         return response()->json(['message' => 'Tipo usuario actualizado con exito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $userType = UserTypes::find($id);
        if(!$userType){
            return response()->json(['message' => 'Tipo usuario no encontrado'], 404);
        }
        $userType->is_delete = 1;
        $userType->save();
         return response()->json(['message' => 'Tipo usuario eliminado con exito']);
    }
    public function toggleStatus($id)
    {
        $userType = UserTypes::find($id);
        $userType->status = !$userType->status;
        $userType->save();
        return response()->json(['message' => 'Estado del tipo de usuario actualizado con exito']);
    }
}
