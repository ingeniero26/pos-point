<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Companies;
use App\Models\User;

class AdjustmentType extends Model
{
    //
    protected $table = 'adjustment_types';
    protected $fillable = [
        'type_name',
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
