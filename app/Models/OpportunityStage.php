<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpportunityStage extends Model
{
    //
    protected $table = 'opportunity_stages';
    protected $fillable = [
        'name',
        'description',
        'order',
        'closing_percentage',
        'colour',
        'is_closing_stage',
        'company_id',
        'created_by',
        'status'
    ];

     protected $casts = [
        'closing_percentage' => 'decimal:2',
        'is_closing_stage' => 'boolean',
        'status' => 'boolean',
        'is_delete' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'closing_percentage' => 0.00,
        'is_closing_stage' => false,
        'status' => true,
        'is_delete' => false,
    ];
    // Scope para obtener solo registros activos (no eliminados)
    public function scopeActive($query)
    {
        return $query->where('is_delete', false);
    }

    // Scope para obtener solo registros con status activo
    public function scopeEnabled($query)
    {
        return $query->where('status', true);
    }

    // Scope para ordenar por campo 'order'
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Scope para filtrar por compañía
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Relación con la tabla de compañías (asumiendo que existe)
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    // Relación con el usuario que creó el registro
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    // Mutator para asegurar que el porcentaje esté entre 0 y 100
    public function setClosingPercentageAttribute($value)
    {
        $this->attributes['closing_percentage'] = max(0, min(100, $value));
    }

    // Accessor para obtener el porcentaje formateado
    public function getClosingPercentageFormattedAttribute()
    {
        return number_format($this->closing_percentage, 2) . '%';
    }

    public function softDelete()
    {
        $this->is_delete = true;
        return $this->save();
    }

    // Método para restaurar soft delete
    public function restore()
    {
        $this->is_delete = false;
        return $this->save();
    }

    // Método para verificar si es etapa de cierre
    public function isClosingStage()
    {
        return $this->is_closing_stage;
    }

    // Método para verificar si está activo
    public function isActive()
    {
        return $this->status && !$this->is_delete;
    }
}
