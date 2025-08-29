<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $fillable = [
        'order_number',
        'quotation_id',
        'person_id',
        'issue_date',
        'delivery_date',
        'currency_id',
        'exchange_rate',
        'subtotal',
        'discount',
        'vat',
        'total',
        'payment_form_id',
        'delivery_address',
        'created_by',
        'status_order_id',
        'company_id'
    ];

  protected $dates = ['issue_date', 'delivery_date'];
// O en Laravel 7+:
protected $casts = [
    'issue_date' => 'datetime',
    'delivery_date' => 'datetime',
];
    // Relaciones
    public function customers()
    {
        return $this->belongsTo(PersonModel::class, 'person_id');
    }

    public function currency()
    {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }

    public function paymentForm()
    {
        return $this->belongsTo(PaymentTypeModel::class, 'payment_form_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusOrder::class, 'status_order_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }
}
