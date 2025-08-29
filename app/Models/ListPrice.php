<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListPrice extends Model
{
    protected $table = 'list_prices';
    
    protected $fillable = [
        'name',
        'description',
        'type',
        'currency_id',
        'start_date',
        'end_date',
        'default',
        'status',
        'is_delete',
        'created_by',
        'company_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'default' => 'boolean',
        'status' => 'boolean',
        'is_delete' => 'boolean'
    ];

    public function currency()
    {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
