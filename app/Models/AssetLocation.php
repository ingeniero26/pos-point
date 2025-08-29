<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetLocation extends Model
{
    //
    protected $table = 'asset_locations';
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
}
