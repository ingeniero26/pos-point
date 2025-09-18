<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactTypes extends Model
{
    //
    protected $table = 'contact_types';
    protected $fillable = ['name', 'description', 'colour','created_by','company_id' ];

    public function company(){
        return $this->belongsTo(Companies::class,'company_id');
    }
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }
}
