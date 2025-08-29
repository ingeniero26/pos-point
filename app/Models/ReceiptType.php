<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptType extends Model
{
    protected $table = 'receipt_types';
    protected $fillable = ['code', 'name', 'prefix', 'status', 'company_id', 'created_by'];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function accountingMovements()
    {
        return $this->hasMany(AccountingMovement::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
