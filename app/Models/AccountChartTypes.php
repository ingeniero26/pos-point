<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountChartTypes extends Model
{
    //
    protected $table = 'account_chart_types';
//     CREATE TABLE IF NOT EXISTS `account_chart_types` (
//   `id` int(11) NOT NULL AUTO_INCREMENT,
//   `type_code` varchar(20) NOT NULL COMMENT 'Código del tipo de cuenta (1, 2, 3, 4, 5 del PUC)',
//   `type_name` varchar(100) NOT NULL COMMENT 'Nombre del tipo (Activo, Pasivo, etc)',
//   `type_description` text COMMENT 'Descripción detallada del tipo',
//   `normal_balance` enum('D','C') NOT NULL COMMENT 'Saldo normal: D=Débito, C=Crédito',
//   `parent_type_id` int(11) DEFAULT NULL COMMENT 'FK para jerarquía de tipos (clase padre)',
//   `balance_sheet_section` varchar(50) DEFAULT NULL COMMENT 'Sección en balance (Activo Circulante, etc)',
//   `income_statement_section` varchar(50) DEFAULT NULL COMMENT 'Sección en estado resultados (Operacional, etc)',
//   `statement_type` enum('balance_sheet','income_statement','both','none') DEFAULT 'both' COMMENT 'Dónde aparece la cuenta',
//   `level` int(11) DEFAULT 1 COMMENT 'Nivel en la jerarquía (1=clase, 2=grupo, 3=subgrupo)',
//   `is_movement` tinyint(1) DEFAULT 1 COMMENT '1=Permite movimientos, 0=Solo totalizador',
//   `requires_detail` tinyint(1) DEFAULT 0 COMMENT '1=Requiere detalles/terceros',
//   `sort_order` int(11) DEFAULT 0 COMMENT 'Orden de visualización',
//   `status` tinyint(1) DEFAULT 1 COMMENT '1=Activo, 0=Inactivo',
//   `company_id` int(11) DEFAULT NULL COMMENT 'FK a companies (NULL=estándar, multiempresa)',
//   `created_by` int(11) DEFAULT NULL,
//   `is_delete` tinyint(1) DEFAULT 0,
//   `created_at` timestamp NULL DEFAULT current_timestamp(),
//   `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//   PRIMARY KEY (`id`) USING BTREE,
//   UNIQUE KEY `unique_type_code_company` (`type_code`, `company_id`),
//   KEY `idx_parent_type` (`parent_type_id`),
//   KEY `idx_company` (`company_id`),
//   KEY `idx_status` (`status`),
//   KEY `idx_statement_type` (`statement_type`),
//   KEY `idx_level` (`level`),
//   CONSTRAINT `fk_parent_type` FOREIGN KEY (`parent_type_id`) REFERENCES `account_chart_types` (`id`) ON DELETE SET NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de Cuentas Contables - Clasificación según PUC colombiano';

    protected $fillable = [
        'type_code',
        'type_name',
        'type_description',
        'normal_balance',
        'parent_type_id',
        'balance_sheet_section',
        'income_statement_section',
        'statement_type',
        'level',
        'is_movement',
        'requires_detail',
        'sort_order',
        'status',
        'company_id',
        'created_by',
        'is_delete'
    ];

    public function parentType()
    {
        return $this->belongsTo(AccountChartTypes::class, 'parent_type_id');
    }

    public function childTypes()
    {
        return $this->hasMany(AccountChartTypes::class, 'parent_type_id');
    }
    public function Company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
