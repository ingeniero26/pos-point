<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    //
    protected $table = 'quotation_items';
    // relacion con quotation
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }
    // relacion con items
    public function item()
    {
        return $this->belongsTo(ItemsModel::class, 'item_id');
    }
     //relacion con empresa
     public function company()
     {
         return $this->belongsTo(Companies::class, 'company_id');
     }
     // relacion con unidad
     public function unit()
     {
         return $this->belongsTo(MeasureModel::class, 'unit_type_id');
     }
     // impuestos
     public function taxes(){
        return $this->belongsToMany(TaxesModel::class,'tax_id');
     }
     
}
