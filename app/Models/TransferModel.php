<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferModel extends Model
{
    //
    protected $table ='transfer';
    protected $fillable = ['from_warehouse_id', 'to_warehouse_id', 'created_at', 'updated_at'];
   
    public function item()
    {
        return $this->belongsTo(ItemsModel::class);
    }

    public function warehouse() {
        return $this->belongsTo(WarehouseModel::class,'from_warehouse_id');
    }
    public function warehouse_destination()
    {
        return $this->belongsTo(WarehouseModel::class, 'to_warehouse_id');
    }

    public function statusTransfer()
    {
        return $this->belongsTo(StatusTransferModel::class, 'status_transfer_id');
    }

    public function details()
    {
        return $this->hasMany(DetailTransferModel::class, 'transfer_id');
    }



}
