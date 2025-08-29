<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotesConcept extends Model
{
    use HasFactory;

    protected $table = 'note_concepts';
    
    protected $fillable = [
        'code', 
        'name', 
        'description', 
        'note_type',
        'prefix',
        'status'
    ];

    protected $attributes = [
        'status' => 'active'
    ];

    // Relationships
    public function notes()
    {
        return $this->hasMany(Notes::class, 'note_type_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCreditNotes($query)
    {
        return $query->where('note_type', 'credit');
    }

    public function scopeDebitNotes($query)
    {
        return $query->where('note_type', 'debit');
    }

    // Accessors
    public function getTypeLabel()
    {
        return $this->note_type === 'credit' ? 'Nota de Crédito' : 'Nota de Débito';
    }

    // Methods
    public function isCredit()
    {
        return $this->note_type === 'credit';
    }

    public function isDebit()
    {
        return $this->note_type === 'debit';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
