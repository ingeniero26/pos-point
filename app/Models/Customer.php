<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'company_id',
        'name',
        'document_type',
        'document_number',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'tax_regime',
        'tax_responsibilities',
        'status'
    ];

    protected $casts = [
        'tax_responsibilities' => 'array',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function notes()
    {
        return $this->hasMany(Notes::class, 'customer_id');
    }

    public function sales()
    {
        return $this->hasMany(Sales::class, 'customer_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByDocumentType($query, $documentType)
    {
        return $query->where('document_type', $documentType);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getFormattedDocumentAttribute()
    {
        return $this->document_type . ': ' . $this->document_number;
    }

    // Methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function getContactInfo()
    {
        return [
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code
        ];
    }
}