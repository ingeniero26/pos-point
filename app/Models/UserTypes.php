<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTypes extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'description', 'is_system', 'created_by', 'company_id'];

    /**
     * Relación con el usuario que creó el rol
     */
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con compañía
     */
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    /**
     * Relación con usuarios a través de user_roles
     */
    public function users()
    {
        return $this->hasMany(UserRole::class, 'role_id');
    }

    /**
     * Relación con permisos
     */
    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id');
    }

    /**
     * Obtener permisos del rol con detalles
     */
    public function getPermissionsWithDetails()
    {
        return $this->permissions()
            ->with('permission')
            ->get()
            ->groupBy('permission.module');
    }

    /**
     * Asignar permisos al rol
     */
    public function assignPermissions($permissionIds)
    {
        // Limpiar permisos existentes si no es de sistema
        if (!$this->is_system) {
            $this->permissions()->delete();
        }

        // Asignar nuevos permisos
        $permissionsToAdd = [];
        foreach ($permissionIds as $permissionId) {
            $permissionsToAdd[] = [
                'role_id' => $this->id,
                'permission_id' => $permissionId,
            ];
        }

        if (!empty($permissionsToAdd)) {
            RolePermission::insert($permissionsToAdd);
        }

        return $this;
    }

    /**
     * Sincronizar permisos
     */
    public function syncPermissions($permissionIds)
    {
        // Obtener permisos actuales
        $currentPermissions = $this->permissions()->pluck('permission_id')->toArray();

        // Permisos a eliminar
        $toDelete = array_diff($currentPermissions, $permissionIds);
        if (!empty($toDelete)) {
            RolePermission::where('role_id', $this->id)
                ->whereIn('permission_id', $toDelete)
                ->delete();
        }

        // Permisos a agregar
        $toAdd = array_diff($permissionIds, $currentPermissions);
        if (!empty($toAdd)) {
            foreach ($toAdd as $permissionId) {
                RolePermission::create([
                    'role_id' => $this->id,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        return $this;
    }

    /**
     * Verificar si rol tiene permiso
     */
    public function hasPermission($module, $action)
    {
        return $this->permissions()
            ->whereHas('permission', function ($query) use ($module, $action) {
                $query->where('module', $module)
                      ->where('action', $action);
            })
            ->exists();
    }
}

