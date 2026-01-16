<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        return view('admin.permissions.list');
    }

    /**
     * Get all permissions as JSON
     */
    public function getPermissions()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    /**
     * Get permissions grouped by module
     */
    public function getPermissionsGrouped()
    {
        $permissions = Permission::all()->groupBy('module');
        return response()->json($permissions);
    }

    /**
     * Get permissions by category
     */
    public function getPermissionsByCategory($category)
    {
        $permissions = Permission::where('category', $category)->get();
        return response()->json($permissions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'module' => 'required|string|max:100',
            'action' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'is_system' => 'nullable|boolean',
        ]);

        // Check if permission already exists
        $exists = Permission::where('module', $validated['module'])
            ->where('action', $validated['action'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'El permiso ya existe',
                'error' => 'Este módulo y acción ya están registrados'
            ], 409);
        }

        $permission = Permission::create($validated);

        return response()->json([
            'message' => 'Permiso registrado exitosamente',
            'data' => $permission
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permiso no encontrado'
            ], 404);
        }

        return response()->json($permission);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permiso no encontrado'
            ], 404);
        }

        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permiso no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'module' => 'required|string|max:100',
            'action' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'is_system' => 'nullable|boolean',
        ]);

        // Check if another permission has the same module and action
        $exists = Permission::where('module', $validated['module'])
            ->where('action', $validated['action'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'El permiso ya existe',
                'error' => 'Este módulo y acción ya están registrados'
            ], 409);
        }

        $permission->update($validated);

        return response()->json([
            'message' => 'Permiso actualizado exitosamente',
            'data' => $permission
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permiso no encontrado'
            ], 404);
        }

        // Prevent deletion of system permissions
        if ($permission->is_system) {
            return response()->json([
                'message' => 'No se pueden eliminar permisos de sistema',
                'error' => 'Este permiso es crítico para el funcionamiento del sistema'
            ], 403);
        }

        $permission->delete();

        return response()->json([
            'message' => 'Permiso eliminado exitosamente'
        ]);
    }

    /**
     * Bulk delete permissions
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ])['ids'];

        $systemPermissions = Permission::where('is_system', true)
            ->whereIn('id', $ids)
            ->exists();

        if ($systemPermissions) {
            return response()->json([
                'message' => 'No se pueden eliminar permisos de sistema'
            ], 403);
        }

        Permission::whereIn('id', $ids)->delete();

        return response()->json([
            'message' => 'Permisos eliminados exitosamente'
        ]);
    }
}
