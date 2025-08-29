<?php

namespace App\Models;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class InvoiceGroup extends Model
{
    //
    protected $table = 'invoice_groups';
    protected $fillable = ['dian_code', 'name'];

    // relacion con companies
    public function company()
    {
        return $this->belongsTo(Companies::class);
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
