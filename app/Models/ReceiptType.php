<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptType extends Model
{
    protected $table = 'receipt_types';
    protected $fillable = [
        'code',
        'name',
        'prefix',
        'current_sequential',
        'modify_third_parties',
        'modify_inventories',
        'status',
        'company_id',
        'created_by'
    ];

     protected $casts = [
        'current_sequential' => 'integer',
        'modify_third_parties' => 'boolean',
        'modify_inventories' => 'boolean',
        'status' => 'boolean',
        'company_id' => 'integer',
        'created_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
     protected $hidden = [];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Companies::class);
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
        return $query->where('status', 1);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

   public function getNextSequential()
    {
        $this->increment('current_sequential');
        return $this->current_sequential;
    }

    public function generateReceiptNumber($sequential = null)
    {
        $seq = $sequential ?? $this->current_sequential;
        return $this->prefix . str_pad($seq, 6, '0', STR_PAD_LEFT);
    }
    public function modifiesThirdParties()
    {
        return $this->modify_third_parties;
    }
    public function modifiesInventories()
    {
        return $this->modify_inventories;
    }

    public function isActive()
    {
        return $this->status;
    }
}
