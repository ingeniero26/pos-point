<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentsSales extends Model
{
    //
    protected $table = 'payments_sales';
 // relacion con lacuenta por cobrar
     public function account_receivable(){
        return $this->belongsTo(AccountsReceivable::class);
     }

     //  relacion con metodo de pago
     public function payment_method(){  
        return $this->belongsTo(PaymentMethodModel::class, 'payment_method_id');
     }
     // relacion con usuario
     public function user(){
        return $this->belongsTo(User::class,'created_by');
     }

     // relaion con la empresa
     public function company(){
        return $this->belongsTo(Companies::class,'company_id');
     }
     
}
