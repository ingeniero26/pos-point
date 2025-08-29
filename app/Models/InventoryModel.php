<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    //
    protected $table = 'item_warehouse';
    protected $fillable = ['item_id', 'warehouse_id', 'stock','min_quantity','max_quantity',
     'reorder_level','company_id','created_by','is_delete'];
    public function item()
    {
        return $this->belongsTo(ItemsModel::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(WarehouseModel::class);
    }

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
