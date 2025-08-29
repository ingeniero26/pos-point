<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    protected $table = 'cash_registers';

    protected $fillable = [
        'code',
        'name',
        'location_description',
        'branch_id',
        'status',
        'company_id',
        'created_by'
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con la sucursal
    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }

    // Relación con la empresa
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    // Relación con el usuario que creó el registro
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope para cajas activas
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Scope para cajas inactivas
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    // Relación con las sesiones de caja
    public function sessions()
    {
        return $this->hasMany(CashRegisterSession::class);
    }

    // Verifica si la caja tiene una sesión abierta
    public function hasOpenSession()
    {
        return $this->sessions()
            ->where('closed_at', null)
            ->where('status', 'open')
            ->exists();
    }

    // Obtiene la sesión abierta actual
    public function getCurrentSession()
    {
        return $this->sessions()
            ->where('closing_time', null)
            ->where('status', 'open')
            ->first();
    }
}
