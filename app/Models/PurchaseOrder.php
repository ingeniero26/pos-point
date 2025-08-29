<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    //
    protected $table = 'purchase_orders';
    // relacion con proveedores
    public function suppliers(){
        return $this->belongsTo(PersonModel::class,'supplier_id');
    }
    // sttus order
    public function status_order()
    {
        return $this->belongsTo(StatusOrder::class, 'status_order_id');
    }
    //  relacion con bodegas
    public function warehouses()
    {
        return $this->belongsTo(WarehouseModel::class,'warehouse_id');
    }
    // relacion con taxes
    
    public function company()
    {
        return $this->belongsTo(Companies::class,'company_id');
    }
    // usuario que crea la compra
    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // moneda
    public function currencies()
    {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }
    public function purchase_order_items()
{
    return $this->hasMany(PurchaseOrderItemModel::class, 'purchase_order_id');
}

}
