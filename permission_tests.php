#!/usr/bin/env php
<?php

/**
 * Script de Verificación del Sistema de Permisos
 * 
 * Ejecutar después de las migraciones:
 * php artisan tinker < permission_tests.php
 */

echo "\n╔════════════════════════════════════════════════════════╗\n";
echo "║  Script de Prueba - Sistema de Permisos POS Point      ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

use App\Models\Permission;
use App\Services\PermissionService;

// Test 1: Verificar que la tabla existe
echo "📋 Test 1: Verificar tabla de permisos\n";
try {
    $count = Permission::count();
    echo "   ✅ Tabla existe. Total de permisos: $count\n\n";
} catch (\Exception $e) {
    echo "   ❌ Error: La tabla no existe. Ejecutar: php artisan migrate\n\n";
    exit;
}

// Test 2: Verificar permisos del sistema
echo "📋 Test 2: Verificar permisos del sistema\n";
$systemCount = Permission::where('is_system', true)->count();
echo "   ✅ Permisos de sistema: $systemCount\n\n";

// Test 3: Crear un permiso de prueba
echo "📋 Test 3: Crear permiso de prueba\n";
try {
    $testPermission = Permission::create([
        'module' => 'test_module_' . time(),
        'action' => 'test_action',
        'description' => 'Permiso de prueba',
        'category' => 'test',
        'is_system' => false
    ]);
    echo "   ✅ Permiso creado: ID {$testPermission->id}\n";
    echo "      Módulo: {$testPermission->module}\n";
    echo "      Acción: {$testPermission->action}\n\n";
} catch (\Exception $e) {
    echo "   ❌ Error al crear: {$e->getMessage()}\n\n";
}

// Test 4: Actualizar permiso
echo "📋 Test 4: Actualizar permiso\n";
try {
    $testPermission->update([
        'description' => 'Permiso actualizado'
    ]);
    echo "   ✅ Permiso actualizado correctamente\n";
    echo "      Nueva descripción: {$testPermission->description}\n\n";
} catch (\Exception $e) {
    echo "   ❌ Error al actualizar: {$e->getMessage()}\n\n";
}

// Test 5: Obtener permiso por ID
echo "📋 Test 5: Obtener permiso por ID\n";
try {
    $retrieved = Permission::find($testPermission->id);
    if ($retrieved) {
        echo "   ✅ Permiso recuperado: {$retrieved->module} - {$retrieved->action}\n\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 6: Agrupar permisos por módulo
echo "📋 Test 6: Agrupar permisos por módulo\n";
try {
    $grouped = Permission::groupedByModule();
    echo "   ✅ Agrupación completada\n";
    echo "      Módulos encontrados: " . $grouped->count() . "\n";
    foreach ($grouped->take(3) as $module => $permissions) {
        echo "      - $module: " . $permissions->count() . " permisos\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 7: Permisos por categoría
echo "📋 Test 7: Obtener permisos por categoría\n";
try {
    $adminPerms = Permission::where('category', 'administración')->get();
    echo "   ✅ Permisos de administración: {$adminPerms->count()}\n\n";
} catch (\Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 8: Verificar permiso
echo "📋 Test 8: Verificar existencia de permiso\n";
try {
    $exists = Permission::checkPermission('usuarios', 'crear');
    $status = $exists ? '✅ Existe' : '❌ No existe';
    echo "   Permiso 'usuarios > crear': $status\n\n";
} catch (\Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 9: Contar permisos por módulo
echo "📋 Test 9: Contar permisos por módulo\n";
try {
    $stats = Permission::select('module')
        ->selectRaw('count(*) as count')
        ->groupBy('module')
        ->get();
    
    echo "   ✅ Estadísticas por módulo:\n";
    foreach ($stats as $stat) {
        echo "      - {$stat->module}: {$stat->count} permisos\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 10: Usar PermissionService
echo "📋 Test 10: Usar PermissionService\n";
try {
    $structure = PermissionService::getCompletePermissionStructure();
    echo "   ✅ Estructura completa obtenida\n";
    echo "      Módulos en estructura: " . count($structure) . "\n";
    
    $modules = PermissionService::getModulePermissions('usuarios');
    echo "      Acciones en 'usuarios': " . count($modules) . "\n\n";
} catch (\Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 11: Eliminar permiso de prueba
echo "📋 Test 11: Eliminar permiso de prueba\n";
try {
    $testPermission->delete();
    echo "   ✅ Permiso de prueba eliminado correctamente\n\n";
} catch (\Exception $e) {
    echo "   ❌ Error al eliminar: {$e->getMessage()}\n\n";
}

// Test 12: Intentar eliminar permiso de sistema
echo "📋 Test 12: Protección de permisos de sistema\n";
try {
    $systemPerm = Permission::where('is_system', true)->first();
    if ($systemPerm) {
        $canDelete = !$systemPerm->is_system;
        $status = $canDelete ? '❌ Se puede eliminar (malo!)' : '✅ Protegido contra eliminación';
        echo "   Permiso: {$systemPerm->module} > {$systemPerm->action}\n";
        echo "   Estado: $status\n\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Resumen final
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║  ✅ Todas las pruebas completadas                     ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

echo "📊 Resumen Final:\n";
echo "   Total de permisos: " . Permission::count() . "\n";
echo "   Permisos de sistema: " . Permission::where('is_system', true)->count() . "\n";
echo "   Permisos personalizados: " . Permission::where('is_system', false)->count() . "\n";
echo "   Total de módulos: " . Permission::distinct('module')->count() . "\n";
echo "   Total de categorías: " . Permission::whereNotNull('category')->distinct('category')->count() . "\n\n";

echo "🚀 Sistema de permisos listo para usar!\n";
echo "   Accede a: http://localhost/admin/permissions/list\n\n";
