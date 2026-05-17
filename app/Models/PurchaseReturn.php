<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReturn extends Model
{
    // use SoftDeletes; // Descomenta si prefieres usar soft deletes en lugar de is_delete

    protected $table = 'purchase_returns';

    protected $primaryKey = 'id';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'purchase_id',
        'voucher_type_id',
        'supplier_id',
        'created_by',
        'invoice_no',
        'state_type_id',
        'warehouse_id',
        'branch_id',
        'date_of_return',
        'time_of_return',
        'series',
        'number',
        'reason_id',
        'currency_id',
        'total_subtotal',
        'total_tax',
        'total_discount',
        'total_return',
        'return_status_id',
        'electronic_document_status',
        'observations',
        'company_id',
        'is_delete',
    ];

    /**
     * Los atributos que deben ser casteados a tipos nativos.
     */
    protected $casts = [
        'purchase_id' => 'integer',
        'voucher_type_id' => 'integer',
        'supplier_id' => 'integer',
        'created_by' => 'integer',
        'state_type_id' => 'integer',
        'warehouse_id' => 'integer',
        'branch_id' => 'integer',
        'date_of_return' => 'date',
        'time_of_return' => 'datetime',
        'series' => 'string',
        'number' => 'integer',
        'reason_id' => 'integer',
        'currency_id' => 'integer',
        'total_subtotal' => 'decimal:2',
        'total_tax' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'total_return' => 'decimal:2',
        'return_status_id' => 'integer',
        'electronic_document_status' => 'string',
        'company_id' => 'integer',
        'is_delete' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Los atributos que deben ser ocultos para la serialización.
     */
    protected $hidden = [
        'is_delete',
    ];

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Relación con la compra original.
     */
    public function purchase()
    {
        return $this->belongsTo(PurchaseItemsModel::class, 'purchase_id', 'id');
    }

    /**
     * Relación con el proveedor.
     */
    public function supplier()
    {
        return $this->belongsTo(PersonModel::class, 'supplier_id', 'id');
    }

    /**
     * Relación con el usuario que creó la devolución.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Relación con el tipo de comprobante.
     */
    public function voucherType()
    {
        return $this->belongsTo(VoucherTypeModel::class, 'voucher_type_id', 'id');
    }

    /**
     * Relación con el tipo de estado.
     */
    public function stateType()
    {
        return $this->belongsTo(StateTypeModel::class, 'state_type_id', 'id');
    }

    /**
     * Relación con el almacén.
     */
    public function warehouse()
    {
        return $this->belongsTo(WarehouseModel::class, 'warehouse_id', 'id');
    }

    /**
     * Relación con la sucursal.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    /**
     * Relación con el motivo de devolución.
     */
    public function reason()
    {
        return $this->belongsTo(ReturnReason::class, 'reason_id', 'id');
    }

    /**
     * Relación con la moneda.
     */
    public function currency()
    {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id', 'id');
    }

    /**
     * Relación con el estado de la devolución.
     */
    public function returnStatus()
    {
        return $this->belongsTo(ReturnReason::class, 'return_status_id', 'id');
    }

    /**
     * Relación con la compañía.
     */
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope para obtener solo los registros activos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_delete', false);
    }

    /**
     * Scope para obtener solo registros eliminados.
     */
    public function scopeDeleted($query)
    {
        return $query->where('is_delete', true);
    }

    /**
     * Scope para filtrar por estado.
     */
    public function scopeByReturnStatus($query, $statusId)
    {
        return $query->where('return_status_id', $statusId);
    }

    /**
     * Scope para filtrar por proveedor.
     */
    public function scopeBySupplier($query, $supplierId)
    {
        return $query->where('supplier_id', $supplierId);
    }

    /**
     * Scope para filtrar por almacén.
     */
    public function scopeByWarehouse($query, $warehouseId)
    {
        return $query->where('warehouse_id', $warehouseId);
    }

    /**
     * Scope para filtrar por empresa.
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope para filtrar por rango de fechas.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date_of_return', [$startDate, $endDate]);
    }

    /**
     * Scope para obtener devoluciones pendientes.
     */
    public function scopePending($query)
    {
        return $query->where('return_status_id', 1); // Ajusta según tu ID de estado pendiente
    }

    /**
     * Scope para obtener devoluciones autorizadas.
     */
    public function scopeAuthorized($query)
    {
        return $query->where('return_status_id', 2); // Ajusta según tu ID de estado autorizado
    }

    /**
     * Scope para obtener devoluciones rechazadas.
     */
    public function scopeRejected($query)
    {
        return $query->where('return_status_id', 3); // Ajusta según tu ID de estado rechazado
    }

    // ============================================
    // MÉTODOS
    // ============================================

    /**
     * Obtiene el número completo de documento (serie + número).
     */
    public function getFullDocumentNumberAttribute()
    {
        if ($this->series && $this->number) {
            return "{$this->series}-{$this->number}";
        }
        return $this->invoice_no;
    }

    /**
     * Calcula el total de la devolución (subtotal + impuestos - descuentos).
     */
    public function calculateTotal()
    {
        return ($this->total_subtotal + $this->total_tax - $this->total_discount);
    }

    /**
     * Verifica si la devolución está pendiente.
     */
    public function isPending()
    {
        return $this->return_status_id == 1;
    }

    /**
     * Verifica si la devolución está autorizada.
     */
    public function isAuthorized()
    {
        return $this->return_status_id == 2;
    }

    /**
     * Verifica si la devolución está rechazada.
     */
    public function isRejected()
    {
        return $this->return_status_id == 3;
    }

    /**
     * Verifica si es un documento electrónico aceptado.
     */
    public function isElectronicAccepted()
    {
        return $this->electronic_document_status === 'accepted';
    }

    /**
     * Marca la devolución como aceptada.
     */
    public function markAsAccepted()
    {
        $this->return_status_id = 2; // Autorizada
        $this->electronic_document_status = 'accepted';
        $this->save();
        return $this;
    }

    /**
     * Marca la devolución como rechazada.
     */
    public function markAsRejected($reason = null)
    {
        $this->return_status_id = 3; // Rechazada
        $this->electronic_document_status = 'rejected';
        if ($reason) {
            $this->observations = $reason;
        }
        $this->save();
        return $this;
    }

    /**
     * Marca la devolución como eliminada lógicamente.
     */
    public function markAsDeleted()
    {
        $this->is_delete = true;
        $this->save();
        return $this;
    }

    /**
     * Restaura la devolución (elimina el marcado lógico).
     */
    public function restore()
    {
        $this->is_delete = false;
        $this->save();
        return $this;
    }

    // ============================================
    // EVENTOS DEL MODELO
    // ============================================

    /**
     * Se ejecuta antes de crear el modelo.
     */
    protected static function booting()
    {
        parent::booting();

        static::creating(function ($model) {
            // Calcula automáticamente el total si no está establecido
            if (is_null($model->total_return)) {
                $model->total_return = ($model->total_subtotal + $model->total_tax - $model->total_discount);
            }
        });
    }
}