<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentificationTypeModel extends Model
{
    //
    protected $table = 'identification_types';

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
