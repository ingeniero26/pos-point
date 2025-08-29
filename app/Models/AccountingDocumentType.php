<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingDocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_automatic',
        'company_id',
        'created_by',
        'is_active',
        'is_delete'
    ];

    // Relationships

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}