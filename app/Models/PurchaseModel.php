<?php

namespace App\Models;

use Faker\Provider\ar_EG\Person;
use Illuminate\Database\Eloquent\Model;

class PurchaseModel extends Model
{
    //
    protected $table = 'purchases';
// relacion con proveedores (personas)
    public function suppliers()
    {
        return $this->belongsTo(PersonModel::class,'supplier_id');
    }
    // tipo documento electronico
    public function voucher_type()
    {
        return $this->belongsTo(VoucherTypeModel::class, 'voucher_type_id');
    }
    // estado de la factura
    public function state_type()
    {
        return $this->belongsTo(StateTypeModel::class,'state_type_id');
    }
   // formas de pago
    public function payment_types()
    {
        return $this->belongsTo(PaymentTypeModel::class,'payment_form_id');
    }
    // moneda
    public function currencies()
    {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }
    // metodo de pago
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethodModel::class, 'payment_method_id');
    }

    // bodegas
    public function warehouses()
    {
        return $this->belongsTo(WarehouseModel::class, 'warehouse_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class,'company_id');
    }
    // usuario que crea la compra
    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // relacion con cuentas por pagar
    public function accounts_payable()
    {
        return $this->hasOne(AccountsPayableModel::class, 'purchase_id');
    }

    // relacion con purchase details
    public function purchase_items()
    {
        return $this->hasMany(PurchaseItemsModel::class, 'purchase_id');
    }

    public function cashMovements()
{
    return $this->morphMany(CashMovement::class, 'reference');
}

}
