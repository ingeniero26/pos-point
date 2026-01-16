<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $timestamps = false;
    protected $table = 'user_roles';
    protected $fillable = ['user_id', 'role_id', 'company_id'];
    
    /**
     * Relación con usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con rol
     */
    public function role()
    {
        return $this->belongsTo(UserTypes::class, 'role_id');
    }

    /**
     * Relación con compañía
     */
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
