<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSource extends Model
{
    //
    protected $table = 'contact_sources';
    protected $fillable = ['name', 'description','company_id','created_by'];

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
