<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItemModel extends Model
{
    //
    protected $table = 'purchase_order_item';
    // relacion con purchase order
    public function purchaseOrder()
    {
        return $this->belongsTo('App\Models\PurchaseOrderModel', 'purchase_order_id');
    }
    // relacion con items
    public function items()
    {
        return $this->belongsTo(ItemsModel::class, 'item_id');
    }
}
