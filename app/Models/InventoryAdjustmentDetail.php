<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WarehouseModel;
use App\Models\AdjustmentType;
use App\Models\AdjustmentReason;
use App\Models\ItemsModel;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;


class InventoryAdjustmentDetail extends Model
{
    //
    protected $table = 'adjustment_details';

    protected $fillable = [
        'inventory_adjustment_id',
        'item_id',
        'system_quantity',
        'physical_quantity',
        'unit_cost',
        'batch',
        'expiration_date',
        'comments',
        'created_by',
        'company_id',
    ];

    protected $casts = [
        'system_quantity' => 'integer',
        'physical_quantity' => 'integer',
        'unit_cost' => 'decimal:4',
        'total_cost' => 'decimal:2',
        'difference' => 'integer',
        'expiration_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function getDifferenceAttribute()
    {
        return $this->physical_quantity - $this->system_quantity;
    }

    // Accessor para el campo virtual 'total_cost'
    public function getTotalCostAttribute()
    {
        return abs($this->physical_quantity - $this->system_quantity) * $this->unit_cost;
    }

    /**
     * Relación con el ajuste de inventario principal
     */
    public function inventoryAdjustment()
    {
        return $this->belongsTo(InventoryAdjustment::class, 'inventory_adjustment_id');
    }

    /**
     * Relación con el item/producto
     */
    public function item()
    {
        return $this->belongsTo(ItemsModel::class, 'item_id');
    }

    /**
     * Relación con el usuario que creó el registro
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con la compañía
     */
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

}
