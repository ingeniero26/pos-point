<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentsPurchasesModel extends Model
{
    //
    protected $table = 'payments_purchases';
    // relacion con tabla cuentas por  pagar
    public function accountsPayable()
    {
        return $this->belongsTo(AccountsPayableModel::class, 'account_payable_id');
    }

    // metodo de pago
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethodModel::class, 'payment_method_id');
    }
    // empresa
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
   

}
