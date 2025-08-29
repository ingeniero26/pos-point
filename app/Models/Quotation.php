<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotations';
    
    protected $fillable = [
        'user_id',
        'state_type_id',
        'prefix',
        'number',
        'date_of_issue',
        'date_of_expiration',
        'customer_id',
        'payment_conditions',
        'currency_id',
        'exchange_rate',
        'subtotal',
        'total_discount',
        'total_tax',
        'total',
        'withholding_tax',
        'ica_tax',
        'iva_tax',
        'notes',
        'validity_days',
        'approved_by',
        'approval_date',
        'status_quotation_id',
        'converted_to_invoice',
        'sale_id',
        'company_id'
    ];

    protected $casts = [
        'date_of_issue' => 'datetime',
        'date_of_expiration' => 'date',
        'approval_date' => 'datetime',
        'exchange_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'total_tax' => 'decimal:2',
        'total' => 'decimal:2',
        'withholding_tax' => 'decimal:2',
        'ica_tax' => 'decimal:2',
        'iva_tax' => 'decimal:2',
        'converted_to_invoice' => 'boolean',
    ];

    public function voucherTypes()
    {
        return $this->belongsTo(VoucherTypeModel::class, 'voucher_type_id');
    }
    
    // estados factura
  
    // Payment conditions relationship
    public function paymentForm()
    {
        return $this->belongsTo(PaymentTypeModel::class, 'payment_form_id');
    }

    // User who created the quotation
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Customer relationship
    public function customer()
    {
        return $this->belongsTo(PersonModel::class, 'customer_id');
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethodModel::class, 'payment_method_id');
    }

    // Currency relationship
    public function currency()
    {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }

    // User who approved the quotation
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function warehouse()
    {
        return $this->belongsTo(WarehouseModel::class, 'warehouse_id');
    }

    // Status of the quotation
    public function statusQuotation()
    {
        return $this->belongsTo(StatusQuotation::class, 'status_quotation_id');
    }

    // Related sale if converted to invoice
    public function sale()
    {
        return $this->belongsTo(Sales::class, 'sale_id');
    }

    // Company relationship
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    // Quotation details/items
    public function quotation_items()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }
}
