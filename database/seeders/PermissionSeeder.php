<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Usuario
            ['module' => 'usuarios', 'action' => 'crear', 'description' => 'Crear nuevos usuarios', 'category' => 'administración', 'is_system' => 1],
            ['module' => 'usuarios', 'action' => 'editar', 'description' => 'Editar usuarios existentes', 'category' => 'administración', 'is_system' => 1],
            ['module' => 'usuarios', 'action' => 'eliminar', 'description' => 'Eliminar usuarios', 'category' => 'administración', 'is_system' => 1],
            ['module' => 'usuarios', 'action' => 'ver', 'description' => 'Ver listado de usuarios', 'category' => 'administración', 'is_system' => 1],
            
            // Inventario
            ['module' => 'inventario', 'action' => 'crear', 'description' => 'Crear nuevos productos en inventario', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'inventario', 'action' => 'editar', 'description' => 'Editar productos del inventario', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'inventario', 'action' => 'eliminar', 'description' => 'Eliminar productos del inventario', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'inventario', 'action' => 'ver', 'description' => 'Ver inventario', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'inventario', 'action' => 'ajuste', 'description' => 'Realizar ajustes de inventario', 'category' => 'operación', 'is_system' => 1],
            
            // Ventas
            ['module' => 'ventas', 'action' => 'crear', 'description' => 'Crear nuevas ventas', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'ventas', 'action' => 'editar', 'description' => 'Editar ventas existentes', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'ventas', 'action' => 'eliminar', 'description' => 'Eliminar ventas', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'ventas', 'action' => 'ver', 'description' => 'Ver reporte de ventas', 'category' => 'operación', 'is_system' => 1],
            
            // Compras
            ['module' => 'compras', 'action' => 'crear', 'description' => 'Crear nuevas compras', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'compras', 'action' => 'editar', 'description' => 'Editar compras existentes', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'compras', 'action' => 'eliminar', 'description' => 'Eliminar compras', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'compras', 'action' => 'ver', 'description' => 'Ver compras', 'category' => 'operación', 'is_system' => 1],
            
            // Caja
            ['module' => 'caja', 'action' => 'abrir', 'description' => 'Abrir caja', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'caja', 'action' => 'cerrar', 'description' => 'Cerrar caja', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'caja', 'action' => 'ver_movimientos', 'description' => 'Ver movimientos de caja', 'category' => 'operación', 'is_system' => 1],
            
            // Reportes
            ['module' => 'reportes', 'action' => 'ver', 'description' => 'Ver reportes', 'category' => 'reporte', 'is_system' => 1],
            ['module' => 'reportes', 'action' => 'exportar', 'description' => 'Exportar reportes', 'category' => 'reporte', 'is_system' => 1],
            
            // Configuración
            ['module' => 'configuración', 'action' => 'editar', 'description' => 'Editar configuración del sistema', 'category' => 'administración', 'is_system' => 1],
            ['module' => 'configuración', 'action' => 'ver', 'description' => 'Ver configuración', 'category' => 'administración', 'is_system' => 1],
            
            // Permisos
            ['module' => 'permisos', 'action' => 'crear', 'description' => 'Crear nuevos permisos', 'category' => 'administración', 'is_system' => 1],
            ['module' => 'permisos', 'action' => 'editar', 'description' => 'Editar permisos', 'category' => 'administración', 'is_system' => 1],
            ['module' => 'permisos', 'action' => 'eliminar', 'description' => 'Eliminar permisos', 'category' => 'administración', 'is_system' => 1],
            ['module' => 'permisos', 'action' => 'ver', 'description' => 'Ver permisos', 'category' => 'administración', 'is_system' => 1],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'module' => $permission['module'],
                    'action' => $permission['action'],
                ],
                $permission
            );
        }
    }
}
