<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountsReceivable extends Model
{
    //
    protected $table = 'accounts_receivable';
    //relacion con sales
    public function sales()
    {
        return $this->belongsTo(Invoices::class, 'sale_id');
    }
    //relacion con tipo de comprobante
    public function voucherTypes()
    {
        return $this->belongsTo(VoucherTypeModel::class, 'voucher_type_id');
    }
    //relacion con estado de factura
    public function stateTypes()
    {
        return $this->belongsTo(StateTypeModel::class,'state_type_id');
    }
    //relacion con cliente
    public function customers()
    {
        return $this->belongsTo(PersonModel::class,'customer_id');
    }
    // relacion con usuario
    public function users()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    // relacion con estado de lacuenta
    public function accountStates()
    {
        return $this->belongsTo(AccountStates::class,'account_statuses_id');
    }

    public function currency()
    {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }
    public function company(){
        return $this->belongsTo(Companies::class,'company_id');
    }

    // relacion con pagos
    public function payments()
    {
        return $this->hasMany(PaymentsSales::class, 'account_receivable_id')
                    ->where('is_delete', 0);
    }

     // relacion con pagos
     public function paymentsDetails()
     {
         return $this->hasMany(PaymentsSales::class, 'account_receivable_id')
                     ->where('is_delete', 0);
     }

    // Calcular el total pagado
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('payment_amount');
    }

    // Calcular el balance pendiente
    public function getBalanceAttribute()
    {
        return $this->total_amount - $this->total_paid;
    }

    // Verificar si está completamente pagado
    public function getIsPaidAttribute()
    {
        return $this->balance <= 0;
    }

    // Verificar si tiene pagos parciales
    public function getIsPartialAttribute()
    {
        return $this->total_paid > 0 && $this->balance > 0;
    }

    // Obtener el estado calculado basado en pagos
    public function getCalculatedStatusAttribute()
    {
        if ($this->is_paid) {
            return 'Pagado';
        } elseif ($this->is_partial) {
            return 'Parcial';
        } else {
            return 'Pendiente';
        }
    }

   
   
}
