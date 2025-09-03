<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoices;

class InvoiceItems extends Model
{
    protected $table = 'invoices_items';
    
    // Add the relationship to the Items model
    public function item()
    {
        return $this->belongsTo(ItemsModel::class, 'item_id');
    }
    
    // Relationship to the Sales model
    public function sale()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id');
    }
    
    // Relationship to the Tax model if you have one
    public function tax()
    {
        return $this->belongsTo(TaxesModel::class, 'tax_id');
    }
}
