<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArlProvider extends Model
{
    //
    protected $table = 'arl_providers';
//     CREATE TABLE `arl_providers` (
// 	`id` INT(11) NOT NULL AUTO_INCREMENT,
// 	`code` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
// 	`name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
// 	`nit` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
// 	`phone` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
// 	`email` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
// 	`address` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
// 	`risk_class` INT(11) NULL DEFAULT NULL COMMENT 'Clase de riesgo 1-5',
// 	`status` TINYINT(1) NULL DEFAULT '1',
// 	`is_delete` TINYINT(1) NULL DEFAULT '0',
// 	`company_id` INT(11) NULL DEFAULT NULL,
// 	`created_by` INT(11) NULL DEFAULT NULL,
// 	`created_at` TIMESTAMP NULL DEFAULT current_timestamp(),
// 	`updated_at` TIMESTAMP NULL DEFAULT current_timestamp(),
// 	PRIMARY KEY (`id`) USING BTREE,
// 	UNIQUE INDEX `code` (`code`) USING BTREE
// )
// COLLATE='utf8mb4_unicode_ci'
// ENGINE=InnoDB
// ;
    protected $fillable = ['code', 'name', 'nit', 'phone', 'email', 'address', 'risk_class', 'company_id', 'created_by'];

    // relacion con la tabla empresas
    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    // relacion con la tabla usuarios
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
