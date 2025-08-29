<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PucAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_code',
        'account_name',
        'level',
        'parent_code',
        'account_type',
        'nature',
        'third_party_handling',
        'cost_center_handling',
        'accept_movement',
        'company_id',
        'created_by',
        'status'
    ];

    protected $casts = [
        'third_party_handling' => 'boolean',
        'cost_center_handling' => 'boolean',
        'accept_movement' => 'boolean',
        'status' => 'boolean',
    ];

    // Relationship with parent account
    public function parent()
    {
        return $this->belongsTo(PucAccount::class, 'parent_code', 'account_code');
    }

    // Relationship with child accounts
    public function children()
    {
        return $this->hasMany(PucAccount::class, 'parent_code', 'account_code');
    }

    // Relationship with company
    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    // Relationship with creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope for active accounts
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope for specific company
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Scope for specific level
    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    // Scope for accounts that accept movement
    public function scopeMovementAccounts($query)
    {
        return $query->where('accept_movement', true);
    }

    // Get level name
    public function getLevelNameAttribute()
    {
        $levels = [
            1 => 'Clase',
            2 => 'Grupo',
            3 => 'Cuenta',
            4 => 'Subcuenta'
        ];

        return $levels[$this->level] ?? 'Desconocido';
    }

    // Get account type in Spanish
    public function getAccountTypeSpanishAttribute()
    {
        $types = [
            'ASSETS' => 'Activos',
            'LIABILITIES' => 'Pasivos',
            'EQUITY' => 'Patrimonio',
            'INCOME' => 'Ingresos',
            'EXPENSES' => 'Gastos',
            'COST' => 'Costos'
        ];

        return $types[$this->account_type] ?? $this->account_type;
    }

    // Get nature in Spanish
    public function getNatureSpanishAttribute()
    {
        return $this->nature === 'DEBIT' ? 'Débito' : 'Crédito';
    }

    // Get full account path
    public function getFullPathAttribute()
    {
        $path = $this->account_code . ' - ' . $this->account_name;
        
        if ($this->parent) {
            $path = $this->parent->full_path . ' > ' . $path;
        }

        return $path;
    }
}