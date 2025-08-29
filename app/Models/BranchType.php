<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchType extends Model
{
    //
    protected $table = 'branch_type';

    // relacion
     public function company()
    {
        return $this->belongsTo(Companies::class);
    }
    public function branches()
    {
        return $this->hasMany(Branch::class, 'branch_type_id');
    }

    
}
