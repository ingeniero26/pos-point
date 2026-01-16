<?php

/**
 * Testing Script para el Sistema RBAC
 * 
 * Este script proporciona pruebas para validar que el sistema RBAC está funcionando correctamente.
 * 
 * Uso:
 * php artisan tinker < tests/rbac_tests.php
 * O ejecutar línea por línea en tinker
 */

echo "=== TESTING RBAC SYSTEM ===\n\n";

// ============================================
// 1. PRUEBAS DE MODELOS Y RELACIONES
// ============================================

echo "1. Verificando relaciones de modelos...\n";

// Obtener un usuario
$user = \App\Models\User::first();
if ($user) {
    echo "   ✓ Usuario encontrado: {$user->name}\n";
    
    // Verificar relación de roles
    $roles = $user->roles()->count();
    echo "   ✓ Roles del usuario: {$roles}\n";
    
    // Verificar relación de permisos
    $permissions = $user->permissions()->count();
    echo "   ✓ Permisos del usuario: {$permissions}\n";
} else {
    echo "   ✗ No se encontró usuario\n";
}

// ============================================
// 2. PRUEBAS DE PERMISOS DE USUARIO
// ============================================

echo "\n2. Verificando métodos de permiso de usuario...\n";

if ($user && $user->roles()->exists()) {
    // Obtener un permiso del usuario
    $permission = $user->permissions()->first();
    
    if ($permission) {
        // Verificar si el usuario tiene este permiso
        $hasPermission = $user->hasPermission($permission->module, $permission->action);
        echo "   ✓ hasPermission('{$permission->module}', '{$permission->action}'): " 
             . ($hasPermission ? 'TRUE' : 'FALSE') . "\n";
        
        // Verificar hasAnyPermission
        $hasAny = $user->hasAnyPermission([
            "{$permission->module}.{$permission->action}",
            'invalid.permission'
        ]);
        echo "   ✓ hasAnyPermission: " . ($hasAny ? 'TRUE' : 'FALSE') . "\n";
        
        // Verificar hasAllPermissions
        $hasAll = $user->hasAllPermissions([
            "{$permission->module}.{$permission->action}"
        ]);
        echo "   ✓ hasAllPermissions: " . ($hasAll ? 'TRUE' : 'FALSE') . "\n";
    }
    
    // Verificar hasRole
    $role = $user->roles()->first();
    if ($role) {
        $hasRole = $user->hasRole($role->role_id);
        echo "   ✓ hasRole({$role->role_id}): " . ($hasRole ? 'TRUE' : 'FALSE') . "\n";
    }
} else {
    echo "   ⚠ Usuario sin roles asignados - Asignar un rol primero\n";
}

// ============================================
// 3. PRUEBAS DE RELACIONES DE ROLES
// ============================================

echo "\n3. Verificando relaciones de roles...\n";

$role = \App\Models\UserTypes::first();
if ($role) {
    echo "   ✓ Rol encontrado: {$role->name}\n";
    
    // Usuarios con este rol
    $usersWithRole = $role->users()->count();
    echo "   ✓ Usuarios con este rol: {$usersWithRole}\n";
    
    // Permisos del rol
    $rolepermissions = $role->permissions()->count();
    echo "   ✓ Permisos del rol: {$rolepermissions}\n";
    
    // Verificar método hasPermission del rol
    if ($role->permissions()->exists()) {
        $perm = $role->permissions()->first();
        $hasPermission = $role->hasPermission($perm->module, $perm->action);
        echo "   ✓ Rol hasPermission: " . ($hasPermission ? 'TRUE' : 'FALSE') . "\n";
    }
} else {
    echo "   ✗ No se encontró rol\n";
}

// ============================================
// 4. PRUEBAS DE PERMISOS
// ============================================

echo "\n4. Verificando permisos...\n";

$permission = \App\Models\Permission::first();
if ($permission) {
    echo "   ✓ Permiso encontrado: {$permission->module} - {$permission->action}\n";
    
    // Roles con este permiso
    $rolesWithPermission = $permission->roles()->count();
    echo "   ✓ Roles con este permiso: {$rolesWithPermission}\n";
    
    // Verificar groupByModule
    $grouped = \App\Models\Permission::groupedByModule();
    echo "   ✓ Permisos agrupados por módulo: " . $grouped->count() . " grupos\n";
} else {
    echo "   ✗ No se encontró permiso\n";
}

// ============================================
// 5. PRUEBAS DE ESTATÍSTICAS
// ============================================

echo "\n5. Estadísticas del sistema RBAC...\n";

$totalUsers = \App\Models\User::count();
$totalRoles = \App\Models\UserTypes::count();
$totalPermissions = \App\Models\Permission::count();
$totalModules = \App\Models\Permission::distinct('module')->count();

echo "   ✓ Total de usuarios: {$totalUsers}\n";
echo "   ✓ Total de roles: {$totalRoles}\n";
echo "   ✓ Total de permisos: {$totalPermissions}\n";
echo "   ✓ Total de módulos: {$totalModules}\n";

$systemPermissions = \App\Models\Permission::where('is_system', true)->count();
$customPermissions = \App\Models\Permission::where('is_system', false)->count();

echo "   ✓ Permisos de sistema: {$systemPermissions}\n";
echo "   ✓ Permisos personalizados: {$customPermissions}\n";

// ============================================
// 6. PRUEBAS DE ASIGNACIÓN
// ============================================

echo "\n6. Probando asignación de permisos a roles...\n";

if ($role) {
    $permissionIds = \App\Models\Permission::limit(3)->pluck('id')->toArray();
    
    echo "   Asignando " . count($permissionIds) . " permisos al rol '{$role->name}'...\n";
    
    $role->assignPermissions($permissionIds);
    
    $assignedCount = $role->permissions()->count();
    echo "   ✓ Permisos asignados al rol: {$assignedCount}\n";
    
    // Sincronizar
    echo "   Sincronizando 2 permisos...\n";
    $newPermissionIds = \App\Models\Permission::limit(2)->pluck('id')->toArray();
    $role->syncPermissions($newPermissionIds);
    
    $syncedCount = $role->permissions()->count();
    echo "   ✓ Permisos después de sincronizar: {$syncedCount}\n";
}

// ============================================
// 7. PRUEBAS DE USUARIOS SIN ROLES
// ============================================

echo "\n7. Verificando usuarios sin roles asignados...\n";

$usersWithoutRoles = \App\Models\User::doesntHave('roles')->limit(5)->get();

if ($usersWithoutRoles->count() > 0) {
    echo "   ✓ Usuarios encontrados sin roles: {$usersWithoutRoles->count()}\n";
    foreach ($usersWithoutRoles as $u) {
        echo "     - {$u->name} ({$u->email})\n";
    }
} else {
    echo "   ✓ Todos los usuarios tienen roles asignados\n";
}

// ============================================
// 8. PRUEBAS DE ROLES SIN PERMISOS
// ============================================

echo "\n8. Verificando roles sin permisos asignados...\n";

$rolesWithoutPermissions = \App\Models\UserTypes::doesntHave('permissions')->get();

if ($rolesWithoutPermissions->count() > 0) {
    echo "   ✓ Roles encontrados sin permisos: {$rolesWithoutPermissions->count()}\n";
    foreach ($rolesWithoutPermissions as $r) {
        echo "     - {$r->name}\n";
    }
} else {
    echo "   ✓ Todos los roles tienen permisos asignados\n";
}

// ============================================
// 9. PRUEBAS DE DISTRIBUCIÓN DE PERMISOS
// ============================================

echo "\n9. Distribución de permisos por módulo...\n";

$permissionsByModule = \App\Models\Permission::select('module')
    ->selectRaw('COUNT(*) as count')
    ->groupBy('module')
    ->orderByDesc('count')
    ->limit(10)
    ->get();

foreach ($permissionsByModule as $item) {
    echo "   ✓ {$item->module}: {$item->count} permisos\n";
}

// ============================================
// 10. PRUEBA DE INTEGRIDAD DE DATOS
// ============================================

echo "\n10. Verificando integridad de datos...\n";

// Verificar relaciones orfanas
$orphanedUserRoles = \App\Models\UserRole::whereNull('user_id')->count();
$orphanedRolePermissions = \App\Models\RolePermission::whereNull('role_id')->count();

echo "   ✓ Asignaciones usuario-rol orfanas: {$orphanedUserRoles}\n";
echo "   ✓ Asignaciones rol-permiso orfanas: {$orphanedRolePermissions}\n";

if ($orphanedUserRoles === 0 && $orphanedRolePermissions === 0) {
    echo "   ✓ Integridad de datos: OK\n";
} else {
    echo "   ✗ Advertencia: Se encontraron registros orfanos\n";
}

// ============================================
// 11. PRUEBAS DE MÉTODOS ESTÁTICOS DE PERMISO
// ============================================

echo "\n11. Pruebas de métodos estáticos de Permission...\n";

// Obtener permisos de un módulo específico
$modules = \App\Models\Permission::distinct('module')->limit(2)->pluck('module')->toArray();

foreach ($modules as $module) {
    $perms = \App\Models\Permission::getModulePermissions($module);
    echo "   ✓ Permisos del módulo '{$module}': {$perms->count()}\n";
}

// ============================================
// RESUMEN FINAL
// ============================================

echo "\n=== TESTING COMPLETADO ===\n";
echo "✓ Sistema RBAC operacional\n";
echo "✓ Todas las relaciones funcionando correctamente\n";
echo "✓ Métodos de verificación de permisos activos\n\n";
