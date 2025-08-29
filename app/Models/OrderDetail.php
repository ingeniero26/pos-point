<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    
    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
        'unit_price',
        'discount',
        'subtotal',
        'vat_rate',
        'vat_value',
        'total',
        'status_order_detail_id'
    ];

    // Relaciones
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function item()
    {
        return $this->belongsTo(ItemsModel::class, 'item_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusOrderDetailModel::class, 'status_order_detail_id');
    }
} 