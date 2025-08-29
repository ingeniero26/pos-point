<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\WarehouseModel;
use App\Models\AdjustmentType;
use App\Models\AdjustmentReason;
use App\Models\User;
use App\Models\Companies;
use App\Models\InventoryAdjustmentDetail;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryAdjustment extends Model
{
    //
    protected $table = 'inventory_adjustments';

    protected $fillable = [
        'adjustment_number',
        'warehouse_id',
        'adjustment_type_id',
        'reason_adjustment_id',
        'adjustment_date',
        'created_by',
        'company_id',
        'user_approval_id',
        'approval_date',
        'status',
        'comments',
        'support_document',
        'total_value',
    ];

    protected $casts = [
        'adjustment_date' => 'date',
        'approval_date' => 'datetime',
        'total_value' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Constantes para los estados
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_PENDING = 'PENDING';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_APPLIED = 'APPLIED';

    // Obtener todos los estados disponibles
    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => 'Borrador',
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_APPROVED => 'Aprobado',
            self::STATUS_REJECTED => 'Rechazado',
            self::STATUS_APPLIED => 'Aplicado',
        ];
    }

    // Relación con el almacén
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(WarehouseModel::class, 'warehouse_id');
    }

    // Relación con el tipo de ajuste
    public function adjustmentType(): BelongsTo
    {
        return $this->belongsTo(AdjustmentType::class, 'adjustment_type_id');
    }

    // Relación con la razón del ajuste
    public function reasonAdjustment(): BelongsTo
    {
        return $this->belongsTo(AdjustmentReason::class, 'reason_adjustment_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación con la empresa
    public function company(): BelongsTo
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    // Relación con el usuario que aprobó
    public function userApproval(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_approval_id');
    }

    public function adjustmentDetails(): HasMany
    {
        return $this->hasMany(InventoryAdjustmentDetail::class, 'inventory_adjustment_id');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeApplied($query)
    {
        return $query->where('status', self::STATUS_APPLIED);
    }

    // Scope para filtrar por warehouse
    public function scopeByWarehouse($query, $warehouseId)
    {
        return $query->where('warehouse_id', $warehouseId);
    }

    // Scope para filtrar por compañía
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Métodos de utilidad
    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isApplied()
    {
        return $this->status === self::STATUS_APPLIED;
    }

    public function canBeEdited()
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_REJECTED]);
    }

    public function canBeApproved()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function canBeApplied()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    // Generar número de ajuste automáticamente
    public static function generateAdjustmentNumber($prefix = 'ADJ')
    {
        $lastAdjustment = self::whereYear('created_at', now()->year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastAdjustment) {
            $lastNumber = intval(substr($lastAdjustment->adjustment_number, -6));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . '-' . now()->year . '-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    // Accessor para obtener el estado formateado
    public function getStatusLabelAttribute()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? $this->status;
    }

    // Accessor para formatear el valor total
    public function getFormattedTotalValueAttribute()
    {
        return number_format($this->total_value, 2, '.', ',');
    }
}
