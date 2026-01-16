<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = ['module', 'action', 'description', 'category', 'is_system'];
    protected $casts = [
        'is_system' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con roles
     */
    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, 'permission_id');
    }

    /**
     * Relación directa con roles
     */
    public function roles()
    {
        return $this->hasManyThrough(
            UserTypes::class,
            RolePermission::class,
            'permission_id',
            'id',
            'id',
            'role_id'
        );
    }

    /**
     * Get all permissions grouped by module
     */
    public static function groupedByModule()
    {
        return self::all()->groupBy('module');
    }

    /**
     * Get permissions by category
     */
    public static function byCategory($category)
    {
        return self::where('category', $category)->get();
    }

    /**
     * Check if permission exists
     */
    public static function checkPermission($module, $action)
    {
        return self::where('module', $module)
            ->where('action', $action)
            ->exists();
    }

    /**
     * Obtener permisos de un módulo
     */
    public static function getModulePermissions($module)
    {
        return self::where('module', $module)->get();
    }

    /**
     * Obtener permisos de múltiples módulos
     */
    public static function getModulesPermissions($modules)
    {
        return self::whereIn('module', (array)$modules)->get();
    }
}

