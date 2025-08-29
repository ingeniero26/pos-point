<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function list()
    {
        return view('admin.admin.list');
    }
    public function getAdmins()
    {
        try {
            $admins = \App\Models\User::where('is_role', '1')
                ->where('is_delete', 0)
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $admins,
                'total' => $admins->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching admins: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function edit($id)
    {
        $admin = \App\Models\User::find($id)->where('is_role', 1)
        ->where('is_delete', 0)
        ->first();
        return response()->json([
           'success' => true,
            'data' => $admin,
        ]);
    }

}
