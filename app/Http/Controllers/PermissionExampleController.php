<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use App\Models\Permission;

/**
 * Ejemplo de uso del sistema de permisos
 * Este archivo muestra cómo utilizar la funcionalidad de permisos
 */
class PermissionExampleController extends Controller
{
    /**
     * Ejemplo 1: Obtener estructura completa de permisos
     */
    public function example1_completeStructure()
    {
        $permissions = PermissionService::getCompletePermissionStructure();
        
        // Retorna algo como:
        // [
        //     'usuarios' => [
        //         ['id' => 1, 'action' => 'crear', 'description' => '...', ...],
        //         ['id' => 2, 'action' => 'editar', 'description' => '...', ...],
        //     ],
        //     'inventario' => [...]
        // ]
        
        return response()->json($permissions);
    }

    /**
     * Ejemplo 2: Obtener permisos de un módulo específico
     */
    public function example2_modulePermissions()
    {
        $userPermissions = PermissionService::getModulePermissions('usuarios');
        
        // Retorna: ['crear', 'editar', 'eliminar', 'ver']
        
        return response()->json($userPermissions);
    }

    /**
     * Ejemplo 3: Obtener permisos de una categoría
     */
    public function example3_categoryPermissions()
    {
        $adminPermissions = PermissionService::getCategoryPermissions('administración');
        
        // Retorna permisos de administración agrupados por módulo
        
        return response()->json($adminPermissions);
    }

    /**
     * Ejemplo 4: Crear permisos en lotes
     */
    public function example4_createBatch()
    {
        $permissionsToCreate = [
            [
                'module' => 'clientes',
                'action' => 'crear',
                'description' => 'Crear nuevos clientes',
                'category' => 'operación',
                'is_system' => false
            ],
            [
                'module' => 'clientes',
                'action' => 'editar',
                'description' => 'Editar clientes existentes',
                'category' => 'operación',
                'is_system' => false
            ],
            [
                'module' => 'clientes',
                'action' => 'eliminar',
                'description' => 'Eliminar clientes',
                'category' => 'operación',
                'is_system' => false
            ]
        ];

        $created = PermissionService::createBatch($permissionsToCreate);
        
        return response()->json([
            'message' => 'Permisos creados exitosamente',
            'count' => count($created),
            'permissions' => $created
        ]);
    }

    /**
     * Ejemplo 5: Sincronizar permisos de un módulo
     */
    public function example5_syncModulePermissions()
    {
        $actions = [
            'crear' => [
                'description' => 'Crear nuevos proveedores',
                'category' => 'operación',
                'is_system' => false
            ],
            'editar' => [
                'description' => 'Editar proveedores',
                'category' => 'operación',
                'is_system' => false
            ],
            'eliminar' => [
                'description' => 'Eliminar proveedores',
                'category' => 'operación',
                'is_system' => false
            ],
            'ver' => [
                'description' => 'Ver proveedores',
                'category' => 'operación',
                'is_system' => false
            ],
            'exportar' => [
                'description' => 'Exportar datos de proveedores',
                'category' => 'reporte',
                'is_system' => false
            ]
        ];

        $synced = PermissionService::syncModulePermissions('proveedores', $actions);
        
        return response()->json([
            'message' => 'Permisos sincronizados',
            'new_permissions' => $synced
        ]);
    }

    /**
     * Ejemplo 6: Usar directamente el modelo
     */
    public function example6_directModelUsage()
    {
        // Crear un permiso
        $permission = Permission::create([
            'module' => 'reportes_avanzados',
            'action' => 'generar',
            'description' => 'Generar reportes avanzados',
            'category' => 'reporte',
            'is_system' => false
        ]);

        // Buscar por módulo
        $modulePermissions = Permission::where('module', 'reportes_avanzados')->get();

        // Buscar por categoría
        $categoryPermissions = Permission::where('category', 'reporte')->get();

        // Verificar existencia
        $exists = Permission::checkPermission('reportes_avanzados', 'generar');

        // Obtener agrupado
        $grouped = Permission::groupedByModule();

        return response()->json([
            'created' => $permission,
            'module_permissions' => $modulePermissions,
            'category_permissions' => $categoryPermissions,
            'exists' => $exists,
            'grouped' => $grouped
        ]);
    }

    /**
     * Ejemplo 7: Listar todos los módulos disponibles
     */
    public function example7_listModules()
    {
        $modules = Permission::distinct()
            ->pluck('module')
            ->toArray();
        
        return response()->json([
            'modules' => $modules,
            'count' => count($modules)
        ]);
    }

    /**
     * Ejemplo 8: Listar todas las categorías disponibles
     */
    public function example8_listCategories()
    {
        $categories = Permission::distinct()
            ->pluck('category')
            ->filter()
            ->toArray();
        
        return response()->json([
            'categories' => $categories,
            'count' => count($categories)
        ]);
    }

    /**
     * Ejemplo 9: Obtener estadísticas de permisos
     */
    public function example9_permissionStats()
    {
        $totalPermissions = Permission::count();
        $systemPermissions = Permission::where('is_system', true)->count();
        $customPermissions = Permission::where('is_system', false)->count();
        $moduleCount = Permission::distinct('module')->count();
        $categoryCount = Permission::whereNotNull('category')->distinct('category')->count();

        $permissionsByModule = Permission::select('module')
            ->selectRaw('count(*) as count')
            ->groupBy('module')
            ->get()
            ->pluck('count', 'module');

        return response()->json([
            'total_permissions' => $totalPermissions,
            'system_permissions' => $systemPermissions,
            'custom_permissions' => $customPermissions,
            'total_modules' => $moduleCount,
            'total_categories' => $categoryCount,
            'permissions_by_module' => $permissionsByModule
        ]);
    }

    /**
     * Ejemplo 10: Buscar permisos con filtros complejos
     */
    public function example10_advancedSearch()
    {
        // Permisos de sistema de operación
        $systemOperationPermissions = Permission::where('is_system', true)
            ->where('category', 'operación')
            ->get();

        // Permisos de un módulo con descripción
        $permissionsWithDescription = Permission::where('module', 'usuarios')
            ->whereNotNull('description')
            ->get();

        // Contar permisos de creación en cada módulo
        $createPermissions = Permission::where('action', 'crear')
            ->selectRaw('module, count(*) as count')
            ->groupBy('module')
            ->get();

        return response()->json([
            'system_operation' => $systemOperationPermissions,
            'with_description' => $permissionsWithDescription,
            'create_actions' => $createPermissions
        ]);
    }
}

/**
 * NOTAS DE USO:
 * 
 * 1. PermissionService proporciona métodos estáticos listos para usar
 * 2. Permission model proporciona acceso directo a la BD con Eloquent
 * 3. Todos los métodos incluyen validación y manejo de errores
 * 4. Los permisos de sistema (is_system = 1) no se pueden eliminar
 * 5. La combinación module + action es única en la base de datos
 * 6. Los campos 'description' y 'category' son opcionales
 * 
 * INTEGRACIÓN CON ROLES (Próximo paso):
 * 
 * Para asignar permisos a roles, se necesita:
 * - Crear tabla role_permissions
 * - Agregar métodos en modelo User/Role
 * - Crear middleware para verificar permisos
 * - Agregar directivas Blade para mostrar/ocultar elementos
 */
