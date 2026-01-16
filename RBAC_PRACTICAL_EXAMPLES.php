<?php

/**
 * EJEMPLOS PRÁCTICOS DE USO DEL SISTEMA RBAC
 * 
 * Este archivo contiene ejemplos de código real de cómo usar el sistema RBAC
 * en diferentes escenarios de tu aplicación.
 */

// ============================================
// 1. VERIFICAR PERMISOS DE USUARIO
// ============================================

/**
 * Ejemplo 1: Verificar si un usuario puede crear usuarios
 */
class UserController {
    public function create() {
        $user = auth()->user();
        
        if ($user->hasPermission('usuarios', 'crear')) {
            // Mostrar formulario de creación
            return view('users.create');
        }
        
        abort(403, 'No tienes permiso para crear usuarios');
    }
}

/**
 * Ejemplo 2: Verificar múltiples permisos (OR)
 */
class ReportController {
    public function export() {
        $user = auth()->user();
        
        // Usuario puede exportar si tiene uno de estos permisos
        if ($user->hasAnyPermission([
            'reportes.exportar',
            'reportes.exportar_avanzado',
            'administrador.acceso_total'
        ])) {
            return $this->generateReport();
        }
        
        abort(403);
    }
}

/**
 * Ejemplo 3: Verificar todos los permisos (AND)
 */
class AdminController {
    public function systemSettings() {
        $user = auth()->user();
        
        // Usuario necesita TODOS estos permisos
        if ($user->hasAllPermissions([
            'sistema.configurar',
            'sistema.backup',
            'sistema.usuarios'
        ])) {
            return view('admin.system-settings');
        }
        
        abort(403);
    }
}

/**
 * Ejemplo 4: Verificar un rol específico
 */
class SuperAdminPanel {
    public function index() {
        $user = auth()->user();
        
        // Verificar si tiene el rol específico (por ejemplo, id = 1 es Admin)
        if ($user->hasRole(1)) {
            return view('admin.super-admin-panel');
        }
        
        abort(403);
    }
}

// ============================================
// 2. ASIGNAR ROLES A USUARIOS
// ============================================

/**
 * Ejemplo 5: Asignar roles a un usuario en el controlador
 */
class AssignRolesController {
    public function assignRoles(Request $request, $userId) {
        $user = User::findOrFail($userId);
        $roleIds = $request->input('roles', []);
        
        // Limpiar roles anteriores y asignar nuevos
        $user->roles()->detach();
        
        foreach ($roleIds as $roleId) {
            UserRole::firstOrCreate([
                'user_id' => $user->id,
                'role_id' => $roleId,
                'company_id' => auth()->user()->company_id
            ]);
        }
        
        return response()->json([
            'message' => 'Roles asignados correctamente',
            'user' => $user->load('roles')
        ]);
    }
}

/**
 * Ejemplo 6: Asignar un único rol
 */
class UserService {
    public function assignRole(User $user, int $roleId, ?int $companyId = null) {
        UserRole::firstOrCreate([
            'user_id' => $user->id,
            'role_id' => $roleId,
            'company_id' => $companyId ?? auth()->user()->company_id
        ]);
        
        return true;
    }
}

/**
 * Ejemplo 7: Remover un rol de un usuario
 */
class UserService {
    public function removeRole(User $user, int $roleId) {
        $user->roles()->detach($roleId);
        return true;
    }
}

// ============================================
// 3. GESTIONAR PERMISOS DE ROLES
// ============================================

/**
 * Ejemplo 8: Asignar permisos a un rol
 */
class RoleService {
    public function assignPermissions(UserTypes $role, array $permissionIds) {
        // Reemplaza todos los permisos del rol
        $role->assignPermissions($permissionIds);
        
        return response()->json([
            'message' => 'Permisos asignados',
            'role' => $role->load('permissions')
        ]);
    }
}

/**
 * Ejemplo 9: Sincronizar permisos (agregar/remover según sea necesario)
 */
class RoleService {
    public function syncRolePermissions(UserTypes $role, array $permissionIds) {
        // Solo actualiza los que hayan cambiado
        $role->syncPermissions($permissionIds);
        
        return true;
    }
}

/**
 * Ejemplo 10: Obtener permisos de un rol agrupados por módulo
 */
class RoleDetailsController {
    public function show(UserTypes $role) {
        $permissionsGrouped = $role->getPermissionsWithDetails();
        
        return view('roles.show', [
            'role' => $role,
            'permissions' => $permissionsGrouped
        ]);
    }
}

// ============================================
// 4. OBTENER INFORMACIÓN DE PERMISOS
// ============================================

/**
 * Ejemplo 11: Obtener todos los permisos de un usuario
 */
class UserPermissionsController {
    public function getUserPermissions(User $user) {
        $permissions = $user->permissions()
            ->orderBy('module')
            ->orderBy('action')
            ->get()
            ->groupBy('module');
        
        return response()->json([
            'user' => $user->only('id', 'name', 'email'),
            'permissions' => $permissions,
            'total' => $user->permissions()->count()
        ]);
    }
}

/**
 * Ejemplo 12: Obtener permisos de un rol específico
 */
class RolePermissionsController {
    public function getRolePermissions(UserTypes $role) {
        $permissions = $role->permissions()
            ->orderBy('module')
            ->orderBy('action')
            ->get();
        
        return response()->json([
            'role' => $role->only('id', 'name'),
            'permissions' => $permissions->groupBy('module'),
            'total' => $permissions->count()
        ]);
    }
}

/**
 * Ejemplo 13: Obtener permisos de un módulo específico
 */
class PermissionController {
    public function getModulePermissions($module) {
        $permissions = Permission::getModulePermissions($module);
        
        return response()->json([
            'module' => $module,
            'permissions' => $permissions,
            'count' => $permissions->count()
        ]);
    }
}

// ============================================
// 5. MIDDLEWARE Y AUTORIZACION
// ============================================

/**
 * Ejemplo 14: Middleware de autorización (OPCIONAL)
 * Crear en: app/Http/Middleware/CheckPermission.php
 */
class CheckPermission {
    public function handle($request, Closure $next, $module, $action) {
        if (!auth()->user()->hasPermission($module, $action)) {
            abort(403, 'Acceso denegado');
        }
        
        return $next($request);
    }
}

// Uso en rutas:
// Route::post('users/create', [UserController::class, 'store'])
//     ->middleware('permission:usuarios,crear');

/**
 * Ejemplo 15: Directiva Blade (OPCIONAL)
 * Crear en: app/Providers/BladeServiceProvider.php
 */
class BladeServiceProvider {
    public function boot() {
        // Directiva para permisos
        Blade::if('permission', function ($module, $action) {
            return auth()->user()->hasPermission($module, $action);
        });
        
        // Directiva para roles
        Blade::if('role', function ($roleId) {
            return auth()->user()->hasRole($roleId);
        });
    }
}

// Uso en vistas:
// @permission('usuarios', 'crear')
//     <a href="/users/create">Crear Usuario</a>
// @endpermission

// ============================================
// 6. CONSULTAS Y FILTROS
// ============================================

/**
 * Ejemplo 16: Obtener usuarios que tienen un rol específico
 */
class UserQuery {
    public function getUsersWithRole($roleId) {
        $users = User::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->get();
        
        return $users;
    }
}

/**
 * Ejemplo 17: Obtener usuarios que tienen un permiso específico
 */
class UserQuery {
    public function getUsersWithPermission($module, $action) {
        $users = User::whereHas('permissions', function ($query) use ($module, $action) {
            $query->where('module', $module)
                  ->where('action', $action);
        })->get();
        
        return $users;
    }
}

/**
 * Ejemplo 18: Obtener roles que tienen un permiso específico
 */
class RoleQuery {
    public function getRolesWithPermission($module, $action) {
        $roles = UserTypes::whereHas('permissions', function ($query) use ($module, $action) {
            $query->where('module', $module)
                  ->where('action', $action);
        })->get();
        
        return $roles;
    }
}

/**
 * Ejemplo 19: Obtener usuarios sin roles asignados
 */
class UserQuery {
    public function getUsersWithoutRoles() {
        $users = User::doesntHave('roles')
            ->where('is_active', true)
            ->get();
        
        return $users;
    }
}

/**
 * Ejemplo 20: Obtener roles sin permisos asignados
 */
class RoleQuery {
    public function getRolesWithoutPermissions() {
        $roles = UserTypes::doesntHave('permissions')
            ->where('is_system', false)
            ->get();
        
        return $roles;
    }
}

// ============================================
// 7. OPERACIONES EN MASA
// ============================================

/**
 * Ejemplo 21: Asignar el mismo rol a múltiples usuarios
 */
class BulkOperations {
    public function assignRoleToUsers(array $userIds, int $roleId, ?int $companyId = null) {
        $companyId = $companyId ?? auth()->user()->company_id;
        
        foreach ($userIds as $userId) {
            UserRole::firstOrCreate([
                'user_id' => $userId,
                'role_id' => $roleId,
                'company_id' => $companyId
            ]);
        }
        
        return count($userIds) . ' usuarios actualizados';
    }
}

/**
 * Ejemplo 22: Remover el mismo rol de múltiples usuarios
 */
class BulkOperations {
    public function removeRoleFromUsers(array $userIds, int $roleId) {
        UserRole::whereIn('user_id', $userIds)
            ->where('role_id', $roleId)
            ->delete();
        
        return count($userIds) . ' usuarios actualizados';
    }
}

/**
 * Ejemplo 23: Copiar permisos de un rol a otro
 */
class RoleOperations {
    public function copyPermissions(UserTypes $sourceRole, UserTypes $targetRole) {
        $permissions = $sourceRole->permissions()->pluck('id')->toArray();
        $targetRole->syncPermissions($permissions);
        
        return true;
    }
}

// ============================================
// 8. AUDITORÍA (OPCIONAL)
// ============================================

/**
 * Ejemplo 24: Registrar cambios de permisos
 */
class RoleAudit {
    public function logPermissionChange(UserTypes $role, array $oldPermissions, array $newPermissions) {
        $added = array_diff($newPermissions, $oldPermissions);
        $removed = array_diff($oldPermissions, $newPermissions);
        
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'role_permissions_updated',
            'subject_type' => UserTypes::class,
            'subject_id' => $role->id,
            'old_values' => ['permissions' => $removed],
            'new_values' => ['permissions' => $added],
            'description' => "Permisos del rol '{$role->name}' actualizados"
        ]);
    }
}

// ============================================
// 9. REPORTES
// ============================================

/**
 * Ejemplo 25: Reporte de usuarios y sus roles
 */
class ReportController {
    public function userRolesReport() {
        $users = User::with('roles.permissions')
            ->where('is_active', true)
            ->get()
            ->map(function ($user) {
                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->pluck('name')->toArray(),
                    'permissions_count' => $user->permissions()->count()
                ];
            });
        
        return $users;
    }
}

/**
 * Ejemplo 26: Reporte de distribución de permisos
 */
class ReportController {
    public function permissionDistributionReport() {
        $distribution = Permission::select('module')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('module')
            ->orderByDesc('total')
            ->get();
        
        return $distribution;
    }
}

/**
 * Ejemplo 27: Matriz de acceso (Usuarios × Permisos)
 */
class ReportController {
    public function accessMatrixReport() {
        $users = User::with('permissions')->get();
        $permissions = Permission::all();
        
        $matrix = [];
        
        foreach ($users as $user) {
            $userPerms = $user->permissions()->pluck('id')->toArray();
            
            foreach ($permissions as $perm) {
                $matrix[$user->name][$perm->module . '.' . $perm->action] = 
                    in_array($perm->id, $userPerms) ? '✓' : '✗';
            }
        }
        
        return $matrix;
    }
}

// ============================================
// 10. HELPERS Y FUNCIONES ÚTILES
// ============================================

/**
 * Ejemplo 28: Helper para verificar permisos (app/Helpers/AuthHelper.php)
 */
class AuthHelper {
    public static function hasPermission($module, $action) {
        return auth()->user()->hasPermission($module, $action);
    }
    
    public static function hasRole($roleId) {
        return auth()->user()->hasRole($roleId);
    }
    
    public static function userPermissions() {
        return auth()->user()->permissions()->get();
    }
}

// Uso en vistas:
// @if(AuthHelper::hasPermission('usuarios', 'crear'))
//     Mostrar botón crear
// @endif

/**
 * Ejemplo 29: Macro de colección para obtener permisos únicos
 */
class AppServiceProvider {
    public function boot() {
        Collection::macro('groupPermissions', function () {
            return $this->groupBy('module')
                ->map(function ($perms) {
                    return $perms->groupBy('action');
                });
        });
    }
}

// Uso:
// $permissions = $user->permissions->groupPermissions();

/**
 * Ejemplo 30: Scope para filtrar usuarios activos con roles
 */
class User {
    public function scopeActiveWithRoles($query) {
        return $query->where('is_active', true)
            ->with('roles')
            ->has('roles');
    }
}

// Uso:
// $users = User::activeWithRoles()->get();

// ============================================
// RESUMEN DE ACCESO RÁPIDO
// ============================================

/**
 * Métodos más usados
 */

// Verificar un permiso
auth()->user()->hasPermission('modulo', 'accion');

// Obtener todos los permisos del usuario
auth()->user()->permissions()->get();

// Obtener roles del usuario
auth()->user()->roles()->get();

// Asignar roles a usuario
foreach ($roleIds as $roleId) {
    UserRole::firstOrCreate(['user_id' => $userId, 'role_id' => $roleId]);
}

// Asignar permisos a rol
$role->assignPermissions($permissionIds);

// Obtener permisos de un rol
$role->permissions()->get();

// Verificar si usuario tiene un rol
auth()->user()->hasRole($roleId);
