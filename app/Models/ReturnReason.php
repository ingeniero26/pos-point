<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnReason extends Model
{
    //
    protected $table ='return_reasons';

    // relacion con user
    public function createdBy() {
       return $this->belongsTo(User::class, 'created_by');
    }

    public function company() {
        return $this->belongsTo(Companies::class,'company_id');
    }
}
