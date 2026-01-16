<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\User;

/**
 * Servicio para gestionar permisos y control de acceso
 */
class PermissionService
{
    /**
     * Verificar si un usuario tiene un permiso específico
     */
    public static function hasPermission(User $user, string $module, string $action): bool
    {
        // TODO: Implementar cuando se conecte con la tabla de roles y permisos de usuario
        // Por ahora retorna true si el usuario es admin
        return $user->is_admin ?? false;
    }

    /**
     * Verificar si un usuario tiene alguno de los permisos especificados
     */
    public static function hasAnyPermission(User $user, array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (self::hasPermission($user, $permission['module'], $permission['action'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verificar si un usuario tiene todos los permisos especificados
     */
    public static function hasAllPermissions(User $user, array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!self::hasPermission($user, $permission['module'], $permission['action'])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Obtener todos los permisos de un módulo
     */
    public static function getModulePermissions(string $module): array
    {
        return Permission::where('module', $module)
            ->pluck('action', 'id')
            ->toArray();
    }

    /**
     * Obtener todos los permisos de una categoría
     */
    public static function getCategoryPermissions(string $category): array
    {
        return Permission::where('category', $category)
            ->get()
            ->groupBy('module')
            ->toArray();
    }

    /**
     * Obtener la estructura completa de permisos agrupada
     */
    public static function getCompletePermissionStructure(): array
    {
        $permissions = Permission::all();
        $structure = [];

        foreach ($permissions as $permission) {
            if (!isset($structure[$permission->module])) {
                $structure[$permission->module] = [];
            }
            
            $structure[$permission->module][] = [
                'id' => $permission->id,
                'action' => $permission->action,
                'description' => $permission->description,
                'category' => $permission->category,
                'is_system' => $permission->is_system
            ];
        }

        return $structure;
    }

    /**
     * Crear permisos por lote
     */
    public static function createBatch(array $permissions): array
    {
        $created = [];

        foreach ($permissions as $permission) {
            try {
                $created[] = Permission::create($permission);
            } catch (\Exception $e) {
                // Ignorar duplicados
                if (!str_contains($e->getMessage(), 'unique')) {
                    throw $e;
                }
            }
        }

        return $created;
    }

    /**
     * Sincronizar permisos de un módulo
     * (Útil para actualizar múltiples permisos del mismo módulo)
     */
    public static function syncModulePermissions(string $module, array $actions): array
    {
        $current = Permission::where('module', $module)->get();
        $synced = [];

        // Crear permisos faltantes
        foreach ($actions as $action => $data) {
            $exists = $current->where('action', $action)->first();
            
            if (!$exists) {
                $synced[] = Permission::create([
                    'module' => $module,
                    'action' => $action,
                    'description' => $data['description'] ?? null,
                    'category' => $data['category'] ?? null,
                    'is_system' => $data['is_system'] ?? false
                ]);
            }
        }

        return $synced;
    }
}
