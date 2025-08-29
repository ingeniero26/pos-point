<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesItems extends Model
{
    protected $table = 'sales_items';
    
    // Add the relationship to the Items model
    public function item()
    {
        return $this->belongsTo(ItemsModel::class, 'item_id');
    }
    
    // Relationship to the Sales model
    public function sale()
    {
        return $this->belongsTo(Sales::class, 'sale_id');
    }
    
    // Relationship to the Tax model if you have one
    public function tax()
    {
        return $this->belongsTo(TaxesModel::class, 'tax_id');
    }
}
