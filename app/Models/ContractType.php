<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    //
    protected $table = 'contract_types';

    protected $fillable = ['code', 'name',  'created_by','company_id' ];

    public function company(){
        return $this->belongsTo(Companies::class,'company_id');
    }
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }
}
