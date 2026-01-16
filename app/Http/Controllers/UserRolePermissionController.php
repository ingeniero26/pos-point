<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTypes;
use App\Models\UserRole;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRolePermissionController extends Controller
{
    /**
     * Mostrar listado de usuarios con sus roles
     */
    public function listUserRoles()
    {
        return view('admin.users.roles.list');
    }

    /**
     * Obtener usuarios con roles en JSON
     */
    public function getUsersWithRoles()
    {
        $users = User::with('roles.role')->get();
        return response()->json($users);
    }

    /**
     * Mostrar formulario para asignar roles a usuario
     */
    public function assignRolesToUser($userId)
    {
        $user = User::findOrFail($userId);
        $roles = UserTypes::all();
        $userRoles = $user->roles()->pluck('role_id')->toArray();

        return view('admin.users.roles.assign', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Guardar roles asignados a usuario
     */
    public function storeUserRoles(Request $request, $userId)
    {
        $validated = $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'integer|exists:roles,id',
        ]);

        $user = User::findOrFail($userId);
        $companyId = $user->company_id;

        // Limpiar roles actuales
        $user->roles()->delete();

        // Asignar nuevos roles
        foreach ($validated['roles'] as $roleId) {
            UserRole::create([
                'user_id' => $userId,
                'role_id' => $roleId,
                'company_id' => $companyId,
            ]);
        }

        return response()->json([
            'message' => 'Roles asignados correctamente',
            'user' => $user->load('roles.role')
        ]);
    }

    /**
     * Eliminar rol de usuario
     */
    public function removeRoleFromUser($userId, $roleId)
    {
        $userRole = UserRole::where('user_id', $userId)
            ->where('role_id', $roleId)
            ->firstOrFail();

        $userRole->delete();

        return response()->json([
            'message' => 'Rol removido correctamente'
        ]);
    }

    /**
     * Mostrar listado de roles con sus permisos
     */
    public function listRolePermissions()
    {
        return view('admin.roles.permissions.list');
    }

    /**
     * Obtener roles con permisos en JSON
     */
    public function getRolesWithPermissions()
    {
        $roles = UserTypes::with('permissions.permission')->get();
        return response()->json($roles);
    }

    /**
     * Mostrar formulario para asignar permisos a rol
     */
    public function assignPermissionsToRole($roleId)
    {
        $role = UserTypes::findOrFail($roleId);
        $permissions = Permission::all()->groupBy('module');
        $rolePermissions = $role->permissions()->pluck('permission_id')->toArray();

        return view('admin.roles.permissions.assign', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Guardar permisos asignados a rol
     */
    public function storeRolePermissions(Request $request, $roleId)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $role = UserTypes::findOrFail($roleId);

        // Si es rol de sistema, no permitir cambios
        if ($role->is_system) {
            return response()->json([
                'message' => 'No se pueden modificar permisos de roles del sistema',
                'error' => true
            ], 403);
        }

        // Sincronizar permisos
        $role->syncPermissions($validated['permissions']);

        return response()->json([
            'message' => 'Permisos asignados correctamente',
            'role' => $role->load('permissions.permission')
        ]);
    }

    /**
     * Obtener permisos de un usuario
     */
    public function getUserPermissions($userId)
    {
        $user = User::findOrFail($userId);
        
        $permissions = Permission::whereHas('rolePermissions', function ($query) use ($user) {
            $query->whereIn('role_id', $user->roles()->pluck('role_id'));
        })
        ->select('id', 'module', 'action', 'description', 'category')
        ->orderBy('module')
        ->orderBy('action')
        ->get()
        ->groupBy('module');

        return response()->json([
            'user' => $user,
            'permissions' => $permissions,
            'permission_count' => $permissions->flatMap(fn($p) => $p)->count()
        ]);
    }

    /**
     * Obtener permisos de un rol
     */
    public function getRolePermissions($roleId)
    {
        $role = UserTypes::findOrFail($roleId);
        
        $permissions = Permission::whereHas('rolePermissions', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })
        ->select('id', 'module', 'action', 'description', 'category')
        ->orderBy('module')
        ->orderBy('action')
        ->get()
        ->groupBy('module');

        return response()->json([
            'role' => $role,
            'permissions' => $permissions,
            'permission_count' => $permissions->flatMap(fn($p) => $p)->count()
        ]);
    }

    /**
     * Obtener permisos disponibles por módulo
     */
    public function getAvailablePermissions()
    {
        $permissions = Permission::all()
            ->groupBy('module')
            ->map(function ($group) {
                return $group->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'action' => $permission->action,
                        'description' => $permission->description,
                        'category' => $permission->category,
                        'is_system' => $permission->is_system
                    ];
                });
            });

        return response()->json($permissions);
    }

    /**
     * Dashboard de resumen de roles y permisos
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalRoles = UserTypes::count();
        $totalPermissions = Permission::count();
        $usersWithoutRoles = User::doesntHave('roles')->count();
        
        $roleStats = UserTypes::select('id', 'name')
            ->withCount('users')
            ->get();

        return view('admin.roles.permissions.dashboard', compact(
            'totalUsers',
            'totalRoles',
            'totalPermissions',
            'usersWithoutRoles',
            'roleStats'
        ));
    }

    /**
     * Obtener estadísticas en JSON
     */
    public function getDashboardStats()
    {
        $totalUsers = User::count();
        $totalRoles = UserTypes::count();
        $totalPermissions = Permission::count();
        $usersWithoutRoles = User::doesntHave('roles')->count();
        
        $roleStats = UserTypes::select('id', 'name')
            ->withCount(['users', 'permissions'])
            ->get();

        $permissionStats = Permission::select('category')
            ->selectRaw('count(*) as count')
            ->groupBy('category')
            ->get();

        return response()->json([
            'users' => [
                'total' => $totalUsers,
                'without_roles' => $usersWithoutRoles,
                'with_roles' => $totalUsers - $usersWithoutRoles
            ],
            'roles' => [
                'total' => $totalRoles,
                'stats' => $roleStats
            ],
            'permissions' => [
                'total' => $totalPermissions,
                'by_category' => $permissionStats
            ]
        ]);
    }
}
