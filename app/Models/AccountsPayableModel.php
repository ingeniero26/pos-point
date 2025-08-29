<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountsPayableModel extends Model
{
    //
    protected $table = 'accounts_payable';
    public function payments()
    {
        return $this->hasMany(PaymentsPurchasesModel::class, 'account_payable_id');
    }

    // relacion con purchases
    public function purchases()
    {
        return $this->belongsTo(PurchaseModel::class, 'purchase_id');
    }
    // relacion con proveedores
    public function suppliers()
    {
        return $this->belongsTo(PersonModel::class, 'supplier_id');
    }
    // tipo comprobante
    public function type_document()
    {
        return $this->belongsTo(VoucherTypeModel::class, 'voucher_type_id');
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
    // estado de pago
    public function account_states() { 
        return $this->belongsTo(AccountStates::class, 'account_statuses_id');
    }
    // relacion monedas
    public function currency()
    {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }

    // relacion empresa
   


     // relacion con pagos
     public function payments_purchases()
     {
         return $this->hasMany(PaymentsPurchasesModel::class, 'accounts_payable_id');
     }

}
