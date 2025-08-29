<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseModel extends Model
{
    //
    protected $table = 'warehouses';
  
    public function items()
    {
        return $this->belongsToMany(ItemsModel::class, 'item_warehouse')
            ->withPivot('stock', 'min_quantity', 'max_quantity', 'reorder_level');
    }


}
