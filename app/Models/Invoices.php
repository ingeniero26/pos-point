<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    //
    protected $table = 'invoices';
    protected $fillable = [
        'voucher_type_id',
        'customer_id',
        'payment_form_id',
        'payment_method_id',
        'state_type_id',
        'currency_id',
        'warehouse_id',
        'date_of_issue',
        'date_of_due',
        'company_id',
        'created_by',
        'operation_type',
        'invoice_no',
        'total_sale',
        'total_tax',
        'total_discount',
    ];
    // relacion con  tipo comprobante
    public function voucherTypes()
    {
        return $this->belongsTo(VoucherTypeModel::class, 'voucher_type_id');
    }
    // estados factura
    public function stateTypes()
    {
        return $this->belongsTo(StateTypeModel::class, 'state_type_id');
    }
    // forma de pago
    public function paymentTypes()
    {
        return $this->belongsTo(PaymentTypeModel::class, 'payment_form_id');
    }
    // moneda
    public function currencies()
    {
        return $this->belongsTo(CurrenciesModel::class);
    }
    // cliente
    public function customers()
    {
        return $this->belongsTo(PersonModel::class, 'customer_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
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
    // forma de pago
    public function paymentForm() {
        return $this->belongsTo(PaymentTypeModel::class, 'payment_form_id');
    }
    // relacion con detalle de factura
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItems::class,'invoice_id');
    }


    // users
  
}
