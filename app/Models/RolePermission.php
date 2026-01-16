<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    public $timestamps = false;
    protected $table = 'role_permissions';
    protected $fillable = ['role_id', 'permission_id'];

    /**
     * Relación con rol
     */
    public function role()
    {
        return $this->belongsTo(UserTypes::class, 'role_id');
    }

    /**
     * Relación con permiso
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
