<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resolution extends Model
{
    use HasFactory;

    protected $table = 'resolutions';

    protected $fillable = [
        'company_id',
        'resolution_number',
        'resolution_date',
        'technical_key',
        'from_number',
        'to_number',
        'prefix',
        'valid_from',
        'valid_to',
        'document_type',
        'status'
    ];

    protected $casts = [
        'resolution_date' => 'date',
        'valid_from' => 'date',
        'valid_to' => 'date',
        'from_number' => 'integer',
        'to_number' => 'integer'
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function notes()
    {
        return $this->hasMany(Notes::class, 'resolution_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('valid_from', '<=', now())
                    ->where('valid_to', '>=', now());
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Methods
    public function isActive()
    {
        return $this->status === 'active' && 
               $this->valid_from <= now() && 
               $this->valid_to >= now();
    }

    public function getNextAvailableNumber()
    {
        $lastUsedNumber = $this->notes()
            ->where('note_number', 'like', $this->prefix . '%')
            ->orderBy('note_number', 'desc')
            ->first();

        if ($lastUsedNumber) {
            $lastNumber = (int) substr($lastUsedNumber->note_number, strlen($this->prefix));
            return $lastNumber + 1;
        }

        return $this->from_number;
    }

    public function hasAvailableNumbers()
    {
        return $this->getNextAvailableNumber() <= $this->to_number;
    }
}