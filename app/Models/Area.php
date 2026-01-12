<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    //
    use HasFactory;
    protected $table = 'areas';
//     CREATE TABLE IF NOT EXISTS `areas` (
//   `id` int(11) NOT NULL AUTO_INCREMENT,
//   `name` varchar(255) NOT NULL,
//   `description` text DEFAULT NULL,
//   `parent_id` int(11) DEFAULT NULL,
//   `manager_id` int(11) DEFAULT NULL,
//   `cost_center_id` int(11) DEFAULT NULL,
//   `company_id` int(11) DEFAULT NULL,
//   `created_by` int(11) DEFAULT NULL,
//   `status` tinyint(1) DEFAULT 1,
//   `is_delete` tinyint(1) DEFAULT 0,
//   `created_at` timestamp NULL DEFAULT current_timestamp(),
//   `updated_at` timestamp NULL DEFAULT current_timestamp(),
//   PRIMARY KEY (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

protected $fillable = [
        'name',
        'description',
        'parent_id',
        'manager_id',
        'cost_center_id',
        'company_id',
        'created_by',
        'status',
    ];

      protected $casts = [
        'status' => 'boolean',
        'is_delete' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => true,
        'is_delete' => false,
    ];

      public function parent()
    {
        return $this->belongsTo(Area::class, 'parent_id');
    }

     public function children()
    {
        return $this->hasMany(Area::class, 'parent_id')->where('is_delete', 0);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // relacion con la tabla empresas
    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    // relacion con la tabla usuarios
    public function creatorUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    // relacion centro de costos
    public function costCenter()
    {
        return $this->belongsTo(CostCenterModel::class, 'cost_center_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->where('is_delete', 0);
    }

     public function scopeNotDeleted($query)
    {
        return $query->where('is_delete', 0);
    }

     public function scopeDeleted($query)
    {
        return $query->where('is_delete', 1);
    }

     public function descendants()
    {
        return $this->children()->with('descendants');
    }

     public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }

     public function delete()
    {
        $this->is_delete = true;
        return $this->save();
    }

     public function restore()
    {
        $this->is_delete = false;
        return $this->save();
    }

     public function trashed()
    {
        return $this->is_delete === true;
    }

    // public function getTotalEmployeesAttribute()
    // {
    //     // Suponiendo que tienes un modelo Employee relacionado
    //     return $this->hasMany(Employee::class, 'area_id')->count();
    // }

}
