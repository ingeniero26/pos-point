<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //
    protected $table = 'positions';
//     -- Cargos/Posiciones
// CREATE TABLE IF NOT EXISTS `positions` (
//   `id` int(11) NOT NULL AUTO_INCREMENT,
//   `name` varchar(255) NOT NULL,
//   `description` text DEFAULT NULL,
//   `department_id` int(11) DEFAULT NULL,
//   `level` int(11) DEFAULT NULL,
//   `min_salary` decimal(15,2) DEFAULT NULL,
//   `max_salary` decimal(15,2) DEFAULT NULL,
//   `requirements` text DEFAULT NULL,
//   `responsibilities` text DEFAULT NULL,
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
        'area_id',
        'level',
        'min_salary',
        'max_salary',
        'requirements',
        'responsibilities',
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

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    // relacion empresa
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
    // relacion usuario creador
    public function creatorUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
