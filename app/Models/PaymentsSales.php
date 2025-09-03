<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentsSales extends Model
{
    protected $table = 'payments_sales';
    
    protected $fillable = [
        'account_receivable_id',
        'payment_amount',
        'payment_date',
        'payment_method_id',
        'reference',
        'created_by',
        'updated_by',
        'deleted_by',
        'company_id',
        'is_delete'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'payment_amount' => 'decimal:2',
        'is_delete' => 'boolean'
    ];

    // Relación con cuenta por cobrar
    public function accountReceivable()
    {
        return $this->belongsTo(AccountsReceivable::class, 'account_receivable_id');
    }

    // Relación con método de pago
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethodModel::class, 'payment_method_id');
    }

    // Relación con usuario que creó el pago
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación con usuario que actualizó el pago
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relación con usuario que eliminó el pago
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Relación con compañía
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    // Scope para pagos activos
    public function scopeActive($query)
    {
        return $query->where('is_delete', 0);
    }

    // Scope para pagos de una fecha específica
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('payment_date', $date);
    }

    // Scope para pagos en un rango de fechas
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }
}