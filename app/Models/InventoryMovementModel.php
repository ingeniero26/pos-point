<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovementModel extends Model
{
    use HasFactory;

    protected $table = 'item_movements';
    
    protected $fillable = [
        'inventory_id',
        'movement_type',
        'quantity',
        'previous_stock',
        'new_stock',
        'reason',
        'reference_id',
        'reference_type',
        'user_id',
        'company_id',
        'is_delete'
    ];

    // Relationships
    public function inventory()
    {
        return $this->belongsTo(InventoryModel::class, 'inventory_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}