<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostCenterModel extends Model
{
    //
    protected $table = 'cost_centers';
    protected $fillable = [
        'code',
        'name',
        'description',
        'budget',
        'created_by',
        'company_id',
        'is_delete'
    ];

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
