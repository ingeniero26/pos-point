<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransferModel extends Model
{
    //
    protected $table ='transfer_detail';
    protected $fillable = ['transfer_id', 'item_id', 'quantity'];

    public function transfer()
    {
        return $this->belongsTo(TransferModel::class);
    }
    public function item()
    {
        return $this->belongsTo(ItemsModel::class, 'item_id');
    }

}
