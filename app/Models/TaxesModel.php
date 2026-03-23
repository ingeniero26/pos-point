<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxesModel extends Model
{
    //
    protected $table = 'taxes';
    protected $fillable = [
        'tax_name',
        'effective_date',
        'end_date',
        'rate',
        'tax_type_id',
        'description',
        'legal_basis',
        'company_id',
        'created_by',
    ];

    public  function taxesType()
    { 
         return $this->belongsTo(TypeTax::class, 'tax_type_id');

    }
    public function items()
    {
        return $this->belongsToMany(ItemsModel::class, 'item_taxes', 'tax_id', 'item_id');
    }
}
