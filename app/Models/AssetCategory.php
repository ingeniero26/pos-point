<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    //
    protected $table = 'asset_categories';
    protected $fillable = [
        'name',
        'description',
    ];
    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
