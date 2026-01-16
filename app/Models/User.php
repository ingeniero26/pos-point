<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Role constants
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;
    const ROLE_SUPER_ADMIN = 3;

    // Status constants
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'is_role',
        'status',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    /**
     * Relación con roles (many-to-many)
     */
    public function roles()
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }

    /**
     * Obtener todos los permisos del usuario a través de sus roles
     */
    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            UserRole::class,
            'user_id',
            'id',
            'id',
            'role_id'
        )->join('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id')
         ->join('roles', 'role_permissions.role_id', '=', 'roles.id')
         ->distinct();
    }

    /**
     * Verificar si usuario tiene un permiso específico
     */
    public function hasPermission($module, $action)
    {
        return Permission::whereHas('rolePermissions', function ($query) {
            $query->whereIn('role_id', $this->roles()->pluck('role_id'));
        })
        ->where('module', $module)
        ->where('action', $action)
        ->exists();
    }

    /**
     * Verificar si usuario tiene alguno de los permisos
     */
    public function hasAnyPermission($permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission['module'], $permission['action'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verificar si usuario tiene todos los permisos
     */
    public function hasAllPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission['module'], $permission['action'])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Obtener todos los roles del usuario
     */
    public function getRolesList()
    {
        return $this->roles()->with('role')->get();
    }

    /**
     * Verificar si tiene un rol específico
     */
    public function hasRole($roleId)
    {
        return $this->roles()->where('role_id', $roleId)->exists();
    }

    // Role helper methods
    public function isAdmin()
    {
        return $this->is_role == self::ROLE_ADMIN;
    }

    public function isUser()
    {
        return $this->is_role == self::ROLE_USER;
    }

    public function isSuperAdmin()
    {
        return $this->is_role == self::ROLE_SUPER_ADMIN;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    // Get role name
    public function getRoleName()
    {
        switch ($this->is_role) {
            case self::ROLE_ADMIN:
                return 'Administrador';
            case self::ROLE_USER:
                return 'Usuario';
            case self::ROLE_SUPER_ADMIN:
                return 'Super Administrador';
            default:
                return 'Desconocido';
        }
    }

    // Get all available roles
    public static function getRoles()
    {
        return [
            self::ROLE_ADMIN => 'Administrador',
            self::ROLE_USER => 'Usuario',
            self::ROLE_SUPER_ADMIN => 'Super Administrador',
        ];
    }

    // Scope for active users
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    // Scope for super admins
    public function scopeSuperAdmins($query)
    {
        return $query->where('is_role', self::ROLE_SUPER_ADMIN);
    }

    // Scope for admins
    public function scopeAdmins($query)
    {
        return $query->where('is_role', self::ROLE_ADMIN);
    }

    // Scope for regular users
    public function scopeUsers($query)
    {
        return $query->where('is_role', self::ROLE_USER);
    }

    // Get full name
    public function getFullNameAttribute()
    {
        return trim($this->name . ' ' . $this->last_name);
    }
}
