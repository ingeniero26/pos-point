<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeMovementCash extends Model
{
    protected $table = 'cash_movement_types';
    
    protected $fillable = [
        'name',
        'type',
        'description',
        'requires_third_party',
        'is_system_generated',
        'company_id',
        'created_by',
        'status',
        'is_delete'
    ];
    
    protected $casts = [
        'requires_third_party' => 'boolean',
        'is_system_generated' => 'boolean',
        'status' => 'boolean',
        'is_delete' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
