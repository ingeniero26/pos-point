<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TmpPurchaseModel extends Model
{
    //
    protected $table = 'tmp_purchases';
    // relacion con items
    public function items()
    {
        return $this->belongsTo(ItemsModel::class, 'item_id');
    }
}
