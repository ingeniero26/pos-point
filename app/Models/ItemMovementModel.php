<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMovementModel extends Model
{
    use HasFactory;

    protected $table = 'item_movements';
    protected $fillable = [
        'item_id',
        'warehouse_id',
        'movement_type_id',
        'movement_date',
        'quantity',
        'previous_stock',
        'new_stock',
        'reason',
        'reference_id',
        'reference_type',
        'created_by',
        'company_id',
        'stock'
    ];
 

    // Relationships
    public function item()
    {
        return $this->belongsTo(ItemsModel::class, 'item_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(WarehouseModel::class, 'warehouse_id');
    }
    // tipo movimiento
    public function movementType()
    {
        return $this->belongsTo(TypeMovementItems::class, 'movement_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}