<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItemsModel extends Model
{
    //
    protected $table = 'purchase_items';
     
    protected $fillable = [
        'purchase_id',
        'item_id',
        'warehouse_id',
        'quantity',
        'cost_price',
        'discount_percent',
    ];

    // proveedor
    public function supplier()
    {
        return $this->belongsTo(PersonModel::class, 'supplier_id');
    }
    // purchase
    public function purchase()
    {
        return $this->belongsTo(PurchaseModel::class, 'purchase_id');
    }
    // items
    public function item()
    {
        return $this->belongsTo(ItemsModel::class,'item_id');
    }





}
