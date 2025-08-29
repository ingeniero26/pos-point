<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeTax extends Model
{
    //
    protected $table ='tax_types';

    // RELACIONES
     public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
