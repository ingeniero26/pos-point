-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         12.0.2-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para point_pos
CREATE DATABASE IF NOT EXISTS `point_pos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `point_pos`;

-- Volcando estructura para tabla point_pos.accounting_sources
CREATE TABLE IF NOT EXISTS `accounting_sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.accounting_sources: ~7 rows (aproximadamente)
INSERT INTO `accounting_sources` (`id`, `code`, `name`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(3, '10', 'Ajustes', 1, 0, 0, '2025-02-11 08:04:24', '2025-02-11 08:04:24'),
	(4, '1', 'VENTA POS', 1, 0, 0, '2025-02-11 19:33:12', '2025-02-11 19:33:12'),
	(5, '2', 'VENTAS', 1, 0, 0, '2025-02-11 19:33:34', '2025-02-11 19:33:34'),
	(6, '3', 'COMPRAS/MERCANCIA', 1, 0, 0, '2025-02-11 19:33:59', '2025-02-11 19:33:59'),
	(7, '4', 'COMPRAS/ACTIVOS', 1, 0, 0, '2025-02-11 19:34:22', '2025-02-11 19:34:22'),
	(8, '5', 'GASTOS', 1, 0, 0, '2025-02-11 19:34:53', '2025-02-11 19:34:53'),
	(9, '6', 'GASTOS/NOMINA', 1, 0, 0, '2025-02-11 19:37:53', '2025-02-11 19:37:53');

-- Volcando estructura para tabla point_pos.accounting_statuses
CREATE TABLE IF NOT EXISTS `accounting_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Nombre del estado contable',
  `description` varchar(255) DEFAULT NULL COMMENT 'Descripción del estado contable',
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Estados contables';

-- Volcando datos para la tabla point_pos.accounting_statuses: ~4 rows (aproximadamente)
INSERT INTO `accounting_statuses` (`id`, `name`, `description`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'pending', 'Estado Pendiente', NULL, 0, 0, '2025-03-03 16:32:20', '2025-03-03 16:32:22'),
	(2, 'registered', 'Registrado', NULL, 0, 0, '2025-03-03 16:32:38', '2025-03-03 16:32:39'),
	(3, 'canceled', 'registro cancelado', NULL, 0, 0, '2025-03-03 16:33:13', '2025-03-03 16:33:14'),
	(4, 'deleted', 'Eliminado', NULL, 0, 0, '2025-03-03 16:33:26', '2025-03-03 16:33:27');

-- Volcando estructura para tabla point_pos.accounts_payable
CREATE TABLE IF NOT EXISTS `accounts_payable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `voucher_type_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(500) DEFAULT NULL,
  `date_of_issue` date DEFAULT NULL,
  `date_of_due` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `account_statuses_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='cuentas por pagar';

-- Volcando datos para la tabla point_pos.accounts_payable: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.accounts_receivable
CREATE TABLE IF NOT EXISTS `accounts_receivable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `voucher_type_id` int(11) DEFAULT NULL,
  `date_of_issue` date DEFAULT NULL,
  `date_of_due` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `account_statuses_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.accounts_receivable: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.account_statuses
CREATE TABLE IF NOT EXISTS `account_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.account_statuses: ~5 rows (aproximadamente)
INSERT INTO `account_statuses` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Pendiente', 'Cuenta por cobrar pendiente de pago.', '2025-03-12 01:31:30', '2025-03-12 01:31:30'),
	(2, 'Parcialmente Pagado', 'Cuenta por cobrar con pagos parciales.', '2025-03-12 01:31:30', '2025-03-12 01:31:30'),
	(3, 'Pagado', 'Cuenta por cobrar completamente pagada.', '2025-03-12 01:31:30', '2025-03-12 01:31:30'),
	(4, 'Vencido', 'Cuenta por cobrar con fecha de vencimiento superada.', '2025-03-12 01:31:30', '2025-03-12 01:31:30'),
	(5, 'Anulado', 'Cuenta por cobrar anulada.', '2025-03-12 01:31:30', '2025-03-12 01:31:30');

-- Volcando estructura para tabla point_pos.account_types
CREATE TABLE IF NOT EXISTS `account_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.account_types: ~10 rows (aproximadamente)
INSERT INTO `account_types` (`id`, `account_type`, `created_by`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Cuenta corriente', 1, 0, '2025-02-28 23:19:49', '2025-02-28 23:19:50'),
	(2, 'Cuenta nómina', 1, 0, '2025-02-28 23:20:43', '2025-02-28 23:20:45'),
	(3, 'Cuenta ahorro', 1, 0, '2025-02-28 23:21:13', '2025-02-28 23:21:14'),
	(4, 'Cuenta online', 1, 0, '2025-02-28 23:21:38', '2025-02-28 23:21:39'),
	(5, 'Cuenta remunerada', 1, 0, '2025-02-28 23:21:58', '2025-02-28 23:22:00'),
	(6, 'Cuenta no nómina', 1, 0, '2025-02-28 23:22:49', '2025-02-28 23:22:50'),
	(7, ' Cuenta infantil', 1, 0, '2025-02-28 23:23:12', '2025-02-28 23:23:13'),
	(8, 'Cuenta joven', 1, 0, '2025-02-28 23:23:33', '2025-02-28 23:23:34'),
	(9, 'Cuenta mancomunada', 1, 0, '2025-02-28 23:23:50', '2025-02-28 23:23:51'),
	(10, 'Cuenta Nequi', 1, 0, '2025-05-27 20:54:33', '2025-05-27 20:54:33');

-- Volcando estructura para tabla point_pos.adjustment_details
CREATE TABLE IF NOT EXISTS `adjustment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_adjustment_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `system_quantity` int(11) NOT NULL,
  `physical_quantity` int(11) NOT NULL,
  `difference` int(11) GENERATED ALWAYS AS (`physical_quantity` - `system_quantity`) VIRTUAL,
  `unit_cost` decimal(10,4) NOT NULL,
  `total_cost` decimal(12,2) GENERATED ALWAYS AS (abs(`physical_quantity` - `system_quantity`) * `unit_cost`) VIRTUAL,
  `batch` varchar(50) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `item_index` (`item_id`),
  KEY `adjustment_index` (`inventory_adjustment_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='detalle del ajuste de inventario';

-- Volcando datos para la tabla point_pos.adjustment_details: ~9 rows (aproximadamente)
INSERT INTO `adjustment_details` (`id`, `inventory_adjustment_id`, `item_id`, `system_quantity`, `physical_quantity`, `unit_cost`, `batch`, `expiration_date`, `comments`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
	(14, 9, 21, 47, 37, 28000.0000, NULL, NULL, NULL, 1, 1, '2025-07-31 02:11:55', '2025-07-31 02:11:55'),
	(15, 9, 22, 40, 42, 35000.0000, NULL, NULL, NULL, 1, 1, '2025-07-31 02:11:55', '2025-07-31 02:11:55'),
	(16, 9, 23, 10, 13, 58000.0000, NULL, NULL, NULL, 1, 1, '2025-07-31 02:11:55', '2025-07-31 02:11:55'),
	(17, 9, 24, 5, 6, 182104.0000, NULL, NULL, NULL, 1, 1, '2025-07-31 02:11:55', '2025-07-31 02:11:55'),
	(18, 9, 72, 0, 1, 800.0000, NULL, NULL, NULL, 1, 1, '2025-07-31 02:11:55', '2025-07-31 02:11:55'),
	(19, 10, 21, 37, 47, 28000.0000, NULL, NULL, NULL, 1, 1, '2025-07-31 02:55:06', '2025-07-31 02:55:06'),
	(20, 10, 22, 42, 52, 35000.0000, NULL, NULL, NULL, 1, 1, '2025-07-31 02:55:06', '2025-07-31 02:55:06'),
	(21, 10, 44, 0, 10, 31000.0000, NULL, NULL, NULL, 1, 1, '2025-07-31 02:55:06', '2025-07-31 02:55:06'),
	(22, 10, 72, 0, 10, 800.0000, NULL, NULL, NULL, 1, 1, '2025-07-31 02:55:06', '2025-07-31 02:55:06');

-- Volcando estructura para tabla point_pos.adjustment_reason
CREATE TABLE IF NOT EXISTS `adjustment_reason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adjustment_type_id` int(11) NOT NULL,
  `reason_code` varchar(20) NOT NULL,
  `reason_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_type_code` (`adjustment_type_id`,`reason_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.adjustment_reason: ~4 rows (aproximadamente)
INSERT INTO `adjustment_reason` (`id`, `adjustment_type_id`, `reason_code`, `reason_name`, `description`, `created_by`, `company_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 1, '0001', 'Ajuste de pruebas', 'pruebas', 1, 1, 1, 0, '2025-07-28 16:45:11', '2025-07-28 16:45:12'),
	(2, 5, '002', 'Entrada de productos inventario', 'Ingreso de productos al inventario', 1, 1, 1, 0, '2025-07-28 21:56:05', '2025-07-28 21:56:05'),
	(3, 3, '003', 'Eliminar', 'Eliminar', 1, 1, 1, 1, '2025-07-28 22:03:19', '2025-07-28 22:03:27'),
	(4, 6, '003', 'Salida de productos', 'Ajuste salida de productos de iventario', 1, 1, 1, 0, '2025-07-29 01:42:19', '2025-07-29 01:42:19');

-- Volcando estructura para tabla point_pos.adjustment_types
CREATE TABLE IF NOT EXISTS `adjustment_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_code` varchar(20) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `affects_cost` tinyint(1) DEFAULT 0,
  `requires_approval` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `type_code` (`type_code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.adjustment_types: ~7 rows (aproximadamente)
INSERT INTO `adjustment_types` (`id`, `type_code`, `type_name`, `description`, `affects_cost`, `requires_approval`, `status`, `created_by`, `company_id`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'CONTEO', 'Ajuste por Conteo Físico', 'Ajuste resultado de inventario físico', 1, 1, 1, 1, 1, 0, '2025-07-28 16:03:20', '2025-07-28 16:03:21'),
	(2, 'MERMA', 'Ajuste por Merma', 'Pérdida de producto por deterioro, vencimiento', 1, 1, 1, 1, 1, 0, '2025-07-28 16:05:01', '2025-07-28 16:05:02'),
	(3, 'ROBO', 'Ajuste por Robo/Hurto', 'Pérdida de producto por robo o hurto', 1, 1, 1, 1, 1, 0, '2025-07-28 16:06:25', '2025-07-18 16:06:26'),
	(4, 'DAÑADO', 'Ajuste por daño', 'Daño del producto', 1, 1, 1, 1, 1, 0, '2025-07-28 16:07:33', '2025-07-28 16:07:35'),
	(5, 'ENTRADA', 'Ajuste por entrada ', 'Incremento en el stock del producto', 1, 1, 1, 1, 1, 0, '2025-07-28 16:08:23', '2025-07-28 16:08:25'),
	(6, 'SALIDA', 'Ajuste por salida de productos', 'Disminucion del inventario', 1, 1, 1, 1, 1, 0, '2025-07-28 16:09:16', '2025-07-28 16:09:19'),
	(7, 'CORRECION', 'Correccion de errores', 'Ajuste por error del inventario', 0, 0, 1, 1, 1, 0, '2025-07-28 16:10:26', '2025-07-28 16:10:27');

-- Volcando estructura para tabla point_pos.asset_categories
CREATE TABLE IF NOT EXISTS `asset_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `depreciation_method` enum('straight_line','declining_balance','units_of_production','sum_of_years','undefined') DEFAULT 'straight_line',
  `useful_life_years` int(11) DEFAULT 10,
  `depreciation_rate` decimal(5,2) DEFAULT 0.00,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.asset_categories: ~8 rows (aproximadamente)
INSERT INTO `asset_categories` (`id`, `name`, `description`, `depreciation_method`, `useful_life_years`, `depreciation_rate`, `company_id`, `created_by`, `updated_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Equipos de Cómputo', 'Computadoras, laptops, servidores', 'straight_line', 3, 33.33, 1, 1, NULL, 1, 0, '2025-07-11 01:14:45', '2025-07-11 01:22:11'),
	(2, 'Muebles y Enseres', 'Escritorios, sillas, archivadores', 'straight_line', 10, 10.00, 1, 1, NULL, 1, 0, '2025-07-11 01:14:45', '2025-07-11 01:22:14'),
	(3, 'Vehículos', 'Automóviles, camiones, motocicletas', 'straight_line', 5, 20.00, 1, 1, NULL, 1, 0, '2025-07-11 01:14:45', '2025-07-11 01:22:16'),
	(4, 'Maquinaria', 'Equipos industriales y de producción', 'straight_line', 10, 10.00, 1, 1, NULL, 1, 0, '2025-07-11 01:14:45', '2025-07-11 01:22:18'),
	(5, 'Equipos de Oficina', 'Impresoras, fotocopiadoras, teléfonos', 'straight_line', 5, 20.00, 1, 1, NULL, 1, 0, '2025-07-11 01:14:45', '2025-07-11 01:22:20'),
	(6, 'Inmuebles', 'Edificios, terrenos, construcciones', 'straight_line', 20, 5.00, 1, 1, NULL, 1, 0, '2025-07-11 01:14:45', '2025-07-11 01:22:23'),
	(7, 'Terrenos', 'Terrenos de la empresa Valorizados', 'undefined', 10, 5.00, NULL, NULL, 1, 1, 0, '2025-07-11 18:35:13', '2025-07-11 22:30:05'),
	(8, 'eliminame EDITANDO', 'Segundo Periodo Academico', 'straight_line', 20, 5.00, 1, 1, NULL, 1, 1, '2025-07-11 22:55:23', '2025-07-11 22:55:41');

-- Volcando estructura para tabla point_pos.asset_documents
CREATE TABLE IF NOT EXISTS `asset_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `document_type` enum('invoice','warranty','manual','photo','certificate','other') NOT NULL,
  `document_name` varchar(200) NOT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_asset_documents` (`asset_id`,`document_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.asset_documents: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.asset_locations
CREATE TABLE IF NOT EXISTS `asset_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `responsible_person` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.asset_locations: ~6 rows (aproximadamente)
INSERT INTO `asset_locations` (`id`, `name`, `description`, `address`, `responsible_person`, `company_id`, `created_by`, `updated_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Oficina Principal', 'Sede central de la empresa', 'BARRIO CENT4O', 'Juan Pérez', 1, 1, 1, 1, 0, '2025-07-11 01:14:57', '2025-07-12 01:26:26'),
	(2, 'Sucursal Norte', 'Oficina sucursal zona norte', NULL, 'María González', 1, 1, NULL, 1, 0, '2025-07-11 01:14:57', '2025-07-11 18:39:12'),
	(3, 'Almacén Central', 'Bodega principal', NULL, 'Carlos Rodríguez', 1, 1, NULL, 1, 0, '2025-07-11 01:14:57', '2025-07-11 18:39:15'),
	(4, 'Planta de Producción', 'Área de manufactura', NULL, 'Ana Martínez', 1, 1, NULL, 1, 0, '2025-07-11 01:14:57', '2025-07-11 18:39:19'),
	(5, 'Oficina Administrativa', 'Departamento administrativo', NULL, 'Luis Sánchez', 1, 1, NULL, 1, 0, '2025-07-11 01:14:57', '2025-07-11 18:39:22'),
	(6, 'PRINCIPAL', 'Ubicación general', 'El Carmen de Bolivar', 'Jerson Batista', NULL, NULL, NULL, 1, 0, '2025-07-12 00:07:19', '2025-07-12 00:07:19');

-- Volcando estructura para tabla point_pos.asset_maintenance
CREATE TABLE IF NOT EXISTS `asset_maintenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `maintenance_type` enum('preventive','corrective','emergency') NOT NULL,
  `description` text NOT NULL,
  `maintenance_date` date NOT NULL,
  `cost` decimal(10,2) DEFAULT 0.00,
  `performed_by` varchar(100) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `next_maintenance_date` date DEFAULT NULL,
  `status` enum('scheduled','in_progress','completed','cancelled') DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_asset_maintenance` (`asset_id`,`maintenance_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.asset_maintenance: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.asset_transfers
CREATE TABLE IF NOT EXISTS `asset_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `from_location_id` int(11) DEFAULT NULL,
  `to_location_id` int(11) NOT NULL,
  `from_employee` varchar(100) DEFAULT NULL,
  `to_employee` varchar(100) DEFAULT NULL,
  `transfer_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `status` enum('pending','approved','completed','cancelled') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_asset_transfer` (`asset_id`,`transfer_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.asset_transfers: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.banks
CREATE TABLE IF NOT EXISTS `banks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.banks: ~6 rows (aproximadamente)
INSERT INTO `banks` (`id`, `code`, `name`, `company_id`, `created_by`, `updated_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, '1', 'BANCOLOMBIA', 1, 1, NULL, 0, 0, '2025-04-06 22:15:39', '2025-02-10 00:30:44'),
	(2, '5', 'BANCO AV VILLAS', 1, 1, NULL, 0, 0, '2025-04-06 22:15:43', '2025-02-10 05:36:07'),
	(3, '4', 'BANCO AGRARIO', 1, 1, NULL, 0, 0, '2025-04-06 22:15:45', '2025-02-10 05:38:07'),
	(4, '25', 'testtestte editado', 1, 1, 1, 0, 1, '2025-04-06 22:15:48', '2025-02-10 05:54:57'),
	(5, '6', 'BANCO  BOGOTA', 1, 1, NULL, 0, 0, '2025-04-06 22:15:51', '2025-03-01 03:42:42'),
	(6, '7', 'BANCO DAVIVIENDA', 1, 1, NULL, 0, 0, '2025-04-06 22:15:57', '2025-03-01 03:43:03');

-- Volcando estructura para tabla point_pos.bank_accounts
CREATE TABLE IF NOT EXISTS `bank_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) DEFAULT NULL,
  `account_type_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT 0.00,
  `available_balance` decimal(15,2) DEFAULT 0.00,
  `reconciled_balance` decimal(15,2) DEFAULT 0.00,
  `last_reconciliation_date` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='cuentas bancarias';

-- Volcando datos para la tabla point_pos.bank_accounts: ~1 rows (aproximadamente)
INSERT INTO `bank_accounts` (`id`, `bank_id`, `account_type_id`, `currency_id`, `number`, `description`, `amount`, `available_balance`, `reconciled_balance`, `last_reconciliation_date`, `created_by`, `company_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(10, 1, 1, 170, '1203', 'Cuenta bancaria', 133320.00, 133320.00, 100000.00, '2025-05-28 17:36:00', 1, 1, 1, 0, '2025-05-28 17:36:00', '2025-05-28 17:57:01');

-- Volcando estructura para tabla point_pos.bank_movements
CREATE TABLE IF NOT EXISTS `bank_movements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_account_id` int(11) NOT NULL,
  `type` enum('INGRESO','EGRESO') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `movement_date` date DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_reconciled` tinyint(1) DEFAULT 0,
  `reconciliation_date` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `bank_account_id` (`bank_account_id`),
  CONSTRAINT `bank_movements_ibfk_1` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.bank_movements: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.branches
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.branches: ~1 rows (aproximadamente)
INSERT INTO `branches` (`id`, `name`, `address`, `email`, `phone`, `country_id`, `department_id`, `city_id`, `status`, `is_delete`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
	(1, 'CENTRAL', 'EL CARMEN', 'note@gmail.com', '3021455', 46, 1, 1, 1, 0, 1, 1, '2025-03-21 00:18:51', '2025-03-21 00:18:51');

-- Volcando estructura para tabla point_pos.brands
CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='marcas';

-- Volcando datos para la tabla point_pos.brands: ~28 rows (aproximadamente)
INSERT INTO `brands` (`id`, `brand_name`, `created_by`, `company_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'MARCA GENERAL', 1, 1, 0, '2024-12-06 19:33:41', '2025-05-29 20:58:04'),
	(4, 'samuray', 1, 1, 0, '2025-05-29 20:57:47', '2025-05-29 20:57:47'),
	(5, 'india', 1, 1, 0, '2025-05-29 20:58:17', '2025-05-29 20:58:17'),
	(6, 'vaniplas', 1, 1, 0, '2025-05-29 20:58:27', '2025-05-29 20:58:27'),
	(7, 'rimax', 1, 1, 0, '2025-05-29 20:58:40', '2025-05-29 20:58:40'),
	(8, 'imusa', 1, 1, 0, '2025-05-29 20:58:50', '2025-05-29 20:58:50'),
	(9, 'haceb', 1, 1, 0, '2025-05-29 20:58:59', '2025-05-29 20:58:59'),
	(10, 'corona', 1, 1, 0, '2025-05-29 20:59:50', '2025-05-29 20:59:50'),
	(11, 'universal', 1, 1, 0, '2025-05-29 21:00:01', '2025-05-29 21:00:01'),
	(12, 'hogar plas', 1, 1, 0, '2025-05-29 21:00:14', '2025-05-29 21:00:14'),
	(13, 'masso', 1, 1, 0, '2025-05-29 21:00:23', '2025-05-29 21:00:23'),
	(14, 'grulla', 1, 1, 0, '2025-05-29 21:00:32', '2025-05-29 21:00:32'),
	(15, 'venus', 1, 1, 0, '2025-05-29 21:00:48', '2025-05-29 21:00:48'),
	(16, 'oster', 1, 1, 0, '2025-05-29 21:00:57', '2025-05-29 21:00:57'),
	(17, 'ABBA', 1, 1, 0, '2025-05-29 21:01:13', '2025-05-29 21:01:13'),
	(18, 'lynx', 1, 1, 0, '2025-05-29 21:01:22', '2025-05-29 21:01:22'),
	(19, 'continental', 1, 1, 0, '2025-05-29 21:01:39', '2025-05-29 21:01:39'),
	(20, 'sueño flex', 1, 1, 0, '2025-05-29 21:02:04', '2025-05-29 21:02:04'),
	(21, 'relax', 1, 1, 0, '2025-05-29 21:02:20', '2025-05-29 21:02:20'),
	(22, 'serraty', 1, 1, 0, '2025-05-29 21:02:30', '2025-05-29 21:02:30'),
	(23, 'alteza', 1, 1, 0, '2025-05-29 21:02:40', '2025-05-29 21:02:40'),
	(24, 'home elements', 1, 1, 0, '2025-05-29 21:02:51', '2025-05-29 21:02:51'),
	(25, 'DKasa', 1, 1, 0, '2025-05-29 21:03:02', '2025-05-29 21:03:02'),
	(26, 'Colplas', 1, 1, 0, '2025-05-29 21:03:10', '2025-05-29 21:03:10'),
	(27, 'Sorplas', 1, 1, 0, '2025-05-29 21:03:19', '2025-05-29 21:03:19'),
	(28, 'Multimarcas', 1, 1, 0, '2025-05-29 21:03:29', '2025-05-29 21:03:29'),
	(29, 'KENDY', 1, 1, 0, '2025-05-29 21:03:39', '2025-05-29 21:03:39'),
	(30, 'VEREDA', 1, 1, 0, '2025-05-29 21:03:48', '2025-05-29 21:03:48');

-- Volcando estructura para tabla point_pos.business_types
CREATE TABLE IF NOT EXISTS `business_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='tipo empresa';

-- Volcando datos para la tabla point_pos.business_types: ~1 rows (aproximadamente)
INSERT INTO `business_types` (`id`, `name`, `slug`, `description`, `features`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Comercial', 'comercial', 'empresa de comercio', NULL, 1, 0, 1, '2025-08-13 23:56:03', '2025-08-13 23:56:05');

-- Volcando estructura para tabla point_pos.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.cache: ~9 rows (aproximadamente)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('brands_list', 'O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:28:{i:1;s:13:"MARCA GENERAL";i:4;s:7:"samuray";i:5;s:5:"india";i:6;s:8:"vaniplas";i:7;s:5:"rimax";i:8;s:5:"imusa";i:9;s:5:"haceb";i:10;s:6:"corona";i:11;s:9:"universal";i:12;s:10:"hogar plas";i:13;s:5:"masso";i:14;s:6:"grulla";i:15;s:5:"venus";i:16;s:5:"oster";i:17;s:4:"ABBA";i:18;s:4:"lynx";i:19;s:11:"continental";i:20;s:11:"sueño flex";i:21;s:5:"relax";i:22;s:7:"serraty";i:23;s:6:"alteza";i:24;s:13:"home elements";i:25;s:5:"DKasa";i:26;s:7:"Colplas";i:27;s:7:"Sorplas";i:28;s:11:"Multimarcas";i:29;s:5:"KENDY";i:30;s:6:"VEREDA";}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1765928035),
	('categories_list', 'O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:77:{i:1;s:7:"Estufas";i:2;s:12:"FERRETERIA 2";i:3;s:12:"ventiladores";i:7;s:20:"repuesto verntilador";i:8;s:6:"Sillas";i:9;s:8:"Chanclas";i:10;s:12:"herramientas";i:11;s:16:"repuesto estufas";i:12;s:18:"repuesto licuadora";i:13;s:17:"repuesto lavadora";i:14;s:9:"colchones";i:15;s:5:"camas";i:16;s:11:"colchonetas";i:17;s:9:"cacharros";i:18;s:15:"BOTA VENUS TELA";i:19;s:20:"BOTA PANTANERA VENUS";i:20;s:11:"BOTA GRULLA";i:21;s:20:"utensilios de cocina";i:22;s:18:"loza y cristaleria";i:23;s:10:"jugueteria";i:24;s:18:"morrales y maletas";i:25;s:6:"mallas";i:26;s:10:"licuadoras";i:27;s:7:"neveras";i:28;s:15:"OLLAS A PRESION";i:29;s:19:"molinos y repuestos";i:30;s:9:"cuchillos";i:31;s:17:"ollas de aluminio";i:32;s:12:"CAVAS ICOPOR";i:33;s:11:"tornilleria";i:34;s:6:"cables";i:35;s:7:"cuerdas";i:36;s:11:"televisores";i:37;s:18:"ponchera y tazones";i:38;s:17:"tanques plasticos";i:39;s:16:"baldes plasticos";i:40;s:7:"hamacas";i:41;s:16:"MESAS PLASTICAS ";i:42;s:18:"loza y cristaleria";i:43;s:13:"ASEO PERSONAL";i:44;s:24:"LOZEROS Y PORTACUBIERTOS";i:45;s:21:"BOTA PANTANERA VEREDA";i:46;s:20:"BOTA PANTANERA MACHA";i:47;s:20:"BOTA PANTANERA TITAN";i:48;s:20:"BOTA VENUS ESTAMPADA";i:49;s:19:"BOTA ANDINA DE DAMA";i:50;s:19:"BOTA VENUS DE NIÑO";i:51;s:11:"BOTA MAXTER";i:52;s:10:"BOTA ARGOS";i:53;s:15:"ZAPATO DE DAMA ";i:54;s:21:"ZAPATO COLEGIAL NIÑO";i:55;s:19:"GUAYOS Y ZAPATILLAS";i:56;s:30:"BOTA DE TRABAJO ARGOS Y WELLCO";i:57;s:16:"termos cafeteros";i:58;s:16:"PESOS Y BASCULAS";i:59;s:26:"NEVERAS Y TERMOS PLASTICOS";i:60;s:22:"CHANCLA SOLIMAR HOMBRE";i:61;s:20:"CHANCLA SOLIMAR DAMA";i:62;s:9:"LAVADORAS";i:63;s:16:"UTILES ESCOLARES";i:64;s:6:"VARIOS";i:65;s:17:"COBIJAS Y SABANAS";i:66;s:19:"ENVASES HERMETICOS ";i:67;s:16:"JARRAS PLASTICAS";i:68;s:21:"UTENCILIOS PARA BAÑO";i:69;s:18:"UTENSILIOS DE ASEO";i:70;s:7:"MACETAS";i:71;s:9:"CALDEROS ";i:72;s:18:"ELECTRODOMESTICOS ";i:73;s:8:"VARIOS 2";i:74;s:11:"FERRETERIA ";i:75;s:17:"repuesto estufa 2";i:76;s:28:"repuestos de olla  a presion";i:77;s:18:"herramienta manual";i:78;s:21:"herramienta electrica";i:79;s:8:"pinturas";i:80;s:10:"Tecnologia";}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1765928035),
	('currencies_list', 'O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:156:{i:8;s:12:"Lek Albanés";i:12;s:14:"Dinar Algerino";i:32;s:14:"Peso Argentino";i:36;s:18:"Dólar Australiano";i:44;s:16:"Dólar Bahameño";i:48;s:15:"Dinar Bahreiní";i:50;s:18:"Taka De Bangladesh";i:51;s:12:"Dram Armenio";i:52;s:18:"Dólar De Barbados";i:60;s:17:"Dólar Bermudeño";i:64;s:18:"Ngultrum De Bután";i:68;s:9:"Boliviano";i:72;s:16:"Pula De Botsuana";i:84;s:16:"Dólar De Belice";i:90;s:28:"Dólar De Las Islas Salomón";i:96;s:17:"Dólar De Brunéi";i:104;s:12:"Kyat Birmano";i:108;s:16:"Franco Burundés";i:116;s:14:"Riel Camboyano";i:124;s:17:"Dólar Canadiense";i:132;s:19:"Escudo Caboverdiano";i:136;s:14:"Dólar Caimano";i:144;s:18:"Rupia De Sri Lanka";i:152;s:12:"Peso Chileno";i:156;s:10:"Yuan Chino";i:170;s:15:"Peso Colombiano";i:174;s:16:"Franco Comoriano";i:188;s:20:"Colón Costarricense";i:191;s:11:"Kuna Croata";i:192;s:11:"Peso Cubano";i:203;s:12:"Koruna Checa";i:208;s:13:"Corona Danesa";i:214;s:15:"Peso Dominicano";i:230;s:12:"Birr Etíope";i:232;s:13:"Nakfa Eritreo";i:238;s:16:"Libra Malvinense";i:242;s:14:"Dólar Fiyiano";i:262;s:16:"Franco Yibutiano";i:270;s:15:"Dalasi Gambiano";i:292;s:18:"Libra De Gibraltar";i:320;s:20:"Quetzal Guatemalteco";i:324;s:15:"Franco Guineano";i:328;s:15:"Dólar Guyanés";i:332;s:15:"Gourde Haitiano";i:340;s:18:"Lempira Hondureño";i:344;s:19:"Dólar De Hong Kong";i:348;s:15:"Forint Húngaro";i:352;s:16:"Króna Islandesa";i:356;s:11:"Rupia India";i:360;s:16:"Rupiah Indonesia";i:364;s:11:"Rial Iraní";i:368;s:13:"Dinar Iraquí";i:376;s:23:"Nuevo Shéquel Israelí";i:388;s:16:"Dólar Jamaicano";i:392;s:12:"Yen Japonés";i:398;s:12:"Tenge Kazajo";i:400;s:13:"Dinar Jordano";i:404;s:15:"Chelín Keniata";i:408;s:14:"Won Norcoreano";i:410;s:14:"Won Surcoreano";i:414;s:14:"Dinar Kuwaití";i:417;s:12:"Som Kirguís";i:418;s:7:"Kip Lao";i:422;s:14:"Libra Libanesa";i:426;s:14:"Loti Lesotense";i:430;s:16:"Dólar Liberiano";i:434;s:11:"Dinar Libio";i:440;s:13:"Litas Lituano";i:446;s:15:"Pataca De Macao";i:454;s:14:"Kwacha Malauí";i:458;s:14:"Ringgit Malayo";i:462;s:15:"Rufiyaa Maldiva";i:478;s:17:"Ouguiya Mauritana";i:480;s:14:"Rupia Mauricia";i:484;s:13:"Peso Mexicano";i:496;s:14:"Tughrik Mongol";i:498;s:11:"Leu Moldavo";i:504;s:16:"Dirham Marroquí";i:512;s:11:"Rial Omaní";i:516;s:14:"Dólar Namibio";i:524;s:14:"Rupia Nepalesa";i:532;s:29:"Florín Antillano Neerlandés";i:533;s:16:"Florín Arubeño";i:548;s:15:"Vatu Vanuatense";i:554;s:19:"Dólar Neozelandés";i:558;s:22:"Córdoba Nicaragüense";i:566;s:15:"Naira Nigeriana";i:578;s:14:"Corona Noruega";i:586;s:16:"Rupia Pakistaní";i:590;s:16:"Balboa Panameña";i:598;s:27:"Kina De Papúa Nueva Guinea";i:600;s:18:"Guaraní Paraguayo";i:604;s:17:"Nuevo Sol Peruano";i:608;s:13:"Peso Filipino";i:634;s:12:"Rial Qatarí";i:643;s:10:"Rublo Ruso";i:646;s:15:"Franco Ruandés";i:654;s:21:"Libra De Santa Helena";i:678;s:32:"Dobra De Santo Tomé Y Príncipe";i:682;s:12:"Riyal Saudí";i:690;s:19:"Rupia De Seychelles";i:694;s:21:"Leone De Sierra Leona";i:702;s:18:"Dólar De Singapur";i:704;s:15:"Dong Vietnamita";i:706;s:15:"Chelín Somalí";i:710;s:16:"Rand Sudafricano";i:728;s:5:"Libra";i:748;s:15:"Lilangeni Suazi";i:752;s:12:"Corona Sueca";i:756;s:12:"Franco Suizo";i:760;s:11:"Libra Siria";i:764;s:15:"Baht Tailandés";i:776;s:15:"Pa\'anga Tongano";i:780;s:27:"Dólar De Trinidad Y Tobago";i:784;s:37:"Dirham De Los Emiratos Árabes Unidos";i:788;s:14:"Dinar Tunecino";i:800;s:16:"Chelín Ugandés";i:807;s:15:"Denar Macedonio";i:818;s:13:"Libra Egipcia";i:826;s:15:"Libra Esterlina";i:834;s:15:"Chelín Tanzano";i:840;s:21:"Dólar Estadounidense";i:858;s:13:"Peso Uruguayo";i:860;s:10:"Som Uzbeko";i:882;s:12:"Tala Samoana";i:886;s:12:"Rial Yemení";i:901;s:16:"Dólar Taiwanés";i:931;s:23:"Peso Cubano Convertible";i:934;s:15:"Manat Turcomano";i:936;s:12:"Cedi Ghanés";i:937;s:26:"Bolívar Fuerte Venezolano";i:938;s:14:"Dinar Sudanés";i:941;s:12:"Dinar Serbio";i:943;s:21:"Metical Mozambiqueño";i:944;s:17:"Manat Azerbaiyano";i:946;s:10:"Leu Rumano";i:949;s:10:"Lira Turca";i:950;s:29:"Franco Cfa De África Central";i:951;s:26:"Dólar Del Caribe Oriental";i:952;s:32:"Franco Cfa De África Occidental";i:953;s:10:"Franco Cfp";i:967;s:15:"Kwacha Zambiano";i:968;s:17:"Dólar Surinamés";i:969;s:15:"Ariary Malgache";i:971;s:13:"Afgani Afgano";i:972;s:12:"Somoni Tayik";i:973;s:16:"Kwanza Angoleño";i:974;s:16:"Rublo Bielorruso";i:975;s:12:"Lev Búlgaro";i:976;s:17:"Franco Congoleño";i:977;s:39:"Marco Convertible De Bosnia-Herzegovina";i:978;s:4:"Euro";i:980;s:16:"Grivna Ucraniana";i:981;s:14:"Lari Georgiano";i:985;s:12:"Zloty Polaco";i:986;s:15:"Real Brasileño";}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1765928035),
	('invoice_groups_list', 'O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:78:{i:1;s:23:"Equipos de Computación";i:2;s:18:"Motores y Turbinas";i:3;s:21:"Instrumentos Médicos";i:4;s:23:"Medicamentos Esenciales";i:5;s:33:"Productos Farmacéuticos Básicos";i:6;s:26:"Leche y Productos Lácteos";i:7;s:29:"Pan y Productos de Panadería";i:8;s:5:"Café";i:9;s:25:"Servicios de Consultoría";i:10;s:24:"Servicios de Ingeniería";i:11;s:25:"Servicios de Contabilidad";i:12;s:12:"Carne de Res";i:13;s:22:"Productos Veterinarios";i:14;s:7:"Cemento";i:15;s:24:"Acero para Construcción";i:16;s:8:"Gasolina";i:17;s:6:"Diesel";i:18;s:5:"Arroz";i:19;s:5:"Maíz";i:20;s:19:"Transporte de Carga";i:21;s:23:"Transporte de Pasajeros";i:22;s:14:"Ropa de Vestir";i:23;s:7:"Calzado";i:24;s:19:"Servicios Bancarios";i:25;s:7:"Seguros";i:26;s:21:"Productos de Limpieza";i:27;s:21:"Servicios de Internet";i:28;s:23:"Servicios de Telefonía";i:29;s:22:"Computadores y Laptops";i:30;s:34:"Teléfonos Celulares y Smartphones";i:31;s:31:"Tablets y Dispositivos Móviles";i:32;s:26:"Accesorios de Computación";i:33;s:23:"Televisores y Pantallas";i:34;s:24:"Refrigeradores y Neveras";i:35;s:21:"Lavadoras y Secadoras";i:36;s:16:"Estufas y Hornos";i:37;s:18:"Aire Acondicionado";i:38;s:12:"Ventiladores";i:39;s:15:"Muebles de Sala";i:40;s:18:"Muebles de Comedor";i:41;s:25:"Colchones y Bases de Cama";i:42;s:20:"Herramientas de Mano";i:43;s:24:"Herramientas Eléctricas";i:44;s:16:"Papel de Oficina";i:45;s:21:"Útiles de Escritorio";i:46;s:29:"Impresoras y Multifuncionales";i:47;s:19:"Material de Empaque";i:48;s:37:"Cemento y Materiales de Construcción";i:49;s:21:"Tubería y Accesorios";i:50;s:24:"Pintura y Recubrimientos";i:51;s:28:"Cables y Material Eléctrico";i:52;s:25:"Repuestos de Automóviles";i:53;s:21:"Llantas y Neumáticos";i:54;s:21:"Aceites y Lubricantes";i:55;s:23:"Baterías de Vehículos";i:56;s:26:"Productos de Aseo Personal";i:57;s:31:"Productos de Limpieza del Hogar";i:58;s:25:"Cosméticos y Perfumería";i:59;s:33:"Juguetes y Artículos para Niños";i:60;s:16:"Ropa para Hombre";i:61;s:15:"Ropa para Mujer";i:62;s:16:"Ropa para Niños";i:63;s:18:"Calzado en General";i:64;s:20:"Accesorios de Vestir";i:65;s:21:"Artículos Deportivos";i:66;s:20:"Equipos de Ejercicio";i:67;s:23:"Bicicletas y Accesorios";i:68;s:22:"Alimento para Mascotas";i:69;s:24:"Accesorios para Mascotas";i:70;s:28:"Libros y Material Didáctico";i:71;s:20:"Software y Licencias";i:72;s:18:"Semillas y Plantas";i:73;s:22:"Fertilizantes y Abonos";i:74;s:27:"Herramientas de Jardinería";i:75;s:32:"Servicio de Transporte y Entrega";i:76;s:24:"Servicio de Instalación";i:77;s:31:"Servicio Técnico y Reparación";i:78;s:25:"Servicio de Mantenimiento";}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1765928035),
	('items_type_list', 'O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:4:{i:1;s:21:"Producto Inventariado";i:2;s:9:"Servicios";i:3;s:12:"Auto Consumo";i:4;s:24:"Producto no Inventariado";}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1765928035),
	('measures_list', 'O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:6:{i:1;s:6:"UNIDAD";i:2;s:9:"KILOGRAMO";i:5;s:5:"Metro";i:6;s:9:"Miligramo";i:7;s:10:"Centimetro";i:8;s:5:"Libra";}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1765928035),
	('subcategories_list', 'O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:1:{i:1;s:34:"Ventiladores Samuray Mejor Calidad";}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1765928035),
	('taxes_list', 'O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:5:{i:1;s:7:"Ninguno";i:2;s:11:"Iva Excento";i:3;s:12:"Iva Excluido";i:4;s:7:"IVA(5%)";i:5;s:8:"Iva(19%)";}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1765928035),
	('warehouses_list', 'O:29:"Illuminate\\Support\\Collection":2:{s:8:"\0*\0items";a:3:{i:1;s:9:"Principal";i:7;s:8:"Bodega 2";i:8;s:9:"Eliminame";}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1765928035);

-- Volcando estructura para tabla point_pos.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.cache_locks: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.cash_movements
CREATE TABLE IF NOT EXISTS `cash_movements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cash_register_session_id` int(11) DEFAULT NULL COMMENT 'ID de la sesión de caja a la que pertenece el movimiento',
  `cash_movement_type_id` int(11) DEFAULT NULL COMMENT 'ID del tipo de movimiento de efectivo',
  `amount` decimal(15,2) DEFAULT NULL COMMENT 'Monto del movimiento (positivo para ingreso, negativo para egreso si no se usa el ENUM del tipo)',
  `description` varchar(500) DEFAULT NULL COMMENT 'Descripción detallada del movimiento',
  `reference_document_type` varchar(50) DEFAULT NULL COMMENT 'Tipo de documento de referencia (Ej: Factura, Comprobante Egreso, Nota)',
  `reference_document_number` varchar(100) DEFAULT NULL COMMENT 'Número del documento de referencia',
  `related_sale_id` int(11) DEFAULT NULL COMMENT 'ID de la venta asociada (si aplica)',
  `related_purchase_id` int(11) DEFAULT NULL COMMENT 'id compra asociada',
  `related_third_party_id` int(11) DEFAULT NULL COMMENT 'ID del tercero (cliente/proveedor, si aplica)',
  `third_party_document_type` varchar(200) DEFAULT NULL COMMENT 'Tipo de documento del tercero (CC, NIT)',
  `third_party_document_number` varchar(200) DEFAULT NULL COMMENT 'Número de documento del tercero',
  `third_party_name` varchar(255) DEFAULT NULL COMMENT 'Nombre del tercero',
  `transaction_time` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora exacta del movimiento',
  `user_id` int(11) NOT NULL COMMENT 'ID del usuario que registra el movimiento',
  `company_id` int(11) DEFAULT NULL COMMENT 'ID de la empresa',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Registro detallado de todos los movimientos de efectivo en caja';

-- Volcando datos para la tabla point_pos.cash_movements: ~11 rows (aproximadamente)
INSERT INTO `cash_movements` (`id`, `cash_register_session_id`, `cash_movement_type_id`, `amount`, `description`, `reference_document_type`, `reference_document_number`, `related_sale_id`, `related_purchase_id`, `related_third_party_id`, `third_party_document_type`, `third_party_document_number`, `third_party_name`, `transaction_time`, `user_id`, `company_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(19, 19, 1, 100000.00, 'Saldo inicial de apertura de caja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-30 22:23:15', 1, 1, 1, '2025-12-01 03:23:15', '2025-12-01 03:23:15'),
	(20, 19, 2, 54740.00, 'Venta #SETP990000020', 'SALE', 'SETP990000020', 27, NULL, 16, NULL, NULL, NULL, '2025-12-01 01:04:39', 1, 1, 1, '2025-12-01 06:04:39', '2025-12-01 06:04:39'),
	(21, 19, 8, -66640.00, 'Compra de productos', 'Compra', '53', NULL, 53, 11, NULL, NULL, NULL, '2025-12-01 01:09:37', 1, 1, 1, '2025-12-01 06:09:37', '2025-12-01 06:09:37'),
	(22, 19, 45, 50000.00, 'Cierre de caja - Saldo final', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-01 01:19:24', 1, 1, 1, '2025-12-01 06:19:24', '2025-12-01 06:19:24'),
	(23, 20, 1, 200000.00, 'Saldo inicial de apertura de caja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-01 01:42:13', 1, 1, 1, '2025-12-01 06:42:13', '2025-12-01 06:42:13'),
	(24, 20, 2, 50575.00, 'Venta #SETP990000021', 'SALE', 'SETP990000021', 28, NULL, 16, NULL, NULL, NULL, '2025-12-09 00:11:07', 1, 1, 1, '2025-12-09 05:11:07', '2025-12-09 05:11:07'),
	(25, 20, 8, -69020.00, 'Compra de productos', 'Compra', '54', NULL, 54, 12, NULL, NULL, NULL, '2025-12-09 01:14:13', 1, 1, 1, '2025-12-09 06:14:13', '2025-12-09 06:14:13'),
	(26, 20, 2, 285600.00, 'Venta #SETP990000022', 'SALE', 'SETP990000022', 29, NULL, 16, NULL, NULL, NULL, '2025-12-10 01:16:14', 1, 1, 1, '2025-12-10 06:16:14', '2025-12-10 06:16:14'),
	(27, 20, 2, 103530.00, 'Venta #SETP990000023', 'SALE', 'SETP990000023', 30, NULL, 16, NULL, NULL, NULL, '2025-12-12 01:06:21', 1, 1, 1, '2025-12-12 06:06:21', '2025-12-12 06:06:21'),
	(28, 20, 2, 285600.00, 'Venta #SETP990000024', 'SALE', 'SETP990000024', 31, NULL, 40, NULL, NULL, NULL, '2025-12-14 19:59:12', 1, 1, 1, '2025-12-15 00:59:12', '2025-12-15 00:59:12'),
	(29, 20, 2, 116620.00, 'Venta #SETP990000025', 'SALE', 'SETP990000025', 32, NULL, 40, NULL, NULL, NULL, '2025-12-14 20:08:55', 1, 1, 1, '2025-12-15 01:08:55', '2025-12-15 01:08:55');

-- Volcando estructura para tabla point_pos.cash_movement_types
CREATE TABLE IF NOT EXISTS `cash_movement_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Nombre del tipo de movimiento (Ej: Saldo Inicial, Ingreso por Venta, Pago Proveedor Efectivo, Depósito Bancario, Retiro de Caja, Ajuste por Faltante, Ajuste por Sobrante)',
  `type` enum('INGRESO','EGRESO') NOT NULL COMMENT 'Tipo de operación (INGRESO o EGRESO)',
  `description` text DEFAULT NULL,
  `requires_third_party` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si el movimiento requiere un tercero (cliente/proveedor)',
  `is_system_generated` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si es un tipo de movimiento generado automáticamente por el sistema (ej. Saldo Inicial)',
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tipos de movimientos de efectivo para la caja';

-- Volcando datos para la tabla point_pos.cash_movement_types: ~18 rows (aproximadamente)
INSERT INTO `cash_movement_types` (`id`, `name`, `type`, `description`, `requires_third_party`, `is_system_generated`, `company_id`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Saldo Inicial', 'INGRESO', 'Saldo inicial de caja al comenzar operaciones', 0, 1, 1, 1, 1, 0, '2025-05-26 15:56:59', '2025-05-27 02:20:59'),
	(2, 'Ingreso por Venta', 'INGRESO', 'Ingreso de efectivo por venta al contado', 1, 1, 1, 1, 1, 0, '2025-05-26 15:56:59', '2025-05-27 02:21:53'),
	(3, 'Depósito Bancario', 'INGRESO', 'Ingreso por depósito bancario realizado', 0, 1, 1, 1, 1, 0, '2025-05-26 15:56:59', '2025-05-27 02:21:59'),
	(4, 'Préstamo', 'INGRESO', 'Ingreso por préstamo recibido', 1, 1, 1, 1, 1, 0, '2025-05-26 15:56:59', '2025-05-27 02:22:03'),
	(5, 'Reembolso', 'INGRESO', 'Reembolso de gastos o anticipos', 1, 1, 1, 1, 1, 0, '2025-05-26 15:56:59', '2025-05-27 02:22:09'),
	(6, 'Ajuste por Sobrante', 'INGRESO', 'Ajuste contable por sobrante en caja', 0, 1, 1, 1, 1, 0, '2025-05-26 15:56:59', '2025-05-27 02:22:14'),
	(7, 'Otros Ingresos', 'INGRESO', 'Otros tipos de ingresos no especificados', 0, 1, 1, 1, 1, 0, '2025-05-26 15:56:59', '2025-05-27 13:42:43'),
	(8, 'Pago a Proveedor', 'EGRESO', 'Pago en efectivo a proveedor', 1, 1, 1, 1, 1, 0, '2025-05-26 15:57:40', '2025-05-27 13:42:45'),
	(9, 'Retiro de Caja', 'EGRESO', 'Retiro de efectivo de la caja', 0, 1, 1, 1, 1, 0, '2025-05-26 15:57:40', '2025-05-27 13:42:53'),
	(10, 'Gastos Operativos', 'EGRESO', 'Pago de gastos operativos varios', 0, 1, 1, 1, 1, 0, '2025-05-26 15:57:40', '2025-05-27 14:31:17'),
	(11, 'Pago de Nómina', 'EGRESO', 'Pago de salarios en efectivo', 1, 1, 1, NULL, 1, 0, '2025-05-26 15:57:40', '2025-05-27 13:27:27'),
	(12, 'Préstamo a Empleado', 'EGRESO', 'Préstamo o anticipo a empleado', 1, 1, 1, NULL, 1, 0, '2025-05-26 15:57:40', '2025-05-27 13:27:30'),
	(13, 'Ajuste por Faltante', 'EGRESO', 'Ajuste contable por faltante en caja', 0, 1, 1, NULL, 1, 0, '2025-05-26 15:57:40', '2025-05-27 13:27:32'),
	(14, 'Otros Egresos', 'EGRESO', 'Otros tipos de egresos no especificados', 0, 1, 1, NULL, 1, 0, '2025-05-26 15:57:40', '2025-05-27 13:36:18'),
	(15, 'Cierre de Caja (Egreso)', 'EGRESO', 'Movimiento automático al cerrar la caja. Representa el retiro del saldo existente para conciliación o transferencia a fondo fijo.', 0, 1, NULL, NULL, 1, 0, '2025-05-26 16:02:56', '2025-05-26 16:03:05'),
	(43, 'Saldo Inicial', 'INGRESO', 'Saldo inicial al abrir la caja', 0, 1, 1, 1, 1, 0, '2025-05-26 21:06:49', '2025-05-26 21:06:49'),
	(44, 'Saldo Inicial', 'INGRESO', 'Saldo inicial al abrir la caja', 0, 1, NULL, 4, 1, 0, '2025-05-29 21:40:51', '2025-05-29 21:40:51'),
	(45, 'Cierre de Caja', 'INGRESO', 'Movimiento de cierre de caja', 0, 1, 1, 1, 1, 0, '2025-05-30 22:12:58', '2025-05-30 22:12:58');

-- Volcando estructura para tabla point_pos.cash_registers
CREATE TABLE IF NOT EXISTS `cash_registers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la caja registradora',
  `code` varchar(50) DEFAULT NULL COMMENT 'Código interno de la caja',
  `name` varchar(100) NOT NULL COMMENT 'Nombre descriptivo de la caja (Ej: Caja Principal, Caja 2)',
  `location_description` varchar(255) DEFAULT NULL COMMENT 'Descripción de la ubicación de la caja',
  `maximun_balance` decimal(15,2) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL COMMENT 'ID del almacén/sucursal asociada (si aplica)',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Estado de la caja (1: Activa, 0: Inactiva)',
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `company_id` int(11) DEFAULT NULL COMMENT 'ID de la empresa propietaria de la caja',
  `created_by` int(11) DEFAULT NULL COMMENT 'Usuario que creó el registro',
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Cajas físicas o puntos de venta donde se maneja efectivo';

-- Volcando datos para la tabla point_pos.cash_registers: ~1 rows (aproximadamente)
INSERT INTO `cash_registers` (`id`, `code`, `name`, `location_description`, `maximun_balance`, `branch_id`, `status`, `is_delete`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(5, '01', 'Caja General', 'Almacén Principal', 5000000.00, 1, 1, 0, 1, 1, 1, '2025-12-01 00:43:23', '2025-12-01 01:52:30');

-- Volcando estructura para tabla point_pos.cash_register_sessions
CREATE TABLE IF NOT EXISTS `cash_register_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cash_register_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `opening_balance` decimal(15,2) DEFAULT 0.00 COMMENT '''Saldo inicial (base) al abrir la caja'',',
  `expected_closing_balance` decimal(15,2) DEFAULT 0.00 COMMENT '''Saldo final esperado (calculado por el sistema)'',',
  `actual_closing_balance` decimal(15,2) DEFAULT 0.00 COMMENT '''Saldo final contado físicamente al cerrar''',
  `difference` decimal(15,2) DEFAULT 0.00 COMMENT '''Diferencia entre esperado y contado (positivo o negativo)'',',
  `current_balance` decimal(15,2) DEFAULT 0.00,
  `total_cash_sales` decimal(15,2) DEFAULT 0.00 COMMENT '''Total de ventas en efectivo durante la sesión'',',
  `total_other_cash_inflows` decimal(15,2) DEFAULT 0.00 COMMENT '''Total otros ingresos de efectivo'',',
  `total_cash_outflows` decimal(15,2) DEFAULT 0.00 COMMENT '''Total egresos de efectivo (gastos, retiros)'',',
  `opened_at` datetime DEFAULT NULL COMMENT '''Fecha y hora de apertura de la sesión'',',
  `closed_at` datetime DEFAULT NULL,
  `status` enum('Open','Closed','Conciliated') DEFAULT NULL,
  `observations_opening` text DEFAULT NULL,
  `observations_closing` text DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='''Control de sesiones de caja (aperturas, cierres, arqueos)''';

-- Volcando datos para la tabla point_pos.cash_register_sessions: ~2 rows (aproximadamente)
INSERT INTO `cash_register_sessions` (`id`, `cash_register_id`, `user_id`, `opening_balance`, `expected_closing_balance`, `actual_closing_balance`, `difference`, `current_balance`, `total_cash_sales`, `total_other_cash_inflows`, `total_cash_outflows`, `opened_at`, `closed_at`, `status`, `observations_opening`, `observations_closing`, `company_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(19, 5, 1, 100000.00, 88100.00, 50000.00, -38100.00, 50000.00, 0.00, 0.00, 0.00, '2025-11-30 22:23:15', '2025-12-01 01:19:24', 'Closed', 'iniciar caja', 'cierre caja saldo real', 1, 1, '2025-12-01 03:23:15', '2025-12-01 06:19:24'),
	(20, 5, 1, 200000.00, 687820.00, 0.00, 0.00, 972905.00, 0.00, 0.00, 0.00, '2025-12-01 01:42:12', NULL, 'Open', 'apertura caja', NULL, 1, 1, '2025-12-01 06:42:12', '2025-12-15 01:08:55');

-- Volcando estructura para tabla point_pos.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(250) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.categories: ~77 rows (aproximadamente)
INSERT INTO `categories` (`id`, `category_name`, `slug`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `created_by`, `company_id`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Estufas', '1-Estufas', 'Mi Categoria', 'Mi Categoria full', 'Lorem ipsum', NULL, 1, 1, 0, 1, '2024-12-04 16:23:26', '2025-04-11 18:42:08'),
	(2, 'FERRETERIA 2', 'FERRETERIA 2', 'Papeleria en general', 'FERRETERIA 2', 'FERRETERIA 2', 'FERRETERIA 2', 1, 1, 0, 1, '2024-12-05 02:24:36', '2025-06-18 21:12:15'),
	(3, 'ventiladores', 'Dulces de la tienda', 'Dulces de la tienda', 'Dulces de la tienda', 'Dulces de la tienda', 'Dulces de la tienda', 1, 1, 0, 1, '2024-12-05 02:28:38', '2025-06-19 05:06:47'),
	(7, 'repuesto verntilador', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:45', '2025-04-11 14:17:47'),
	(8, 'Sillas', 'Sillas', 'Sillas en general', 'Sillas', 'Sillas', NULL, 1, 1, 0, 1, '2025-04-11 18:28:11', '2025-06-19 05:07:30'),
	(9, 'Chanclas', NULL, 'Generales', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 19:04:37', '2025-04-11 19:04:37'),
	(10, 'herramientas', NULL, 'GENERAL', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 19:07:32', '2025-04-11 19:07:32'),
	(11, 'repuesto estufas', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:21', '2025-04-11 14:17:42'),
	(12, 'repuesto licuadora', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:22', '2025-04-11 14:17:43'),
	(13, 'repuesto lavadora', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:23', '2025-04-11 14:17:41'),
	(14, 'colchones', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:24', '2025-04-11 14:17:40'),
	(15, 'camas', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:25', '2025-04-11 14:17:39'),
	(16, 'colchonetas', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:26', '2025-04-11 14:17:38'),
	(17, 'cacharros', NULL, 'INACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:27', '2025-04-11 14:17:37'),
	(18, 'BOTA VENUS TELA', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:29', '2025-04-11 14:17:36'),
	(19, 'BOTA PANTANERA VENUS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:30', '2025-04-11 14:17:36'),
	(20, 'BOTA GRULLA', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:31', '2025-04-11 14:17:35'),
	(21, 'utensilios de cocina', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:17:32', '2025-04-11 14:17:33'),
	(22, 'loza y cristaleria', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:21:59', '2025-04-11 14:22:21'),
	(23, 'jugueteria', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:00', '2025-04-11 14:22:22'),
	(24, 'morrales y maletas', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:01', '2025-04-11 14:22:23'),
	(25, 'mallas', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:02', '2025-04-11 14:22:23'),
	(26, 'licuadoras', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:04', '2025-04-11 14:22:24'),
	(27, 'neveras', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:05', '2025-04-11 14:22:25'),
	(28, 'OLLAS A PRESION', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:06', '2025-04-11 14:22:27'),
	(29, 'molinos y repuestos', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:07', '2025-04-11 14:22:28'),
	(30, 'cuchillos', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:08', '2025-04-11 14:22:29'),
	(31, 'ollas de aluminio', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:09', '2025-04-11 14:22:30'),
	(32, 'CAVAS ICOPOR', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:10', '2025-04-11 14:22:31'),
	(33, 'tornilleria', NULL, 'INACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:11', '2025-04-11 14:22:32'),
	(34, 'cables', NULL, 'INACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:12', '2025-04-11 14:22:33'),
	(35, 'cuerdas', NULL, 'INACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:13', '2025-04-11 14:22:34'),
	(36, 'televisores', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:14', '2025-04-11 14:22:35'),
	(37, 'ponchera y tazones', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:15', '2025-04-11 14:22:36'),
	(38, 'tanques plasticos', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:16', '2025-04-11 14:22:37'),
	(39, 'baldes plasticos', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:17', '2025-04-11 14:22:37'),
	(40, 'hamacas', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:18', '2025-04-11 14:22:38'),
	(41, 'MESAS PLASTICAS ', NULL, 'INACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:22:19', '2025-04-11 14:50:17'),
	(42, 'loza y cristaleria', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:50:15', '2025-04-11 14:50:16'),
	(43, 'ASEO PERSONAL', NULL, 'INACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:54:58', '2025-04-11 14:55:42'),
	(44, 'LOZEROS Y PORTACUBIERTOS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:54:59', '2025-04-11 14:55:44'),
	(45, 'BOTA PANTANERA VEREDA', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:00', '2025-04-11 14:55:45'),
	(46, 'BOTA PANTANERA MACHA', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:01', '2025-04-11 14:55:45'),
	(47, 'BOTA PANTANERA TITAN', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:02', '2025-04-11 14:55:46'),
	(48, 'BOTA VENUS ESTAMPADA', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:03', '2025-04-11 14:55:47'),
	(49, 'BOTA ANDINA DE DAMA', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:04', '2025-04-11 14:55:47'),
	(50, 'BOTA VENUS DE NIÑO', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:05', '2025-04-11 14:55:49'),
	(51, 'BOTA MAXTER', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:05', '2025-04-11 14:55:50'),
	(52, 'BOTA ARGOS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:06', '2025-04-11 14:55:50'),
	(53, 'ZAPATO DE DAMA ', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:07', '2025-04-11 14:55:51'),
	(54, 'ZAPATO COLEGIAL NIÑO', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:08', '2025-04-11 14:55:52'),
	(55, 'GUAYOS Y ZAPATILLAS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:09', '2025-04-11 14:55:53'),
	(56, 'BOTA DE TRABAJO ARGOS Y WELLCO', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:10', '2025-04-11 14:55:54'),
	(57, 'termos cafeteros', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:11', '2025-04-11 14:55:55'),
	(58, 'PESOS Y BASCULAS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:11', '2025-04-11 14:55:56'),
	(59, 'NEVERAS Y TERMOS PLASTICOS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:15', '2025-04-11 14:55:57'),
	(60, 'CHANCLA SOLIMAR HOMBRE', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:16', '2025-04-11 14:55:58'),
	(61, 'CHANCLA SOLIMAR DAMA', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:17', '2025-04-11 14:56:01'),
	(62, 'LAVADORAS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:18', '2025-04-11 14:56:02'),
	(63, 'UTILES ESCOLARES', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:19', '2025-04-11 14:56:03'),
	(64, 'VARIOS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:20', '2025-04-11 14:56:04'),
	(65, 'COBIJAS Y SABANAS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:20', '2025-04-11 14:56:06'),
	(66, 'ENVASES HERMETICOS ', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:26', '2025-04-11 14:56:09'),
	(67, 'JARRAS PLASTICAS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:26', '2025-04-11 14:56:10'),
	(68, 'UTENCILIOS PARA BAÑO', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:28', '2025-04-11 14:56:11'),
	(69, 'UTENSILIOS DE ASEO', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:29', '2025-04-11 14:56:12'),
	(70, 'MACETAS', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:30', '2025-04-11 14:56:13'),
	(71, 'CALDEROS ', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:31', '2025-04-11 14:56:14'),
	(72, 'ELECTRODOMESTICOS ', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:32', '2025-04-11 14:56:18'),
	(73, 'VARIOS 2', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:32', '2025-04-11 14:56:19'),
	(74, 'FERRETERIA ', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:33', '2025-04-11 14:56:20'),
	(75, 'repuesto estufa 2', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:34', '2025-04-11 14:56:20'),
	(76, 'repuestos de olla  a presion', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:35', '2025-04-11 14:56:21'),
	(77, 'herramienta manual', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:55:36', '2025-04-11 14:56:22'),
	(78, 'herramienta electrica', NULL, 'INACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:56:26', '2025-04-11 14:56:23'),
	(79, 'pinturas', NULL, 'ACTIVO', NULL, NULL, NULL, 1, 1, 0, 1, '2025-04-11 14:56:27', '2025-04-11 14:56:24'),
	(80, 'Tecnologia', 'Computadoras', 'Computadores y accesorios', 'Computadoras', 'Computadoras', 'Computadoras, accesorios', 1, 1, 0, 1, '2025-06-18 21:07:36', '2025-06-18 21:07:36');

-- Volcando estructura para tabla point_pos.chart_accounts
CREATE TABLE IF NOT EXISTS `chart_accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `account_code` varchar(20) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `level` tinyint(4) NOT NULL,
  `account_type` enum('ACTIVO','PASIVO','PATRIMONIO','INGRESOS','GASTOS','COSTOS') NOT NULL,
  `nature` enum('DEBIT','CREDIT') NOT NULL,
  `allow_movement` tinyint(1) DEFAULT 1,
  `requires_third_party` tinyint(1) DEFAULT 0,
  `requires_cost_center` tinyint(1) DEFAULT 0,
  `requires_document` tinyint(1) DEFAULT 0,
  `puc_standard` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_company_account` (`company_id`,`account_code`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `chart_accounts_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chart_accounts_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `chart_accounts` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='plan unico de cuentas';

-- Volcando datos para la tabla point_pos.chart_accounts: ~59 rows (aproximadamente)
INSERT INTO `chart_accounts` (`id`, `company_id`, `account_code`, `account_name`, `parent_id`, `level`, `account_type`, `nature`, `allow_movement`, `requires_third_party`, `requires_cost_center`, `requires_document`, `puc_standard`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 1, '1', 'ACTIVO', NULL, 1, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(2, 1, '11', 'ACTIVO CORRIENTE', 1, 2, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(3, 1, '110', 'DISPONIBLE', 2, 3, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(4, 1, '1105', 'CAJA', 3, 4, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(5, 1, '110505', 'CAJA GENERAL', 4, 5, 'ACTIVO', 'DEBIT', 1, 0, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(6, 1, '110510', 'CAJA MENOR', 4, 5, 'ACTIVO', 'DEBIT', 1, 0, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(7, 1, '1110', 'BANCOS', 3, 4, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(8, 1, '111005', 'BANCOS MONEDA NACIONAL', 6, 5, 'ACTIVO', 'DEBIT', 1, 0, 0, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(9, 1, '111010', 'BANCOS MONEDA EXTRANJERA', 6, 5, 'ACTIVO', 'DEBIT', 1, 0, 0, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(10, 1, '113', 'DEUDORES', 2, 3, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(11, 1, '1305', 'CLIENTES', 8, 4, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(12, 1, '130505', 'CLIENTES NACIONALES', 9, 5, 'ACTIVO', 'DEBIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(13, 1, '130510', 'CLIENTES DEL EXTERIOR', 9, 5, 'ACTIVO', 'DEBIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(14, 1, '14', 'INVENTARIOS', 1, 2, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(15, 1, '1430', 'PRODUCTOS TERMINADOS', 11, 3, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(16, 1, '143005', 'PRODUCTOS MANUFACTURADOS', 12, 4, 'ACTIVO', 'DEBIT', 1, 0, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(17, 1, '15', 'PROPIEDADES PLANTA Y EQUIPO', 1, 2, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(18, 1, '1504', 'TERRENOS', 13, 3, 'ACTIVO', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(19, 1, '150405', 'TERRENOS', 14, 4, 'ACTIVO', 'DEBIT', 1, 0, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(20, 1, '2', 'PASIVO', NULL, 1, 'PASIVO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(21, 1, '21', 'PASIVO CORRIENTE', 16, 2, 'PASIVO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(22, 1, '2105', 'OBLIGACIONES FINANCIERAS', 17, 3, 'PASIVO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(23, 1, '210505', 'BANCOS NACIONALES', 18, 4, 'PASIVO', 'CREDIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(24, 1, '210510', 'BANCOS DEL EXTERIOR', 18, 4, 'PASIVO', 'CREDIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(25, 1, '2205', 'PROVEEDORES', 17, 3, 'PASIVO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(26, 1, '220505', 'PROVEEDORES NACIONALES', 20, 4, 'PASIVO', 'CREDIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(27, 1, '220510', 'PROVEEDORES DEL EXTERIOR', 20, 4, 'PASIVO', 'CREDIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(28, 1, '2335', 'CUENTAS POR PAGAR', 17, 3, 'PASIVO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(29, 1, '233505', 'CUENTAS POR PAGAR', 22, 4, 'PASIVO', 'CREDIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(30, 1, '2365', 'IMPUESTOS GRAVÁMENES Y TASAS', 17, 3, 'PASIVO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(31, 1, '236505', 'IVA POR PAGAR', 24, 4, 'PASIVO', 'CREDIT', 1, 0, 0, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(32, 1, '236540', 'RETENCIÓN EN LA FUENTE', 24, 4, 'PASIVO', 'CREDIT', 1, 1, 0, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(33, 1, '3', 'PATRIMONIO', NULL, 1, 'PATRIMONIO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(34, 1, '31', 'CAPITAL SOCIAL', 26, 2, 'PATRIMONIO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(35, 1, '3105', 'CAPITAL SUSCRITO Y PAGADO', 27, 3, 'PATRIMONIO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(36, 1, '310505', 'CAPITAL AUTORIZADO', 28, 4, 'PATRIMONIO', 'CREDIT', 1, 0, 0, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(37, 1, '33', 'UTILIDADES RETENIDAS', 26, 2, 'PATRIMONIO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(38, 1, '3305', 'UTILIDADES ACUMULADAS', 30, 3, 'PATRIMONIO', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(39, 1, '330505', 'UTILIDADES ACUMULADAS', 31, 4, 'PATRIMONIO', 'CREDIT', 1, 0, 0, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(40, 1, '4', 'INGRESOS', NULL, 1, 'INGRESOS', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(41, 1, '41', 'INGRESOS OPERACIONALES', 33, 2, 'INGRESOS', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(42, 1, '4135', 'COMERCIO AL POR MAYOR Y AL POR MENOR', 34, 3, 'INGRESOS', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(43, 1, '413505', 'VENTA DE MERCANCÍAS', 35, 4, 'INGRESOS', 'CREDIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(44, 1, '42', 'INGRESOS NO OPERACIONALES', 33, 2, 'INGRESOS', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(45, 1, '4210', 'FINANCIEROS', 37, 3, 'INGRESOS', 'CREDIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(46, 1, '421005', 'INTERESES', 38, 4, 'INGRESOS', 'CREDIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(47, 1, '5', 'GASTOS', NULL, 1, 'GASTOS', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(48, 1, '51', 'GASTOS OPERACIONALES DE ADMINISTRACIÓN', 40, 2, 'GASTOS', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(49, 1, '5105', 'GASTOS DE PERSONAL', 41, 3, 'GASTOS', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(50, 1, '510506', 'SUELDOS', 42, 4, 'GASTOS', 'DEBIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(51, 1, '510515', 'HORAS EXTRAS', 42, 4, 'GASTOS', 'DEBIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(52, 1, '5135', 'GASTOS GENERALES', 41, 3, 'GASTOS', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(53, 1, '513505', 'ASEO Y VIGILANCIA', 45, 4, 'GASTOS', 'DEBIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(54, 1, '513510', 'SERVICIOS PÚBLICOS', 45, 4, 'GASTOS', 'DEBIT', 1, 1, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(55, 1, '6', 'COSTOS', NULL, 1, 'COSTOS', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(56, 1, '61', 'COSTO DE VENTAS', 48, 2, 'COSTOS', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(57, 1, '6135', 'COMERCIO AL POR MAYOR Y AL POR MENOR', 49, 3, 'COSTOS', 'DEBIT', 0, 0, 0, 0, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(58, 1, '613505', 'COSTO DE VENTAS', 50, 4, 'COSTOS', 'DEBIT', 1, 0, 1, 1, 1, 1, 1, '2025-07-27 22:21:17', '2025-07-27 22:21:17'),
	(59, 1, '12', 'Inversiones', 1, 1, 'ACTIVO', 'DEBIT', 1, 1, 0, 1, 1, 1, 1, '2025-07-28 20:51:32', '2025-07-28 20:51:32');

-- Volcando estructura para tabla point_pos.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dane_code` varchar(100) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `city_name` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ciudades';

-- Volcando datos para la tabla point_pos.cities: ~5 rows (aproximadamente)
INSERT INTO `cities` (`id`, `dane_code`, `department_id`, `city_name`, `created_by`, `company_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, '244', 1, 'EL CARMEN DE BOLIVAR', 1, 1, 0, '2024-12-14 00:20:30', '2025-09-18 06:14:23'),
	(2, '001', 1, 'Cartagena', 1, 1, 0, '2024-12-14 00:32:32', '2025-09-18 06:15:34'),
	(3, '001', 2, 'Barranquilla', 1, 1, 0, '2025-02-19 23:23:49', '2025-09-18 06:17:59'),
	(4, '001', 9, 'Medellin', 1, 1, 0, '2025-06-02 17:57:32', '2025-09-18 06:18:19'),
	(5, NULL, 9, 'Itagui', 1, 1, 0, '2025-06-02 17:57:47', '2025-06-02 17:57:47');

-- Volcando estructura para tabla point_pos.colors
CREATE TABLE IF NOT EXISTS `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_color` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.colors: ~4 rows (aproximadamente)
INSERT INTO `colors` (`id`, `name_color`, `code`, `created_by`, `company_id`, `updated_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(4, 'Negro', '#000000', 1, 1, NULL, 0, 0, '2024-12-24 00:28:50', '2024-12-24 00:28:50'),
	(6, 'Red', '#fc0303', 1, 1, NULL, 0, 0, '2024-12-24 00:41:32', '2024-12-24 00:41:32'),
	(7, 'Azul', '#0642f4', 1, 1, NULL, 0, 0, '2025-02-20 02:33:25', '2025-02-20 02:33:25'),
	(8, 'Eliminame', '#425516', 1, 1, NULL, 0, 1, '2025-06-23 19:54:53', '2025-06-23 19:55:02');

-- Volcando estructura para tabla point_pos.companies
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `busines_type_id` int(11) DEFAULT NULL,
  `identification_type_id` int(11) DEFAULT NULL,
  `identification_number` varchar(250) DEFAULT NULL,
  `dv` varchar(250) DEFAULT NULL,
  `company_name` varchar(250) DEFAULT NULL,
  `short_name` varchar(250) DEFAULT NULL,
  `trade_name` varchar(250) DEFAULT NULL,
  `code_ciiu` varchar(250) DEFAULT NULL,
  `activity_description` varchar(500) DEFAULT NULL,
  `cc_representative` varchar(500) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `legal_representative` varchar(250) DEFAULT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `limit_documents` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `type_regimen_id` int(11) DEFAULT NULL,
  `economic_activity_code` varchar(250) DEFAULT NULL,
  `ica_rate` varchar(250) DEFAULT NULL,
  `type_obligation_id` int(11) DEFAULT NULL,
  `dian_resolution` varchar(50) DEFAULT NULL,
  `invoice_prefix` varchar(50) DEFAULT NULL,
  `resolution_date` date DEFAULT NULL,
  `technical_key` varchar(50) DEFAULT NULL,
  `range_from` bigint(20) DEFAULT NULL,
  `range_to` bigint(20) DEFAULT NULL,
  `current_consecutive` bigint(20) DEFAULT NULL,
  `date_from` date DEFAULT NULL COMMENT 'fecha inicio',
  `date_to` date DEFAULT NULL COMMENT 'fecha fin',
  `environment` enum('Produccion','Pruebas') DEFAULT 'Produccion',
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='empresas';

-- Volcando datos para la tabla point_pos.companies: ~1 rows (aproximadamente)
INSERT INTO `companies` (`id`, `busines_type_id`, `identification_type_id`, `identification_number`, `dv`, `company_name`, `short_name`, `trade_name`, `code_ciiu`, `activity_description`, `cc_representative`, `email`, `legal_representative`, `logo`, `limit_documents`, `country_id`, `department_id`, `city_id`, `address`, `phone`, `currency_id`, `type_regimen_id`, `economic_activity_code`, `ica_rate`, `type_obligation_id`, `dian_resolution`, `invoice_prefix`, `resolution_date`, `technical_key`, `range_from`, `range_to`, `current_consecutive`, `date_from`, `date_to`, `environment`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 3, '1070813753', '2', 'JDSYSTEMAS', 'JERSON DANIEL BATISTA VEGA', 'JSYSTEMAS-JD', NULL, NULL, '1047378360', 'ingjerson2014@gmail.com', 'Jerson Batista', 'uploads/company_logos/1748295160.png', 1000, 46, 1, 1, 'EL CARMEN DE BOLIVAR', '3013230867', 170, 2, '4530', NULL, 2, '18760000001', 'SETP', '2025-09-15', 'fc8eac422eba16e22ffd8c6f94b3f40a6e38162c', 990000000, 995000000, 990000025, '2019-01-19', '2030-01-19', 'Produccion', 1, '2025-03-06 13:32:54', '2025-12-15 01:08:55');

-- Volcando estructura para tabla point_pos.contact_sources
CREATE TABLE IF NOT EXISTS `contact_sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.contact_sources: ~2 rows (aproximadamente)
INSERT INTO `contact_sources` (`id`, `name`, `description`, `status`, `is_delete`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
	(1, 'Sitio web', 'Contactos desde el sitio web corporativo', 1, 0, 1, 1, '2025-09-23 02:10:18', '2025-09-23 02:10:18'),
	(2, 'Redes Sociales', 'Fuente desde facebook,instagram,ticktoc,whatsAap', 1, 0, 1, NULL, '2025-09-23 02:24:47', '2025-09-23 02:24:47');

-- Volcando estructura para tabla point_pos.contact_types
CREATE TABLE IF NOT EXISTS `contact_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `colour` varchar(7) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.contact_types: ~6 rows (aproximadamente)
INSERT INTO `contact_types` (`id`, `company_id`, `created_by`, `updated_by`, `name`, `description`, `colour`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, 'Suscritptor', 'Empieza la vida del contacto', '#07e916', 1, 0, '2025-09-19 00:35:13', '2025-09-19 01:07:27'),
	(2, 1, 1, 1, 'ALMACEN  eliminar y editar', 'erwerwer', '#000000', 1, 1, '2025-09-19 00:58:58', '2025-09-19 01:03:54'),
	(3, 1, 1, NULL, 'Prospectos', 'Segundo tipo de cliente', '#ba6017', 1, 0, '2025-09-19 02:53:07', '2025-09-19 02:53:07'),
	(4, 1, 1, NULL, 'Leads', 'Un lead es un cliente potencial que ha demostrado interés en los productos o servicios de una empresa, proporcionando voluntariamente su información de contacto (como correo electrónico o número de teléfono) a cambio de algo de valor, como contenido exclusivo o una oferta', '#3f0808', 1, 0, '2025-09-19 02:54:06', '2025-09-19 02:54:06'),
	(5, 1, 1, NULL, 'oportunidades', 'una oportunidad es un acuerdo de ventas potencial, un acuerdo de negocio en curso con un cliente o prospecto que ha mostrado interés y tiene alta probabilidad de convertirse en una venta', '#1affa7', 1, 0, '2025-09-19 02:54:56', '2025-09-19 02:54:56'),
	(6, 1, 1, NULL, 'Cliente', 'Cliente ocacional que ha realizado compras', '#9c1dbf', 1, 0, '2025-09-19 02:55:57', '2025-09-19 02:55:57');

-- Volcando estructura para tabla point_pos.cost_centers
CREATE TABLE IF NOT EXISTS `cost_centers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `budget` decimal(15,2) DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  `is_delete` int(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.cost_centers: ~5 rows (aproximadamente)
INSERT INTO `cost_centers` (`id`, `code`, `name`, `budget`, `created_by`, `company_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, '100', 'Administracion', 100000.00, 1, 1, 0, 0, '2025-02-11 04:48:59', '2025-06-12 21:32:16'),
	(2, '25', 'testtestte editado', 0.00, 1, 1, 0, 1, '2025-02-11 05:03:40', '2025-02-11 05:05:13'),
	(3, '200', 'Centro de Ventas', 250000.00, 1, 1, 0, 0, '2025-06-12 21:31:24', '2025-07-02 22:12:10'),
	(4, '300', 'Centro de compras', 0.00, 1, 1, 0, 0, '2025-06-12 21:31:47', '2025-06-12 21:32:37'),
	(5, '400', 'Almacén', 0.00, 1, 1, 0, 0, '2025-06-12 21:33:15', '2025-06-12 21:33:15');

-- Volcando estructura para tabla point_pos.countries
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(191) NOT NULL,
  `code` char(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.countries: ~249 rows (aproximadamente)
INSERT INTO `countries` (`id`, `country_name`, `code`, `created_at`, `updated_at`) VALUES
	(1, 'Afganistán', 'AF\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(2, 'Åland', 'AX\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(3, 'Albania', 'AL\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(4, 'Alemania', 'DE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(5, 'Andorra', 'AD\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(6, 'Angola', 'AO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(7, 'Anguila', 'AI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(8, 'Antártida', 'AQ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(9, 'Antigua y Barbuda', 'AG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(10, 'Arabia Saudita', 'SA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(11, 'Argelia', 'DZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(12, 'Argentina', 'AR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(13, 'Armenia', 'AM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(14, 'Aruba', 'AW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(15, 'Australia', 'AU\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(16, 'Austria', 'AT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(17, 'Azerbaiyán', 'AZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(18, 'Bahamas', 'BS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(19, 'Bangladés', 'BD\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(20, 'Barbados', 'BB\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(21, 'Baréin', 'BH\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(22, 'Bélgica', 'BE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(23, 'Belice', 'BZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(24, 'Benín', 'BJ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(25, 'Bermudas', 'BM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(26, 'Bielorrusia', 'BY\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(27, 'Bolivia', 'BO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(28, 'Bonaire, San Eustaquio y Saba', 'BQ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(29, 'Bosnia y Herzegovina', 'BA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(30, 'Botsuana', 'BW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(31, 'Brasil', 'BR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(32, 'Brunéi', 'BN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(33, 'Bulgaria', 'BG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(34, 'Burkina Faso', 'BF\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(35, 'Burundi', 'BI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(36, 'Bután', 'BT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(37, 'Cabo Verde', 'CV\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(38, 'Camboya', 'KH\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(39, 'Camerún', 'CM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(40, 'Canadá', 'CA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(41, 'Catar', 'QA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(42, 'Chad', 'TD\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(43, 'Chile', 'CL\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(44, 'China', 'CN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(45, 'Chipre', 'CY\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(46, 'Colombia', 'CO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(47, 'Comoras', 'KM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(48, 'Corea del Norte', 'KP\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(49, 'Corea del Sur', 'KR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(50, 'Costa de Marfil', 'CI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(51, 'Costa Rica', 'CR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(52, 'Croacia', 'HR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(53, 'Cuba', 'CU\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(54, 'Curazao', 'CW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(55, 'Dinamarca', 'DK\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(56, 'Dominica', 'DM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(57, 'Ecuador', 'EC\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(58, 'Egipto', 'EG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(59, 'El Salvador', 'SV\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(60, 'Emiratos Árabes Unidos', 'AE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(61, 'Eritrea', 'ER\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(62, 'Eslovaquia', 'SK\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(63, 'Eslovenia', 'SI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(64, 'España', 'ES\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(65, 'Estados Unidos', 'US\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(66, 'Estonia', 'EE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(67, 'Etiopía', 'ET\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(68, 'Filipinas', 'PH\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(69, 'Finlandia', 'FI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(70, 'Fiyi', 'FJ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(71, 'Francia', 'FR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(72, 'Gabón', 'GA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(73, 'Gambia', 'GM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(74, 'Georgia', 'GE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(75, 'Ghana', 'GH\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(76, 'Gibraltar', 'GI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(77, 'Granada', 'GD\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(78, 'Grecia', 'GR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(79, 'Groenlandia', 'GL\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(80, 'Guadalupe', 'GP\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(81, 'Guam', 'GU\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(82, 'Guatemala', 'GT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(83, 'Guayana Francesa', 'GF\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(84, 'Guernsey', 'GG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(85, 'Guinea', 'GN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(86, 'Guinea-Bisáu', 'GW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(87, 'Guinea Ecuatorial', 'GQ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(88, 'Guyana', 'GY\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(89, 'Haití', 'HT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(90, 'Honduras', 'HN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(91, 'Hong Kong', 'HK\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(92, 'Hungría', 'HU\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(93, 'India', 'IN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(94, 'Indonesia', 'ID\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(95, 'Irak', 'IQ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(96, 'Irán', 'IR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(97, 'Irlanda', 'IE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(98, 'Isla Bouvet', 'BV\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(99, 'Isla de Man', 'IM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(100, 'Isla de Navidad', 'CX\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(101, 'Islandia', 'IS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(102, 'Islas Caimán', 'KY\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(103, 'Islas Cocos', 'CC\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(104, 'Islas Cook', 'CK\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(105, 'Islas Feroe', 'FO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(106, 'Islas Georgias del Sur y Sandwich del Sur', 'GS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(107, 'Islas Heard y McDonald', 'HM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(108, 'Islas Malvinas', 'FK\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(109, 'Islas Marianas del Norte', 'MP\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(110, 'Islas Marshall', 'MH\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(111, 'Islas Pitcairn', 'PN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(112, 'Islas Salomón', 'SB\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(113, 'Islas Turcas y Caicos', 'TC\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(114, 'Islas ultramarinas de Estados Unidos', 'UM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(115, 'Islas Vírgenes Británicas', 'VG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(116, 'Islas Vírgenes de los Estados Unidos', 'VI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(117, 'Israel', 'IL\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(118, 'Italia', 'IT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(119, 'Jamaica', 'JM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(120, 'Japón', 'JP\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(121, 'Jersey', 'JE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(122, 'Jordania', 'JO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(123, 'Kazajistán', 'KZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(124, 'Kenia', 'KE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(125, 'Kirguistán', 'KG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(126, 'Kiribati', 'KI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(127, 'Kuwait', 'KW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(128, 'Laos', 'LA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(129, 'Lesoto', 'LS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(130, 'Letonia', 'LV\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(131, 'Líbano', 'LB\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(132, 'Liberia', 'LR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(133, 'Libia', 'LY\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(134, 'Liechtenstein', 'LI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(135, 'Lituania', 'LT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(136, 'Luxemburgo', 'LU\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(137, 'Macao', 'MO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(138, 'Macedonia', 'MK\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(139, 'Madagascar', 'MG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(140, 'Malasia', 'MY\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(141, 'Malaui', 'MW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(142, 'Maldivas', 'MV\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(143, 'Malí', 'ML\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(144, 'Malta', 'MT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(145, 'Marruecos', 'MA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(146, 'Martinica', 'MQ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(147, 'Mauricio', 'MU\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(148, 'Mauritania', 'MR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(149, 'Mayotte', 'YT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(150, 'México', 'MX\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(151, 'Micronesia', 'FM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(152, 'Moldavia', 'MD\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(153, 'Mónaco', 'MC\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(154, 'Mongolia', 'MN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(155, 'Montenegro', 'ME\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(156, 'Montserrat', 'MS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(157, 'Mozambique', 'MZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(158, 'Myanmar', 'MM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(159, 'Namibia', 'NA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(160, 'Nauru', 'NR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(161, 'Nepal', 'NP\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(162, 'Nicaragua', 'NI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(163, 'Níger', 'NE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(164, 'Nigeria', 'NG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(165, 'Niue', 'UN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(166, 'Norfolk', 'NF\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(167, 'Noruega', 'NO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(168, 'Nueva Caledonia', 'NC\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(169, 'Nueva Zelanda', 'NZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(170, 'Omán', 'OM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(171, 'Países Bajos', 'NL\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(172, 'Pakistán', 'PK\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(173, 'Palaos', 'PW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(174, 'Palestina', 'PS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(175, 'Panamá', 'PA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(176, 'Papúa Nueva Guinea', 'PG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(177, 'Paraguay', 'PY\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(178, 'Perú', 'PE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(179, 'Polinesia Francesa', 'PF\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(180, 'Polonia', 'PL\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(181, 'Portugal', 'PT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(182, 'Puerto Rico', 'PR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(183, 'Reino Unido', 'GB\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(184, 'República Árabe Saharaui Democrática', 'EH\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(185, 'República Centroafricana', 'CF\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(186, 'República Checa', 'CZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(187, 'República del Congo', 'CG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(188, 'República Democrática del Congo', 'CD\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(189, 'República Dominicana', 'DO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(190, 'Reunión', 'RE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(191, 'Ruanda', 'RW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(192, 'Rumania', 'RO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(193, 'Rusia', 'RU\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(194, 'Samoa', 'WS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(195, 'Samoa Americana', 'AS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(196, 'San Bartolomé', 'BL\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(197, 'San Cristóbal y Nieves', 'KN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(198, 'San Marino', 'SM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(199, 'San Martín', 'MF\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(200, 'San Pedro y Miquelón', 'PM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(201, 'San Vicente y las Granadinas', 'VC\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(202, 'Santa Elena, Ascensión y Tristán de Acuña', 'SH\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(203, 'Santa Lucía', 'LC\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(204, 'Santo Tomé y Príncipe', 'ST\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(205, 'Senegal', 'SN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(206, 'Serbia', 'RS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(207, 'Seychelles', 'SC\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(208, 'Sierra Leona', 'SL\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(209, 'Singapur', 'SG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(210, 'Sint Maarten', 'SX\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(211, 'Siria', 'SY\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(212, 'Somalia', 'SO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(213, 'Sri Lanka', 'LK\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(214, 'Suazilandia', 'SZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(215, 'Sudáfrica', 'ZA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(216, 'Sudán', 'SD\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(217, 'Sudán del Sur', 'SS\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(218, 'Suecia', 'SI\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(219, 'Suiza', 'CH\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(220, 'Surinam', 'SR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(221, 'Svalbard y Jan Mayen', 'SJ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(222, 'Tailandia', 'TH\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(223, 'Taiwán (República de China)', 'TW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(224, 'Tanzania', 'TZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(225, 'Tayikistán', 'TJ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(226, 'Territorio Británico del Océano Índico', 'IO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(227, 'Tierras Australes y Antárticas Francesas', 'TF\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(228, 'Timor Oriental', 'TL\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(229, 'Togo', 'TG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(230, 'Tokelau', 'TK\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(231, 'Tonga', 'TO\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(232, 'Trinidad y Tobago', 'TT\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(233, 'Túnez', 'TN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(234, 'Turkmenistán', 'TM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(235, 'Turquía', 'TR\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(236, 'Tuvalu', 'TV\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(237, 'Ucrania', 'UA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(238, 'Uganda', 'UG\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(239, 'Uruguay', 'UY\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(240, 'Uzbekistán', 'UZ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(241, 'Vanuatu', 'VU\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(242, 'Vaticano, Ciudad del', 'VA\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(243, 'Venezuela', 'VE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(244, 'Vietnam', 'VN\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(245, 'Wallis y Futuna', 'WF\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(246, 'Yemen', 'YE\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(247, 'Yibuti', 'DJ\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(248, 'Zambia', 'ZM\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16'),
	(249, 'Zimbabue', 'ZW\r', '2025-02-16 22:42:16', '2025-02-16 22:42:16');

-- Volcando estructura para tabla point_pos.credit_debit_notes
CREATE TABLE IF NOT EXISTS `credit_debit_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned DEFAULT NULL,
  `note_type_id` int(11) DEFAULT NULL,
  `resolution_id` bigint(20) unsigned DEFAULT NULL,
  `note_number` varchar(50) NOT NULL COMMENT 'Número de la nota',
  `cufe` varchar(96) DEFAULT NULL COMMENT 'Código Único de Facturación Electrónica',
  `uuid` varchar(36) NOT NULL COMMENT 'UUID único para la nota',
  `original_invoice_id` int(10) unsigned DEFAULT NULL COMMENT 'ID de la factura original',
  `original_invoice_number` varchar(50) NOT NULL COMMENT 'Número de factura original',
  `original_invoice_cufe` varchar(96) DEFAULT NULL COMMENT 'CUFE de la factura original',
  `customer_id` int(10) unsigned DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_document_type` varchar(10) NOT NULL,
  `customer_document_number` varchar(50) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `issuer_name` varchar(255) NOT NULL,
  `issuer_document_type` varchar(10) NOT NULL,
  `issuer_document_number` varchar(50) NOT NULL,
  `issuer_tax_regime` varchar(50) NOT NULL,
  `issue_date` date NOT NULL,
  `issue_time` time NOT NULL,
  `due_date` date DEFAULT NULL,
  `concept_code` varchar(10) NOT NULL COMMENT 'Código del concepto según DIAN',
  `concept_description` text NOT NULL COMMENT 'Descripción del concepto',
  `currency_code` varchar(3) DEFAULT 'COP',
  `exchange_rate` decimal(12,6) DEFAULT 1.000000,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('draft','sent','accepted','rejected','cancelled') DEFAULT 'draft',
  `dian_status` enum('pending','approved','rejected','error') DEFAULT 'pending',
  `validation_errors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Errores de validación DIAN' CHECK (json_valid(`validation_errors`)),
  `notes` text DEFAULT NULL COMMENT 'Observaciones adicionales',
  `delivery_terms` text DEFAULT NULL COMMENT 'Términos de entrega',
  `payment_terms` text DEFAULT NULL COMMENT 'Términos de pago',
  `xml_content` longtext DEFAULT NULL COMMENT 'Contenido XML generado',
  `pdf_path` varchar(500) DEFAULT NULL COMMENT 'Ruta del PDF generado',
  `signature` text DEFAULT NULL COMMENT 'Firma digital',
  `qr_code` text DEFAULT NULL COMMENT 'Código QR',
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_note_number` (`company_id`,`note_number`),
  UNIQUE KEY `unique_cufe` (`cufe`),
  KEY `idx_original_invoice` (`original_invoice_id`),
  KEY `idx_customer` (`customer_id`),
  KEY `idx_status` (`status`),
  KEY `idx_dian_status` (`dian_status`),
  KEY `idx_issue_date` (`issue_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Notas de crédito y débito según normativa DIAN';

-- Volcando datos para la tabla point_pos.credit_debit_notes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.credit_debit_note_items
CREATE TABLE IF NOT EXISTS `credit_debit_note_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `note_id` bigint(20) unsigned NOT NULL,
  `line_number` int(11) NOT NULL COMMENT 'Número de línea',
  `item_id` int(10) unsigned DEFAULT NULL,
  `product_code` varchar(50) DEFAULT NULL COMMENT 'Código del producto',
  `product_name` varchar(500) NOT NULL COMMENT 'Nombre del producto/servicio',
  `product_description` text DEFAULT NULL COMMENT 'Descripción adicional',
  `unit_of_measure` varchar(10) NOT NULL COMMENT 'Unidad de medida',
  `unit_code` varchar(10) NOT NULL COMMENT 'Código de unidad según DIAN',
  `quantity` decimal(12,6) NOT NULL DEFAULT 1.000000,
  `unit_price` decimal(15,6) NOT NULL DEFAULT 0.000000,
  `line_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `net_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_group_id` bigint(20) unsigned DEFAULT NULL,
  `standard_code` varchar(50) DEFAULT NULL COMMENT 'Código estándar del producto',
  `standard_name` varchar(100) DEFAULT NULL COMMENT 'Nombre del estándar (UNSPSC, etc.)',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_note_id` (`note_id`),
  KEY `idx_line_number` (`line_number`),
  KEY `idx_product_id` (`item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Detalle de items en notas de crédito y débito';

-- Volcando datos para la tabla point_pos.credit_debit_note_items: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.credit_debit_note_taxes
CREATE TABLE IF NOT EXISTS `credit_debit_note_taxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `note_id` bigint(20) unsigned NOT NULL,
  `item_id` bigint(20) unsigned DEFAULT NULL COMMENT 'NULL si es impuesto a nivel de nota',
  `tax_code` varchar(10) NOT NULL COMMENT 'Código del impuesto según DIAN',
  `tax_name` varchar(100) NOT NULL COMMENT 'Nombre del impuesto',
  `tax_type` enum('IVA','INC','ICA','RTE_FUENTE','RTE_IVA','RTE_ICA') NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'Tarifa del impuesto',
  `taxable_base` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `unit_tax_amount` decimal(15,6) NOT NULL DEFAULT 0.000000,
  `is_retention` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Si es retención',
  `percentage_base` decimal(5,2) DEFAULT NULL COMMENT 'Base del porcentaje para retenciones',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_note_id` (`note_id`),
  KEY `idx_item_id` (`item_id`),
  KEY `idx_tax_type` (`tax_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Impuestos aplicados en notas de crédito y débito';

-- Volcando datos para la tabla point_pos.credit_debit_note_taxes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.currencies
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(255) NOT NULL,
  `code` char(3) NOT NULL,
  `symbol` char(255) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `co_currencies_code_unique` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=987 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.currencies: ~156 rows (aproximadamente)
INSERT INTO `currencies` (`id`, `currency_name`, `code`, `symbol`, `is_delete`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(8, 'Lek Albanés', 'ALL', 'L\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(12, 'Dinar Algerino', 'DZD', 'د.ج\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(32, 'Peso Argentino', 'ARS', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(36, 'Dólar Australiano', 'AUD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(44, 'Dólar Bahameño', 'BSD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(48, 'Dinar Bahreiní', 'BHD', '.د.ب\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(50, 'Taka De Bangladesh', 'BDT', '৳\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(51, 'Dram Armenio', 'AMD', 'դր.\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(52, 'Dólar De Barbados', 'BBD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(60, 'Dólar Bermudeño', 'BMD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(64, 'Ngultrum De Bután', 'BTN', 'Nu.\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(68, 'Boliviano', 'BOB', 'Bs.\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(72, 'Pula De Botsuana', 'BWP', 'P\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(84, 'Dólar De Belice', 'BZD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(90, 'Dólar De Las Islas Salomón', 'SBD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(96, 'Dólar De Brunéi', 'BND', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(104, 'Kyat Birmano', 'MMK', 'Ks\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(108, 'Franco Burundés', 'BIF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(116, 'Riel Camboyano', 'KHR', '៛\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(124, 'Dólar Canadiense', 'CAD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(132, 'Escudo Caboverdiano', 'CVE', 'Esc or $\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(136, 'Dólar Caimano', 'KYD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(144, 'Rupia De Sri Lanka', 'LKR', 'Rs\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(152, 'Peso Chileno', 'CLP', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(156, 'Yuan Chino', 'CNY', '¥\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(170, 'Peso Colombiano', 'COP', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(174, 'Franco Comoriano', 'KMF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(188, 'Colón Costarricense', 'CRC', '₡\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(191, 'Kuna Croata', 'HRK', 'kn\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(192, 'Peso Cubano', 'CUP', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(203, 'Koruna Checa', 'CZK', 'Kč\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(208, 'Corona Danesa', 'DKK', 'kr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(214, 'Peso Dominicano', 'DOP', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(230, 'Birr Etíope', 'ETB', 'Br\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(232, 'Nakfa Eritreo', 'ERN', 'Nfk\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(238, 'Libra Malvinense', 'FKP', '£\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(242, 'Dólar Fiyiano', 'FJD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(262, 'Franco Yibutiano', 'DJF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(270, 'Dalasi Gambiano', 'GMD', 'D\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(292, 'Libra De Gibraltar', 'GIP', '£\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(320, 'Quetzal Guatemalteco', 'GTQ', 'Q\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(324, 'Franco Guineano', 'GNF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(328, 'Dólar Guyanés', 'GYD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(332, 'Gourde Haitiano', 'HTG', 'G\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(340, 'Lempira Hondureño', 'HNL', 'L\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(344, 'Dólar De Hong Kong', 'HKD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(348, 'Forint Húngaro', 'HUF', 'Ft\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(352, 'Króna Islandesa', 'ISK', 'kr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(356, 'Rupia India', 'INR', '₹\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(360, 'Rupiah Indonesia', 'IDR', 'Rp\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(364, 'Rial Iraní', 'IRR', '﷼\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(368, 'Dinar Iraquí', 'IQD', 'ع.د\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(376, 'Nuevo Shéquel Israelí', 'ILS', '₪\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(388, 'Dólar Jamaicano', 'JMD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(392, 'Yen Japonés', 'JPY', '¥\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(398, 'Tenge Kazajo', 'KZT', '₸\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(400, 'Dinar Jordano', 'JOD', 'د.ا\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(404, 'Chelín Keniata', 'KES', 'Sh\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(408, 'Won Norcoreano', 'KPW', '₩\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(410, 'Won Surcoreano', 'KRW', '₩\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(414, 'Dinar Kuwaití', 'KWD', 'د.ك\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(417, 'Som Kirguís', 'KGS', 'лв\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(418, 'Kip Lao', 'LAK', '₭\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(422, 'Libra Libanesa', 'LBP', 'ل.ل\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(426, 'Loti Lesotense', 'LSL', 'L\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(430, 'Dólar Liberiano', 'LRD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(434, 'Dinar Libio', 'LYD', 'ل.د\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(440, 'Litas Lituano', 'LTL', 'Lt\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(446, 'Pataca De Macao', 'MOP', 'P\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(454, 'Kwacha Malauí', 'MWK', 'MK\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(458, 'Ringgit Malayo', 'MYR', 'RM\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(462, 'Rufiyaa Maldiva', 'MVR', '.ރ\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(478, 'Ouguiya Mauritana', 'MRO', 'UM\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(480, 'Rupia Mauricia', 'MUR', '₨\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(484, 'Peso Mexicano', 'MXN', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(496, 'Tughrik Mongol', 'MNT', '₮\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(498, 'Leu Moldavo', 'MDL', 'L\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(504, 'Dirham Marroquí', 'MAD', 'د.م.\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(512, 'Rial Omaní', 'OMR', 'ر.ع.\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(516, 'Dólar Namibio', 'NAD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(524, 'Rupia Nepalesa', 'NPR', '₨\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(532, 'Florín Antillano Neerlandés', 'ANG', 'ƒ\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(533, 'Florín Arubeño', 'AWG', 'ƒ\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(548, 'Vatu Vanuatense', 'VUV', 'Vt\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(554, 'Dólar Neozelandés', 'NZD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(558, 'Córdoba Nicaragüense', 'NIO', 'C$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(566, 'Naira Nigeriana', 'NGN', '₦\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(578, 'Corona Noruega', 'NOK', 'kr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(586, 'Rupia Pakistaní', 'PKR', '₨\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(590, 'Balboa Panameña', 'PAB', 'B/.\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(598, 'Kina De Papúa Nueva Guinea', 'PGK', 'K\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(600, 'Guaraní Paraguayo', 'PYG', '₲\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(604, 'Nuevo Sol Peruano', 'PEN', 'S/.\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(608, 'Peso Filipino', 'PHP', '₱\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(634, 'Rial Qatarí', 'QAR', 'ر.ق\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(643, 'Rublo Ruso', 'RUB', 'руб.\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(646, 'Franco Ruandés', 'RWF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(654, 'Libra De Santa Helena', 'SHP', '£\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(678, 'Dobra De Santo Tomé Y Príncipe', 'STD', 'Db\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(682, 'Riyal Saudí', 'SAR', 'ر.س\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(690, 'Rupia De Seychelles', 'SCR', '₨\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(694, 'Leone De Sierra Leona', 'SLL', 'Le\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(702, 'Dólar De Singapur', 'SGD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(704, 'Dong Vietnamita', 'VND', '₫\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(706, 'Chelín Somalí', 'SOS', 'Sh\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(710, 'Rand Sudafricano', 'ZAR', 'R\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(728, 'Libra', 'SSP', '£\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(748, 'Lilangeni Suazi', 'SZL', 'L\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(752, 'Corona Sueca', 'SEK', 'kr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(756, 'Franco Suizo', 'CHF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(760, 'Libra Siria', 'SYP', 'ل.س\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(764, 'Baht Tailandés', 'THB', '฿\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(776, 'Pa\'anga Tongano', 'TOP', 'T$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(780, 'Dólar De Trinidad Y Tobago', 'TTD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(784, 'Dirham De Los Emiratos Árabes Unidos', 'AED', 'د.إ\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(788, 'Dinar Tunecino', 'TND', 'د.ت\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(800, 'Chelín Ugandés', 'UGX', 'Sh\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(807, 'Denar Macedonio', 'MKD', 'ден\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(818, 'Libra Egipcia', 'EGP', 'ج.م\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(826, 'Libra Esterlina', 'GBP', '£\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(834, 'Chelín Tanzano', 'TZS', 'Sh\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(840, 'Dólar Estadounidense', 'USD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(858, 'Peso Uruguayo', 'UYU', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(860, 'Som Uzbeko', 'UZS', 'лв\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(882, 'Tala Samoana', 'WST', 'T\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(886, 'Rial Yemení', 'YER', '﷼\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(901, 'Dólar Taiwanés', 'TWD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(931, 'Peso Cubano Convertible', 'CUC', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(934, 'Manat Turcomano', 'TMT', 'm\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(936, 'Cedi Ghanés', 'GHS', '₵\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(937, 'Bolívar Fuerte Venezolano', 'VEF', 'Bs F\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(938, 'Dinar Sudanés', 'SDG', '£\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(941, 'Dinar Serbio', 'RSD', 'дин.\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(943, 'Metical Mozambiqueño', 'MZN', 'MT\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(944, 'Manat Azerbaiyano', 'AZN', 'm\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(946, 'Leu Rumano', 'RON', 'L\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(949, 'Lira Turca', 'TRY', 'NULL\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(950, 'Franco Cfa De África Central', 'XAF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(951, 'Dólar Del Caribe Oriental', 'XCD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(952, 'Franco Cfa De África Occidental', 'XOF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(953, 'Franco Cfp', 'XPF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(967, 'Kwacha Zambiano', 'ZMW', 'ZK\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(968, 'Dólar Surinamés', 'SRD', '$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(969, 'Ariary Malgache', 'MGA', 'Ar\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(971, 'Afgani Afgano', 'AFN', '؋\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(972, 'Somoni Tayik', 'TJS', 'ЅМ\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(973, 'Kwanza Angoleño', 'AOA', 'Kz\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(974, 'Rublo Bielorruso', 'BYR', 'Br\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(975, 'Lev Búlgaro', 'BGN', 'лв\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(976, 'Franco Congoleño', 'CDF', 'Fr\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(977, 'Marco Convertible De Bosnia-Herzegovina', 'BAM', 'КМ\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(978, 'Euro', 'EUR', '€\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(980, 'Grivna Ucraniana', 'UAH', '₴\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(981, 'Lari Georgiano', 'GEL', 'ლ\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(985, 'Zloty Polaco', 'PLN', 'zł\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51'),
	(986, 'Real Brasileño', 'BRL', 'R$\r', 0, NULL, '2025-02-16 23:19:51', '2025-02-16 23:19:51');

-- Volcando estructura para tabla point_pos.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dane_code` varchar(250) DEFAULT NULL,
  `name_department` varchar(250) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='departamentos';

-- Volcando datos para la tabla point_pos.departments: ~8 rows (aproximadamente)
INSERT INTO `departments` (`id`, `dane_code`, `name_department`, `country_id`, `created_by`, `company_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, '13', 'Bolivar', 46, 1, 1, 0, '2024-12-12 00:25:09', '2025-09-18 05:53:02'),
	(2, '08', 'Atlantico', 46, 1, 1, 0, '2024-12-12 00:25:53', '2025-09-18 05:52:39'),
	(4, '70', 'Sucre', 46, 1, 1, 0, '2024-12-12 00:36:12', '2025-09-18 06:02:57'),
	(5, '20', 'Cesar', 46, 1, 1, 0, '2024-12-12 00:36:22', '2025-09-18 06:03:18'),
	(6, '47', 'Magdalena', 46, 1, 1, 0, '2024-12-12 00:36:33', '2025-09-18 06:03:38'),
	(7, '44', 'Guajira', 46, 1, 1, 0, '2024-12-12 00:36:45', '2025-09-18 06:04:03'),
	(8, '23', 'Córdoba', 46, 1, 1, 0, '2025-02-18 22:28:04', '2025-09-18 06:04:33'),
	(9, '05', 'Antioquia', 46, 1, 1, 0, '2025-02-22 01:59:54', '2025-09-18 05:51:09');

-- Volcando estructura para tabla point_pos.depreciation_history
CREATE TABLE IF NOT EXISTS `depreciation_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `depreciation_date` date NOT NULL,
  `period_type` enum('monthly','quarterly','yearly') DEFAULT 'monthly',
  `depreciation_amount` decimal(15,2) NOT NULL,
  `accumulated_depreciation` decimal(15,2) NOT NULL,
  `book_value` decimal(15,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_asset_date` (`asset_id`,`depreciation_date`),
  CONSTRAINT `depreciation_history_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `fixed_assets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.depreciation_history: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.documents
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_type` enum('Factura','Recibo','Nota de Crédito','Nota Débito','Otro') NOT NULL,
  `document_number` varchar(255) NOT NULL,
  `document_date` datetime NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `entity_type` enum('Cliente','Proveedor','Empleado','Otro') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `entity_id` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Documentos relacionados con movimientos de caja';

-- Volcando datos para la tabla point_pos.documents: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.fixed_assets
CREATE TABLE IF NOT EXISTS `fixed_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_code` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `purchase_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `purchase_date` date NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `depreciation_method` enum('straight_line','declining_balance','units_of_production','sum_of_years') DEFAULT 'straight_line',
  `useful_life_years` int(11) DEFAULT 10,
  `useful_life_months` int(11) DEFAULT 120,
  `salvage_value` decimal(15,2) DEFAULT 0.00,
  `depreciation_rate` decimal(5,2) DEFAULT 0.00,
  `book_value` decimal(15,2) DEFAULT 0.00,
  `accumulated_depreciation` decimal(15,2) DEFAULT 0.00,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `warranty_start_date` date DEFAULT NULL,
  `warranty_end_date` date DEFAULT NULL,
  `last_maintenance_date` date DEFAULT NULL,
  `next_maintenance_date` date DEFAULT NULL,
  `status` enum('active','inactive','disposed','under_maintenance','lost','stolen') DEFAULT 'active',
  `condition_status` enum('excellent','good','fair','poor','unusable') DEFAULT 'good',
  `responsible_employee` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_code` (`asset_code`),
  KEY `idx_asset_code` (`asset_code`),
  KEY `idx_category` (`category_id`),
  KEY `idx_location` (`location_id`),
  KEY `idx_status` (`status`),
  KEY `idx_purchase_date` (`purchase_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='tabla principal para los activos fijos';

-- Volcando datos para la tabla point_pos.fixed_assets: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.identification_type
CREATE TABLE IF NOT EXISTS `identification_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identification_name` varchar(250) DEFAULT NULL,
  `abbreviation` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='tipos de identificacion';

-- Volcando datos para la tabla point_pos.identification_type: ~5 rows (aproximadamente)
INSERT INTO `identification_type` (`id`, `identification_name`, `abbreviation`, `created_by`, `company_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Cedula de Ciudadania', 'CD', 1, 1, 0, 0, '2024-12-10 22:58:35', '2024-12-10 22:58:35'),
	(3, 'Número de identificación tributaria', 'NIT', 1, 1, 0, 0, '2024-12-11 23:52:05', '2024-12-11 23:52:05'),
	(4, 'Pasaporte', 'PS', 1, 1, 0, 0, '2025-02-22 01:59:11', '2025-02-22 01:59:11'),
	(5, 'Registro Civil', 'RC', 1, 1, 0, 0, '2025-02-22 01:59:31', '2025-02-22 01:59:31'),
	(6, 'No Tiene', 'NT', 1, 1, 0, 0, '2025-03-21 15:45:11', '2025-03-21 15:45:12');

-- Volcando estructura para tabla point_pos.inventory_adjustments
CREATE TABLE IF NOT EXISTS `inventory_adjustments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adjustment_number` varchar(50) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `adjustment_type_id` int(11) NOT NULL,
  `reason_adjustment_id` int(11) DEFAULT NULL,
  `adjustment_date` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_approval_id` int(11) DEFAULT NULL,
  `approval_date` timestamp NULL DEFAULT NULL,
  `status` enum('draft','pending','approved','rejected','applied') DEFAULT 'draft',
  `comments` text DEFAULT NULL,
  `support_document` varchar(200) DEFAULT NULL,
  `total_value` decimal(12,2) DEFAULT 0.00,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `adjustment_number` (`adjustment_number`),
  KEY `idx_adjustment_number` (`adjustment_number`),
  KEY `idx_adjustment_date` (`adjustment_date`),
  KEY `idx_status` (`status`),
  KEY `idx_warehouse` (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='cabecera del ajuste de inventario';

-- Volcando datos para la tabla point_pos.inventory_adjustments: ~2 rows (aproximadamente)
INSERT INTO `inventory_adjustments` (`id`, `adjustment_number`, `warehouse_id`, `adjustment_type_id`, `reason_adjustment_id`, `adjustment_date`, `created_by`, `company_id`, `user_approval_id`, `approval_date`, `status`, `comments`, `support_document`, `total_value`, `is_delete`, `created_at`, `updated_at`) VALUES
	(9, 'ADJ-2025-000001', 1, 1, 1, '2025-07-30', 1, 1, 1, '2025-07-31 02:17:36', 'approved', 'pruebas', NULL, 706904.00, 0, '2025-07-31 02:11:55', '2025-07-31 02:17:36'),
	(10, 'ADJ-2025-000002', 1, 6, 1, '2025-07-30', 1, 1, 1, '2025-07-31 02:56:03', 'approved', 'pruebas', NULL, 948000.00, 0, '2025-07-31 02:55:06', '2025-07-31 02:56:03');

-- Volcando estructura para tabla point_pos.invoices
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la venta',
  `voucher_type_id` int(11) NOT NULL COMMENT 'Tipo de comprobante (factura, nota crédito, etc.)',
  `customer_id` int(11) NOT NULL COMMENT 'ID del cliente',
  `created_by` int(11) DEFAULT NULL COMMENT 'ID del usuario que creó la venta',
  `uuid` char(36) DEFAULT NULL,
  `operation_type` varchar(10) DEFAULT '10',
  `invoice_no` varchar(500) DEFAULT 'FV' COMMENT 'Número de factura',
  `state_type_id` int(11) NOT NULL COMMENT 'Estado del comprobante (1: Emitido, 2: Anulado, etc.)',
  `warehouse_id` int(11) DEFAULT NULL COMMENT 'ID de la bodega',
  `payment_form_id` int(11) DEFAULT NULL COMMENT 'Forma de pago (1: Contado, 2: Crédito, etc.)',
  `date_of_issue` date DEFAULT NULL COMMENT 'Fecha de emisión del documento',
  `date_of_due` date DEFAULT NULL COMMENT 'Fecha de vencimiento del pago',
  `time_of_issue` time DEFAULT NULL COMMENT 'Hora de emisión del documento',
  `series` char(50) DEFAULT NULL COMMENT 'Serie del comprobante',
  `number` bigint(20) DEFAULT NULL COMMENT 'Número del comprobante',
  `currency_id` int(11) NOT NULL COMMENT 'ID de la moneda (1: COP, 2: USD, etc.)',
  `payment_method_id` int(11) DEFAULT NULL COMMENT 'Método de pago (1: Efectivo, 2: Tarjeta, etc.)',
  `total_subtotal` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Subtotal de la venta',
  `total_tax` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total de impuestos (IVA)',
  `total_discount` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total de descuentos',
  `total_sale` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total de la venta',
  `payment_received` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Monto recibido en el pos',
  `payment_change` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_prepayment` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total de anticipos',
  `total_charge` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total de cargos adicionales',
  `total_taxed` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total gravado',
  `total_unaffected` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total no afecto',
  `total_exonerated` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total exonerado',
  `cufe` varchar(500) DEFAULT NULL COMMENT 'Código único de factura electrónica (CUFE/CUDE)',
  `payment_status_id` int(11) DEFAULT NULL COMMENT 'Estado del pago (1: Pagado, 2: Pendiente, etc.)',
  `electronic_document_status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending' COMMENT 'Estado del documento electrónico',
  `delivery_status` enum('pending','in_transit','delivered') DEFAULT NULL COMMENT 'Estado de entrega',
  `shipping_method` varchar(100) DEFAULT NULL COMMENT 'Método de envío',
  `observations` text DEFAULT NULL COMMENT 'Observaciones',
  `company_id` int(11) DEFAULT NULL COMMENT 'ID de la empresa',
  `is_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si la venta está eliminada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de creación',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Fecha de actualización',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `customer_id` (`customer_id`) USING BTREE,
  KEY `currency_id` (`currency_id`) USING BTREE,
  KEY `payment_method_id` (`payment_method_id`) USING BTREE,
  KEY `voucher_type_id` (`voucher_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla de ventas ajustada a la normatividad colombiana';

-- Volcando datos para la tabla point_pos.invoices: ~2 rows (aproximadamente)
INSERT INTO `invoices` (`id`, `voucher_type_id`, `customer_id`, `created_by`, `uuid`, `operation_type`, `invoice_no`, `state_type_id`, `warehouse_id`, `payment_form_id`, `date_of_issue`, `date_of_due`, `time_of_issue`, `series`, `number`, `currency_id`, `payment_method_id`, `total_subtotal`, `total_tax`, `total_discount`, `total_sale`, `payment_received`, `payment_change`, `total_prepayment`, `total_charge`, `total_taxed`, `total_unaffected`, `total_exonerated`, `cufe`, `payment_status_id`, `electronic_document_status`, `delivery_status`, `shipping_method`, `observations`, `company_id`, `is_delete`, `created_at`, `updated_at`) VALUES
	(31, 2, 40, 1, NULL, '10', 'SETP990000024', 1, 1, 1, '2025-12-14', NULL, '19:59:12', 'SETP', 990000024, 170, 1, 240000.00, 45600.00, 0.00, 285600.00, 0.00, 0.00, 0.00, 0.00, 285600.00, 0.00, 0.00, NULL, NULL, 'pending', 'delivered', NULL, NULL, 1, 0, '2025-12-15 00:59:12', '2025-12-15 00:59:12'),
	(32, 2, 40, 1, '5f72731f-753c-471a-a9ef-a1c599dbae44', '10', 'SETP990000025', 1, 1, 1, '2025-12-14', NULL, '20:08:55', 'SETP', 990000025, 170, 1, 98000.00, 18620.00, 0.00, 116620.00, 0.00, 0.00, 0.00, 0.00, 116620.00, 0.00, 0.00, NULL, NULL, 'pending', 'delivered', NULL, NULL, 1, 0, '2025-12-15 01:08:55', '2025-12-15 01:08:55');

-- Volcando estructura para tabla point_pos.invoices_items
CREATE TABLE IF NOT EXISTS `invoices_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `discount` decimal(15,2) DEFAULT 0.00,
  `tax_id` int(11) DEFAULT NULL,
  `tax_rate` decimal(15,2) DEFAULT NULL,
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `is_taxed` tinyint(1) DEFAULT 0,
  `is_exonerated` tinyint(1) DEFAULT 0,
  `is_unaffected` tinyint(1) DEFAULT 0,
  `observations` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='detalle ventas';

-- Volcando datos para la tabla point_pos.invoices_items: ~2 rows (aproximadamente)
INSERT INTO `invoices_items` (`id`, `invoice_id`, `item_id`, `quantity`, `unit_price`, `total_price`, `discount`, `tax_id`, `tax_rate`, `tax_amount`, `subtotal`, `total`, `is_taxed`, `is_exonerated`, `is_unaffected`, `observations`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
	(59, 31, 24, 1, 240000.00, 240000.00, 0.00, 5, 19.00, 45600.00, 240000.00, 285600.00, 1, 0, 0, NULL, 1, 1, '2025-12-14 19:59:12', '2025-12-14 19:59:12'),
	(60, 32, 23, 1, 98000.00, 98000.00, 0.00, 5, 19.00, 18620.00, 98000.00, 116620.00, 1, 0, 0, NULL, 1, 1, '2025-12-14 20:08:55', '2025-12-14 20:08:55');

-- Volcando estructura para tabla point_pos.invoice_groups
CREATE TABLE IF NOT EXISTS `invoice_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dian_code` varchar(50) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `taxes` decimal(5,2) DEFAULT 19.00 COMMENT 'iva',
  `vat_rate` decimal(5,2) DEFAULT 0.00 COMMENT 'retención en la fuente por IVA ',
  `ica_rete` decimal(5,2) DEFAULT 0.00 COMMENT 'Impuesto de Industria y Comercio',
  `account` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='grupo de inventario Dian';

-- Volcando datos para la tabla point_pos.invoice_groups: ~78 rows (aproximadamente)
INSERT INTO `invoice_groups` (`id`, `dian_code`, `name`, `taxes`, `vat_rate`, `ica_rete`, `account`, `status`, `is_delete`, `company_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, '10051701', 'Equipos de Computación', 19.00, 3.50, 0.97, '135505', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(2, '25101500', 'Motores y Turbinas', 19.00, 3.50, 0.97, '143505', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(3, '39121400', 'Instrumentos Médicos', 19.00, 3.50, 0.00, '143510', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(4, '50202200', 'Medicamentos Esenciales', 0.00, 0.00, 0.00, '143515', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(5, '50131600', 'Productos Farmacéuticos Básicos', 0.00, 0.00, 0.00, '143520', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(6, '10151700', 'Leche y Productos Lácteos', 0.00, 0.00, 0.00, '143525', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(7, '50161700', 'Pan y Productos de Panadería', 5.00, 0.00, 0.00, '143530', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(8, '10121500', 'Café', 5.00, 0.00, 0.00, '143535', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(9, '81111500', 'Servicios de Consultoría', 0.00, 11.00, 0.97, '411005', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(10, '81112000', 'Servicios de Ingeniería', 0.00, 11.00, 0.97, '411010', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(11, '83121600', 'Servicios de Contabilidad', 0.00, 11.00, 0.97, '411015', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(12, '15111500', 'Carne de Res', 0.00, 0.00, 0.00, '143540', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(13, '50131800', 'Productos Veterinarios', 19.00, 1.50, 0.00, '143545', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(14, '30111500', 'Cemento', 5.00, 0.00, 0.41, '143550', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(15, '30121500', 'Acero para Construcción', 19.00, 1.50, 0.41, '143555', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(16, '15111800', 'Gasolina', 19.00, 0.00, 0.00, '143560', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(17, '15111900', 'Diesel', 19.00, 0.00, 0.00, '143565', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(18, '10111500', 'Arroz', 0.00, 0.00, 0.00, '143570', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(19, '10111600', 'Maíz', 0.00, 0.00, 0.00, '143575', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(20, '78111600', 'Transporte de Carga', 0.00, 1.00, 0.97, '411020', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(21, '78121500', 'Transporte de Pasajeros', 0.00, 1.00, 0.97, '411025', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(22, '11141600', 'Ropa de Vestir', 19.00, 3.50, 0.97, '143580', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(23, '11151500', 'Calzado', 19.00, 3.50, 0.97, '143585', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(24, '82141500', 'Servicios Bancarios', 0.00, 0.00, 0.97, '411030', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(25, '82151600', 'Seguros', 0.00, 0.00, 0.97, '411035', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(26, '53131600', 'Productos de Limpieza', 19.00, 3.50, 0.00, '143590', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(27, '81161500', 'Servicios de Internet', 19.00, 3.50, 0.97, '411040', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(28, '81141500', 'Servicios de Telefonía', 19.00, 3.50, 0.97, '411045', 1, 0, 1, 1, '2025-08-01 17:16:33', '2025-08-01 17:16:33'),
	(29, '43211503', 'Computadores y Laptops', 19.00, 3.50, 0.97, '143505', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(30, '43212104', 'Teléfonos Celulares y Smartphones', 19.00, 3.50, 0.97, '143510', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(31, '43211708', 'Tablets y Dispositivos Móviles', 19.00, 3.50, 0.97, '143515', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(32, '43212205', 'Accesorios de Computación', 19.00, 3.50, 0.97, '143520', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(33, '43191501', 'Televisores y Pantallas', 19.00, 3.50, 0.97, '143525', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(34, '52141500', 'Refrigeradores y Neveras', 19.00, 3.50, 0.97, '143530', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(35, '52141600', 'Lavadoras y Secadoras', 19.00, 3.50, 0.97, '143535', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(36, '52121500', 'Estufas y Hornos', 19.00, 3.50, 0.97, '143540', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(37, '52131700', 'Aire Acondicionado', 19.00, 3.50, 0.97, '143545', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(38, '52131600', 'Ventiladores', 19.00, 3.50, 0.97, '143550', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(39, '56101500', 'Muebles de Sala', 19.00, 3.50, 0.97, '143555', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(40, '56101800', 'Muebles de Comedor', 19.00, 3.50, 0.97, '143560', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(41, '56111500', 'Colchones y Bases de Cama', 19.00, 3.50, 0.97, '143565', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(42, '30181500', 'Herramientas de Mano', 19.00, 3.50, 0.97, '143570', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(43, '30181600', 'Herramientas Eléctricas', 19.00, 3.50, 0.97, '143575', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(44, '44121500', 'Papel de Oficina', 19.00, 3.50, 0.97, '143580', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(45, '44121600', 'Útiles de Escritorio', 19.00, 3.50, 0.97, '143585', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(46, '43211901', 'Impresoras y Multifuncionales', 19.00, 3.50, 0.97, '143590', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(47, '44121700', 'Material de Empaque', 19.00, 3.50, 0.97, '143595', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(48, '30111500', 'Cemento y Materiales de Construcción', 5.00, 1.50, 0.41, '143600', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(49, '30121600', 'Tubería y Accesorios', 19.00, 3.50, 0.41, '143605', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(50, '30161500', 'Pintura y Recubrimientos', 19.00, 3.50, 0.41, '143610', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(51, '30151500', 'Cables y Material Eléctrico', 19.00, 3.50, 0.41, '143615', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(52, '25101500', 'Repuestos de Automóviles', 19.00, 3.50, 0.97, '143620', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(53, '25111500', 'Llantas y Neumáticos', 19.00, 3.50, 0.97, '143625', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(54, '15121800', 'Aceites y Lubricantes', 19.00, 3.50, 0.97, '143630', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(55, '25131500', 'Baterías de Vehículos', 19.00, 3.50, 0.97, '143635', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(56, '50201500', 'Productos de Aseo Personal', 19.00, 3.50, 0.97, '143640', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(57, '53131600', 'Productos de Limpieza del Hogar', 19.00, 3.50, 0.97, '143645', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(58, '50401500', 'Cosméticos y Perfumería', 19.00, 3.50, 0.97, '143650', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(59, '42151500', 'Juguetes y Artículos para Niños', 19.00, 3.50, 0.97, '143655', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(60, '53102500', 'Ropa para Hombre', 19.00, 3.50, 0.97, '143660', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(61, '53102600', 'Ropa para Mujer', 19.00, 3.50, 0.97, '143665', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(62, '53102700', 'Ropa para Niños', 19.00, 3.50, 0.97, '143670', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(63, '53111500', 'Calzado en General', 19.00, 3.50, 0.97, '143675', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(64, '53121500', 'Accesorios de Vestir', 19.00, 3.50, 0.97, '143680', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(65, '49181500', 'Artículos Deportivos', 19.00, 3.50, 0.97, '143685', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(66, '49191500', 'Equipos de Ejercicio', 19.00, 3.50, 0.97, '143690', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(67, '49121500', 'Bicicletas y Accesorios', 19.00, 3.50, 0.97, '143695', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(68, '10161700', 'Alimento para Mascotas', 19.00, 3.50, 0.97, '143700', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(69, '42191500', 'Accesorios para Mascotas', 19.00, 3.50, 0.97, '143705', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(70, '55101500', 'Libros y Material Didáctico', 0.00, 0.00, 0.97, '143710', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(71, '43211800', 'Software y Licencias', 19.00, 3.50, 0.97, '143715', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(72, '10151500', 'Semillas y Plantas', 0.00, 0.00, 0.00, '143720', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(73, '21101500', 'Fertilizantes y Abonos', 5.00, 1.50, 0.00, '143725', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(74, '30181800', 'Herramientas de Jardinería', 19.00, 3.50, 0.97, '143730', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(75, '78111500', 'Servicio de Transporte y Entrega', 0.00, 1.00, 0.97, '411005', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(76, '93141500', 'Servicio de Instalación', 0.00, 6.00, 0.97, '411010', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(77, '81112000', 'Servicio Técnico y Reparación', 0.00, 6.00, 0.97, '411015', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23'),
	(78, '93151500', 'Servicio de Mantenimiento', 0.00, 6.00, 0.97, '411020', 1, 0, 1, 1, '2025-08-01 17:31:23', '2025-08-01 17:31:23');

-- Volcando estructura para tabla point_pos.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type_id` int(11) DEFAULT NULL,
  `product_name` varchar(250) DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `barcode` varchar(250) DEFAULT NULL,
  `internal_code` varchar(250) DEFAULT NULL,
  `sku` text DEFAULT NULL,
  `reference` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `expiration` tinyint(1) DEFAULT 0,
  `expiration_date` date DEFAULT NULL,
  `lots_enabled` tinyint(1) DEFAULT 0,
  `lot_code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `aditional_information` text DEFAULT NULL,
  `shipping_returns` text DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `measure_id` int(11) DEFAULT NULL,
  `invoice_group_id` int(11) DEFAULT NULL,
  `cost_price` decimal(20,6) DEFAULT NULL,
  `selling_price` decimal(20,6) DEFAULT NULL,
  `percentage_profit` decimal(20,6) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `price_total` decimal(20,6) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_items_company_delete` (`company_id`,`is_delete`),
  KEY `idx_items_status` (`status`,`is_delete`),
  KEY `idx_items_name` (`product_name`),
  KEY `idx_items_sku` (`sku`(768)),
  KEY `idx_items_reference` (`reference`(768)),
  KEY `idx_items_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='productos';

-- Volcando datos para la tabla point_pos.items: ~39 rows (aproximadamente)
INSERT INTO `items` (`id`, `item_type_id`, `product_name`, `slug`, `barcode`, `internal_code`, `sku`, `reference`, `category_id`, `sub_category_id`, `currency_id`, `expiration`, `expiration_date`, `lots_enabled`, `lot_code`, `description`, `short_description`, `aditional_information`, `shipping_returns`, `brand_id`, `measure_id`, `invoice_group_id`, `cost_price`, `selling_price`, `percentage_profit`, `tax_id`, `price_total`, `created_by`, `updated_by`, `company_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(21, 1, 'ZAPATOS DE DAMA', NULL, '0001', '0001', '012', NULL, 53, NULL, 170, 0, NULL, 0, NULL, 'TALLA XL', NULL, NULL, NULL, 1, 1, NULL, 28000.000000, 46000.000000, NULL, 5, 54740.000000, 4, 1, 1, 0, 0, '2025-05-29 21:15:58', '2025-12-17 04:29:21'),
	(22, 1, '0002', NULL, '0002', '0002', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'Silla Frescura', NULL, NULL, NULL, 1, 1, NULL, 35000.000000, 42500.000000, NULL, 5, 50575.000000, 4, NULL, 1, 0, 0, '2025-05-29 21:19:39', '2025-05-29 21:19:39'),
	(23, 1, 'LICUADORA ALTEZA PRAKTI MIX', NULL, '0003', '0003', NULL, 'gn', 26, NULL, 170, 0, NULL, 0, NULL, 'negra', NULL, NULL, NULL, 16, 1, NULL, 58000.000000, 98000.000000, NULL, 5, 116620.000000, 4, NULL, 1, 0, 0, '2025-05-29 21:21:40', '2025-05-29 21:21:40'),
	(24, 1, 'VENTILADOR ALTEZA 2 EN 1 PEDESTAL MALLA METALICA', NULL, '0004', '0004', NULL, NULL, 3, NULL, 170, 0, NULL, 0, NULL, 'MALLA METALICA', NULL, NULL, NULL, 15, 1, NULL, 182104.000000, 240000.000000, NULL, 5, 285600.000000, 4, NULL, 1, 0, 0, '2025-05-29 21:53:10', '2025-05-29 21:53:10'),
	(25, 1, 'estencion 3 metros', NULL, '7450077032009', '7450077032009', NULL, 'GN', 64, NULL, 170, 0, NULL, 0, NULL, 'EXTENSION', NULL, NULL, NULL, 1, 1, NULL, 6200.000000, 9499.000000, NULL, 5, 11303.810000, 4, NULL, 1, 0, 0, '2025-05-29 21:57:00', '2025-05-29 21:57:00'),
	(26, 1, 'SILLA VANIPLAS SIN BRAZO', NULL, '0005', '0005', NULL, 'gn', 8, NULL, 170, 0, NULL, 0, NULL, 'SIN BRAZO', NULL, NULL, NULL, 1, 1, NULL, 32000.000000, 38000.000000, NULL, 5, 45220.000000, 4, NULL, 1, 0, 0, '2025-05-29 21:59:22', '2025-05-29 21:59:22'),
	(27, 1, 'Silla Colplas SIN BRAZO', NULL, '0006', '0006', NULL, 'gn', 8, NULL, 170, 0, NULL, 0, NULL, 'Sin Brazo', NULL, NULL, NULL, 6, 1, NULL, 26145.000000, 38000.000000, NULL, 5, 45220.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:02:47', '2025-05-29 22:02:47'),
	(28, 1, 'SILLA RIMAX SAMBA SIN BRAZO', NULL, '0007', '0007', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'SIN BRAZO', NULL, NULL, NULL, 1, 1, NULL, 367637.000000, 48000.000000, NULL, 5, 48000.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:04:54', '2025-05-29 22:04:54'),
	(29, 1, 'SILLA RIMAX PLAYERA', NULL, '0008', '0008', NULL, 'gn', 8, NULL, 170, 0, NULL, 0, NULL, 'Silla playera', NULL, NULL, NULL, 4, 1, NULL, 55000.000000, 64000.000000, NULL, 5, 76160.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:07:02', '2025-05-29 22:07:02'),
	(30, 1, 'SILLA COLPLAS HALLURE', NULL, '0009', '0009', NULL, NULL, 8, NULL, 170, 0, NULL, 0, NULL, 'Hallure', NULL, NULL, NULL, 1, 1, NULL, 38864.000000, 49000.000000, NULL, 5, 58310.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:08:40', '2025-05-29 22:08:40'),
	(31, 1, 'SILLA COLPLAS OCEANIA', NULL, '0010', '0010', NULL, NULL, 8, NULL, 170, 0, NULL, 0, NULL, 'Oceania', NULL, NULL, NULL, 1, 1, NULL, 27500.000000, 32500.000000, NULL, 5, 38675.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:11:14', '2025-05-29 22:11:14'),
	(32, 1, 'SILLA VANIPPLAS  FRESCURA', NULL, '0011', '0011', NULL, NULL, 8, NULL, 170, 0, NULL, 0, NULL, 'Frescura', NULL, NULL, NULL, 1, 1, NULL, 38000.000000, 44000.000000, NULL, 5, 52360.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:12:29', '2025-05-29 22:12:29'),
	(33, 1, 'SILLA RIMAX ECOLOGICA CON BRAZO', NULL, '0012', '0012', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'ECOLOGICA', NULL, NULL, NULL, 1, 1, NULL, 38000.000000, 39000.000000, NULL, 5, 46410.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:16:28', '2025-05-29 22:16:28'),
	(34, 1, 'SILLA RIMAX ORIGINAL CON BRAZO', NULL, '0013', '0013', NULL, NULL, 8, NULL, 170, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 29000.000000, 34000.000000, NULL, 5, 40460.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:18:07', '2025-05-29 22:18:07'),
	(35, 1, 'SILLA RIMO BANBU', NULL, '0014', '0014', NULL, NULL, 8, NULL, 170, 0, NULL, 0, NULL, 'BANBU', NULL, NULL, NULL, 1, 1, NULL, 29000.000000, 34000.000000, NULL, 5, 40460.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:26:23', '2025-05-29 22:26:23'),
	(36, 1, 'SILLA EUSSE', NULL, '0015', '0015', NULL, NULL, 8, NULL, 170, 0, NULL, 0, NULL, 'CON BRAZO', NULL, NULL, NULL, 7, 1, NULL, 20000.000000, 26000.000000, NULL, 5, 30940.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:27:39', '2025-05-29 22:27:39'),
	(37, 1, 'SILLA RIMAX ETERNA', NULL, '0016', '0016', NULL, 'gn', 8, NULL, 170, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 40000.000000, 47000.000000, NULL, 5, 55930.000000, 4, NULL, 1, 0, 0, '2025-05-29 22:29:57', '2025-05-29 22:29:57'),
	(39, 1, 'SILLA SUPER NIÑO PLASTIZ', NULL, '3308', '3308', NULL, 'GE', 8, NULL, 170, 0, NULL, 0, NULL, 'SILLA SUPER NIÑO PLASTIZ', NULL, NULL, NULL, 1, 1, NULL, 10500.000000, 14000.000000, NULL, 5, 16660.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:22:02', '2025-06-02 18:22:02'),
	(41, 1, 'BUTACO PLASTIZ', NULL, '3318', '3318', NULL, 'GE', 8, NULL, 170, 0, NULL, 0, NULL, 'BUTACO PLASTIZ', NULL, NULL, NULL, 1, 1, NULL, 15100.000000, 21000.000000, NULL, 5, 24990.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:26:06', '2025-06-02 18:26:06'),
	(43, 1, 'BUTACO PEQUEÑO RIMAX', NULL, '3780', '3780', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'BUTACO PEQUEÑO RIMAX', NULL, NULL, NULL, 7, 1, NULL, 18500.000000, 23500.000000, NULL, 5, 27965.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:27:47', '2025-06-02 18:27:47'),
	(44, 1, 'SILLA RIMO BRISA', NULL, '0019', '0019', 'BRISA', 'GE', 8, NULL, 170, 0, NULL, 0, NULL, 'BRISA', NULL, NULL, NULL, 1, 1, NULL, 31000.000000, 37500.000000, NULL, 5, 44625.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:31:01', '2025-06-02 18:31:01'),
	(46, 1, 'BUTACO RIMAX RATTAN', NULL, '0021', '0021', NULL, 'GE', 8, NULL, 170, 0, NULL, 0, NULL, 'BUTACO RIMAX RATTAN', NULL, NULL, NULL, 7, 1, NULL, 20000.000000, 25000.000000, NULL, 5, 29750.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:33:15', '2025-06-02 18:33:15'),
	(48, 1, 'MESA RIMAX NIÑO', NULL, '0051', '0051', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'SILLAS', NULL, NULL, NULL, 1, 1, NULL, 58933.000000, 72000.000000, NULL, 5, 85680.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:35:01', '2025-06-02 18:35:01'),
	(50, 1, 'MESA RIMAX GRANDE 4 PUESTOS', NULL, '0054', '0054', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'ORIGINAL', NULL, NULL, NULL, 1, 1, NULL, 73699.000000, 88000.000000, NULL, 5, 104720.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:37:18', '2025-06-02 18:37:18'),
	(52, 1, 'MESA MULTIUSO 3 NIVELES RIMAX', NULL, '0766', '0766', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'MULTIUSOS', NULL, NULL, NULL, 1, 2, NULL, 31500.000000, 42000.000000, NULL, 5, 49980.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:39:12', '2025-06-02 18:39:12'),
	(54, 1, 'MESA PORTATIL RIMAX', NULL, '0768', '0768', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'SILLAS', NULL, NULL, NULL, 1, 1, NULL, 33000.000000, 45000.000000, NULL, 5, 53550.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:41:14', '2025-06-02 18:41:14'),
	(56, 1, 'MESA ETERNA WENGUE RIMAX', NULL, '3442', '3442', NULL, 'GE', 8, NULL, 170, 0, NULL, 0, NULL, 'MESA ETERNA WENGUE RIMAX', NULL, NULL, NULL, 1, 1, NULL, 99798.000000, 125000.000000, NULL, 5, 148750.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:43:31', '2025-06-02 18:43:31'),
	(58, 1, 'MESA RIMO 4 PUESTOS', NULL, '0055', '0055', NULL, 'gn', 8, NULL, 170, 0, NULL, 0, NULL, 'MESA RIMO 4 PUESTOS', NULL, NULL, NULL, 7, 1, NULL, 60000.000000, 78000.000000, NULL, 5, 92820.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:51:49', '2025-06-02 18:51:49'),
	(60, 1, 'BUTACO COLPLAS', NULL, '0020', '0020', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'BUTACO COLPLAS', NULL, NULL, NULL, 1, 1, NULL, 11400.000000, 15500.000000, NULL, 5, 18445.000000, 1, NULL, 1, 0, 0, '2025-06-02 18:56:48', '2025-06-02 18:56:48'),
	(62, 1, 'SILLA PLAYERA VANIPLAS', NULL, '3400', '3400', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'SILLA PLAYERA VANIPLAS', NULL, NULL, NULL, 1, 1, NULL, 48000.000000, 47500.000000, NULL, 5, 56525.000000, 1, NULL, 1, 0, 0, '2025-06-02 19:04:57', '2025-06-02 19:04:57'),
	(66, 1, 'BUTACO RATTAN ECONOMICO', NULL, '0023', '0023', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'BUTACO RATTAN ECONOMICO', NULL, NULL, NULL, 1, 1, NULL, 7000.000000, 11500.000000, NULL, 5, 13685.000000, 1, NULL, 1, 0, 0, '2025-06-02 19:25:20', '2025-06-02 19:25:20'),
	(68, 1, 'BUTACO CERRABLE', NULL, '0049', '0049', NULL, 'GN', 8, NULL, 170, 0, NULL, 0, NULL, 'BUTACO', NULL, NULL, NULL, 1, 1, NULL, 19000.000000, 24000.000000, NULL, 5, 28560.000000, 1, NULL, 1, 0, 0, '2025-06-02 19:32:23', '2025-06-02 19:32:23'),
	(69, 1, 'PANEL CUADRADO 9W', NULL, '3446', '3446', NULL, NULL, 73, NULL, 170, 0, NULL, 0, NULL, 'PANEL CUADRADO 9W', NULL, NULL, NULL, 1, 1, NULL, 40000.000000, 47000.000000, NULL, 5, 55930.000000, 4, NULL, 1, 0, 0, '2025-06-02 20:50:42', '2025-06-02 20:50:42'),
	(70, 1, 'fusible de olla grande', NULL, '2673', '2673', NULL, NULL, 76, NULL, 170, 0, NULL, 0, NULL, 'fusible de olla grande', NULL, NULL, NULL, 1, 1, NULL, 1000.000000, 2000.000000, NULL, 5, 2380.000000, 4, NULL, 1, 0, 0, '2025-06-02 20:55:36', '2025-06-02 20:55:36'),
	(71, 1, 'Celular Android', 'celular-android', '10452655', '10235666', '0123', 'GN', 64, NULL, 170, 0, NULL, 0, NULL, 'MIS TECNOLOGIAS', NULL, NULL, NULL, 1, 1, NULL, 10000.000000, 12000.000000, NULL, 5, 14280.000000, 1, NULL, 1, 0, 0, '2025-06-21 05:10:14', '2025-06-21 05:10:14'),
	(72, 2, 'Impresiones a color', 'impresiones-a-color', NULL, '02365', '1002', 'GN', 73, NULL, 170, 0, NULL, 0, NULL, 'Esto es una prueba de&nbsp; los servicios', NULL, NULL, NULL, 1, 1, NULL, 800.000000, 1000.000000, NULL, 1, 1000.000000, 1, NULL, 1, 0, 0, '2025-06-23 18:42:20', '2025-06-23 18:42:20'),
	(73, 1, 'Computador de  ESCRITORIO', 'computador-de-escritorio', '7785555', '01233', '1035555', 'GE', 64, NULL, 170, 0, NULL, 0, NULL, 'COMPUTADOR', NULL, 'computador', NULL, 1, 1, 1, 1000000.000000, 120000.000000, NULL, 5, 142800.000000, 1, NULL, 1, 0, 0, '2025-08-02 00:37:39', '2025-08-02 00:37:39'),
	(74, 4, 'Carne de res', 'carne-de-res', NULL, '12365222', NULL, 'Carnes', 64, NULL, 170, 0, NULL, 0, NULL, 'CARNES DE RES', NULL, NULL, NULL, 1, 8, 12, 8000.000000, 10000.000000, NULL, 1, 10000.000000, 1, NULL, 1, 0, 0, '2025-08-12 06:30:31', '2025-08-12 06:30:31'),
	(75, 2, 'CLASES VACHILLERATO', 'clases-vachillerato', NULL, '1478555', NULL, 'GN', 64, NULL, 170, 0, NULL, 0, NULL, 'SERVICIOS DE CLASES&nbsp;', NULL, NULL, NULL, 1, 1, 9, 10000.000000, 10000.000000, NULL, 1, 10000.000000, 1, NULL, 1, 0, 0, '2025-08-14 20:09:25', '2025-08-14 20:09:25');

-- Volcando estructura para tabla point_pos.items_color
CREATE TABLE IF NOT EXISTS `items_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.items_color: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.items_taxes
CREATE TABLE IF NOT EXISTS `items_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.items_taxes: ~61 rows (aproximadamente)
INSERT INTO `items_taxes` (`id`, `item_id`, `tax_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 14, 5, 1, NULL, '2025-03-04 02:47:19', '2025-03-04 02:47:19'),
	(2, 15, 4, 1, NULL, '2025-03-04 20:20:30', '2025-03-04 20:20:30'),
	(3, 16, 5, 1, NULL, '2025-03-15 03:29:33', '2025-03-15 03:29:33'),
	(4, 17, 5, 1, NULL, '2025-03-15 05:04:32', '2025-03-15 05:04:32'),
	(5, 18, 5, 1, NULL, '2025-03-17 00:45:16', '2025-03-17 00:45:16'),
	(6, 19, 5, 1, NULL, '2025-05-24 05:18:30', '2025-05-24 05:18:30'),
	(7, 20, 5, 1, NULL, '2025-05-24 05:23:24', '2025-05-24 05:23:24'),
	(8, 21, 5, 4, 1, '2025-05-29 21:15:58', '2025-06-09 19:49:06'),
	(9, 22, 5, 4, NULL, '2025-05-29 21:19:39', '2025-05-29 21:19:39'),
	(10, 23, 5, 4, NULL, '2025-05-29 21:21:40', '2025-05-29 21:21:40'),
	(11, 24, 5, 4, NULL, '2025-05-29 21:53:10', '2025-05-29 21:53:10'),
	(12, 25, 5, 4, NULL, '2025-05-29 21:57:00', '2025-05-29 21:57:00'),
	(13, 26, 5, 4, NULL, '2025-05-29 21:59:22', '2025-05-29 21:59:22'),
	(14, 27, 5, 4, NULL, '2025-05-29 22:02:47', '2025-05-29 22:02:47'),
	(15, 28, NULL, 4, NULL, '2025-05-29 22:04:54', '2025-05-29 22:04:54'),
	(16, 29, 5, 4, NULL, '2025-05-29 22:07:02', '2025-05-29 22:07:02'),
	(17, 30, 5, 4, NULL, '2025-05-29 22:08:40', '2025-05-29 22:08:40'),
	(18, 31, 5, 4, NULL, '2025-05-29 22:11:14', '2025-05-29 22:11:14'),
	(19, 32, 5, 4, NULL, '2025-05-29 22:12:30', '2025-05-29 22:12:30'),
	(20, 33, 5, 4, NULL, '2025-05-29 22:16:28', '2025-05-29 22:16:28'),
	(21, 34, 5, 4, NULL, '2025-05-29 22:18:07', '2025-05-29 22:18:07'),
	(22, 35, 5, 4, NULL, '2025-05-29 22:26:23', '2025-05-29 22:26:23'),
	(23, 36, 5, 4, NULL, '2025-05-29 22:27:39', '2025-05-29 22:27:39'),
	(24, 37, 5, 4, NULL, '2025-05-29 22:29:57', '2025-05-29 22:29:57'),
	(25, 38, 5, 1, NULL, '2025-06-02 18:22:02', '2025-06-02 18:22:02'),
	(26, 39, 5, 1, NULL, '2025-06-02 18:22:02', '2025-06-02 18:22:02'),
	(27, 40, 5, 1, NULL, '2025-06-02 18:26:06', '2025-06-02 18:26:06'),
	(28, 41, 5, 1, NULL, '2025-06-02 18:26:06', '2025-06-02 18:26:06'),
	(29, 42, 5, 1, NULL, '2025-06-02 18:27:47', '2025-06-02 18:27:47'),
	(30, 43, 5, 1, NULL, '2025-06-02 18:27:47', '2025-06-02 18:27:47'),
	(31, 44, 5, 1, NULL, '2025-06-02 18:31:01', '2025-06-02 18:31:01'),
	(32, 45, 5, 1, NULL, '2025-06-02 18:31:01', '2025-06-02 18:31:01'),
	(33, 46, 5, 1, NULL, '2025-06-02 18:33:15', '2025-06-02 18:33:15'),
	(34, 47, 5, 1, NULL, '2025-06-02 18:33:15', '2025-06-02 18:33:15'),
	(35, 48, 5, 1, NULL, '2025-06-02 18:35:01', '2025-06-02 18:35:01'),
	(36, 49, 5, 1, NULL, '2025-06-02 18:35:01', '2025-06-02 18:35:01'),
	(37, 50, 5, 1, NULL, '2025-06-02 18:37:18', '2025-06-02 18:37:18'),
	(38, 51, 5, 1, NULL, '2025-06-02 18:37:18', '2025-06-02 18:37:18'),
	(39, 52, 5, 1, NULL, '2025-06-02 18:39:12', '2025-06-02 18:39:12'),
	(40, 53, 5, 1, NULL, '2025-06-02 18:39:12', '2025-06-02 18:39:12'),
	(41, 54, 5, 1, NULL, '2025-06-02 18:41:14', '2025-06-02 18:41:14'),
	(42, 55, 5, 1, NULL, '2025-06-02 18:41:14', '2025-06-02 18:41:14'),
	(43, 56, 5, 1, NULL, '2025-06-02 18:43:31', '2025-06-02 18:43:31'),
	(44, 57, 5, 1, NULL, '2025-06-02 18:43:31', '2025-06-02 18:43:31'),
	(45, 58, 5, 1, NULL, '2025-06-02 18:51:49', '2025-06-02 18:51:49'),
	(46, 59, 5, 1, NULL, '2025-06-02 18:51:49', '2025-06-02 18:51:49'),
	(47, 60, 5, 1, NULL, '2025-06-02 18:56:48', '2025-06-02 18:56:48'),
	(48, 61, 5, 1, NULL, '2025-06-02 18:56:48', '2025-06-02 18:56:48'),
	(49, 62, 5, 1, NULL, '2025-06-02 19:04:57', '2025-06-02 19:04:57'),
	(50, 63, 5, 1, NULL, '2025-06-02 19:04:57', '2025-06-02 19:04:57'),
	(51, 64, 5, 1, NULL, '2025-06-02 19:09:50', '2025-06-02 19:09:50'),
	(53, 66, 5, 1, NULL, '2025-06-02 19:25:20', '2025-06-02 19:25:20'),
	(54, 67, 5, 1, NULL, '2025-06-02 19:25:20', '2025-06-02 19:25:20'),
	(55, 68, 5, 1, NULL, '2025-06-02 19:32:23', '2025-06-02 19:32:23'),
	(56, 69, 5, 4, NULL, '2025-06-02 20:50:42', '2025-06-02 20:50:42'),
	(57, 70, 5, 4, NULL, '2025-06-02 20:55:36', '2025-06-02 20:55:36'),
	(58, 71, 5, 1, NULL, '2025-06-21 05:10:14', '2025-06-21 05:10:14'),
	(59, 72, 1, 1, NULL, '2025-06-23 18:42:20', '2025-06-23 18:42:20'),
	(60, 73, 5, 1, NULL, '2025-08-02 00:37:39', '2025-08-02 00:37:39'),
	(61, 74, 1, 1, NULL, '2025-08-12 06:30:31', '2025-08-12 06:30:31'),
	(62, 75, 1, 1, NULL, '2025-08-14 20:09:25', '2025-08-14 20:09:25');

-- Volcando estructura para tabla point_pos.items_transactions
CREATE TABLE IF NOT EXISTS `items_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.items_transactions: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.items_type
CREATE TABLE IF NOT EXISTS `items_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.items_type: ~4 rows (aproximadamente)
INSERT INTO `items_type` (`id`, `name`, `description`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Producto Inventariado', 'Producto para llevar a inventario', 1, 0, 0, '2025-02-13 21:12:53', '2025-02-13 21:12:53'),
	(2, 'Servicios', 'Sin inventario', 1, 0, 0, '2025-02-13 21:13:14', '2025-02-13 21:13:14'),
	(3, 'Auto Consumo', 'Producto para consumo local', 1, 0, 0, '2025-02-13 21:13:46', '2025-02-13 21:13:46'),
	(4, 'Producto no Inventariado', 'Productos variados sin inventario fijo', 1, 0, 0, '2025-08-12 06:13:07', '2025-08-12 06:13:07');

-- Volcando estructura para tabla point_pos.item_movements
CREATE TABLE IF NOT EXISTS `item_movements` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `movement_type_id` int(11) DEFAULT NULL,
  `movement_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `previous_stock` int(11) DEFAULT NULL,
  `new_stock` int(11) DEFAULT NULL,
  `reason` varchar(500) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `reference_type` enum('Nuevo','Entrada','Salida','Traslado','Ajuste') DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_item_movements_item_warehouse` (`item_id`,`warehouse_id`,`is_delete`),
  KEY `idx_item_movements_company` (`company_id`,`is_delete`),
  KEY `idx_item_movements_date` (`movement_date`,`is_delete`),
  KEY `idx_item_movements_user` (`created_by`,`is_delete`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.item_movements: ~59 rows (aproximadamente)
INSERT INTO `item_movements` (`id`, `item_id`, `warehouse_id`, `movement_type_id`, `movement_date`, `quantity`, `previous_stock`, `new_stock`, `reason`, `reference_id`, `reference_type`, `created_by`, `company_id`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 21, 1, 6, '2025-10-19', 1, 47, 46, 'Venta #FV-000007', 7, 'Salida', 1, 1, 0, '2025-10-20 03:32:48', '2025-10-20 03:32:48'),
	(2, 22, 1, 6, '2025-10-19', 1, 52, 51, 'Venta #FV-000008', 8, 'Salida', 1, 1, 0, '2025-10-20 03:37:16', '2025-10-20 03:37:16'),
	(3, 21, 1, 6, '2025-10-23', 1, 46, 45, 'Venta #SETP990000001', 9, 'Salida', 1, 1, 0, '2025-10-23 05:41:55', '2025-10-23 05:41:55'),
	(4, 22, 1, 6, '2025-10-23', 1, 51, 50, 'Venta POS #SETP990000002', 12, 'Salida', 1, 1, 0, '2025-10-23 05:50:47', '2025-10-23 05:50:47'),
	(5, 22, 1, 6, '2025-10-23', 1, 50, 49, 'Venta POS #SETP990000003', 13, 'Salida', 1, 1, 0, '2025-10-23 06:08:57', '2025-10-23 06:08:57'),
	(6, 24, 1, 6, '2025-10-23', 1, 6, 5, 'Venta POS #SETP990000004', 14, 'Salida', 1, 1, 0, '2025-10-23 06:17:30', '2025-10-23 06:17:30'),
	(7, 23, 1, 6, '2025-10-23', 1, 13, 12, 'Venta #SETP990000006', 15, 'Salida', 1, 1, 0, '2025-10-23 06:34:22', '2025-10-23 06:34:22'),
	(8, 23, 1, 6, '2025-10-23', 1, 12, 11, 'Venta POS #SETP990000007', 16, 'Salida', 1, 1, 0, '2025-10-23 06:35:39', '2025-10-23 06:35:39'),
	(9, 23, 1, 6, '2025-10-26', 1, 11, 10, 'Venta #SETP990000009', 17, 'Salida', 1, 1, 0, '2025-10-27 04:33:34', '2025-10-27 04:33:34'),
	(10, 24, 1, 6, '2025-10-26', 1, 5, 4, 'Venta #SETP990000011', 18, 'Salida', 1, 1, 0, '2025-10-27 04:34:39', '2025-10-27 04:34:39'),
	(11, 24, 1, 6, '2025-10-26', 1, 4, 3, 'Venta #SETP990000012', 19, 'Salida', 1, 1, 0, '2025-10-27 04:46:06', '2025-10-27 04:46:06'),
	(12, 22, 1, 6, '2025-11-10', 1, 49, 48, 'Venta POS #SETP990000013', 20, 'Salida', 1, 1, 0, '2025-11-11 03:58:25', '2025-11-11 03:58:25'),
	(13, 23, 1, 6, '2025-11-10', 1, 10, 9, 'Venta POS #SETP990000013', 20, 'Salida', 1, 1, 0, '2025-11-11 03:58:25', '2025-11-11 03:58:25'),
	(14, 26, 1, 6, '2025-11-10', 1, 34, 33, 'Venta POS #SETP990000014', 21, 'Salida', 1, 1, 0, '2025-11-11 04:06:33', '2025-11-11 04:06:33'),
	(15, 27, 1, 6, '2025-11-10', 1, 35, 34, 'Venta POS #SETP990000015', 22, 'Salida', 1, 1, 0, '2025-11-11 04:17:01', '2025-11-11 04:17:01'),
	(16, 28, 1, 6, '2025-11-10', 1, 34, 33, 'Venta POS #SETP990000015', 22, 'Salida', 1, 1, 0, '2025-11-11 04:17:01', '2025-11-11 04:17:01'),
	(17, 60, 1, 6, '2025-11-10', 1, 21, 20, 'Venta POS #SETP990000015', 22, 'Salida', 1, 1, 0, '2025-11-11 04:17:01', '2025-11-11 04:17:01'),
	(18, 62, 1, 6, '2025-11-10', 1, 8, 7, 'Venta POS #SETP990000015', 22, 'Salida', 1, 1, 0, '2025-11-11 04:17:01', '2025-11-11 04:17:01'),
	(19, 32, 1, 6, '2025-11-10', 1, 10, 9, 'Venta POS #SETP990000016', 23, 'Salida', 1, 1, 0, '2025-11-11 04:23:14', '2025-11-11 04:23:14'),
	(20, 36, 1, 6, '2025-11-10', 1, 11, 10, 'Venta POS #SETP990000016', 23, 'Salida', 1, 1, 0, '2025-11-11 04:23:14', '2025-11-11 04:23:14'),
	(21, 35, 1, 6, '2025-11-10', 1, 25, 24, 'Venta POS #SETP990000016', 23, 'Salida', 1, 1, 0, '2025-11-11 04:23:14', '2025-11-11 04:23:14'),
	(22, 50, 1, 6, '2025-11-10', 1, 15, 14, 'Venta POS #SETP990000016', 23, 'Salida', 1, 1, 0, '2025-11-11 04:23:14', '2025-11-11 04:23:14'),
	(23, 60, 1, 6, '2025-11-10', 1, 20, 19, 'Venta POS #SETP990000016', 23, 'Salida', 1, 1, 0, '2025-11-11 04:23:14', '2025-11-11 04:23:14'),
	(24, 28, 1, 6, '2025-11-10', 1, 33, 32, 'Venta POS #SETP990000017', 24, 'Salida', 1, 1, 0, '2025-11-11 04:31:00', '2025-11-11 04:31:00'),
	(25, 27, 1, 6, '2025-11-10', 1, 34, 33, 'Venta POS #SETP990000017', 24, 'Salida', 1, 1, 0, '2025-11-11 04:31:00', '2025-11-11 04:31:00'),
	(26, 29, 1, 6, '2025-11-10', 1, 2, 1, 'Venta POS #SETP990000017', 24, 'Salida', 1, 1, 0, '2025-11-11 04:31:00', '2025-11-11 04:31:00'),
	(27, 30, 1, 6, '2025-11-10', 1, 39, 38, 'Venta POS #SETP990000017', 24, 'Salida', 1, 1, 0, '2025-11-11 04:31:00', '2025-11-11 04:31:00'),
	(28, 32, 1, 6, '2025-11-10', 1, 9, 8, 'Venta POS #SETP990000017', 24, 'Salida', 1, 1, 0, '2025-11-11 04:31:00', '2025-11-11 04:31:00'),
	(29, 36, 1, 6, '2025-11-10', 1, 10, 9, 'Venta POS #SETP990000017', 24, 'Salida', 1, 1, 0, '2025-11-11 04:31:00', '2025-11-11 04:31:00'),
	(30, 35, 1, 6, '2025-11-10', 1, 24, 23, 'Venta POS #SETP990000017', 24, 'Salida', 1, 1, 0, '2025-11-11 04:31:00', '2025-11-11 04:31:00'),
	(31, 48, 1, 6, '2025-11-10', 1, 2, 1, 'Venta POS #SETP990000017', 24, 'Salida', 1, 1, 0, '2025-11-11 04:31:00', '2025-11-11 04:31:00'),
	(32, 26, 1, 6, '2025-11-10', 2, 33, 31, 'Venta POS #SETP990000018', 25, 'Salida', 1, 1, 0, '2025-11-11 04:34:07', '2025-11-11 04:34:07'),
	(33, 24, 1, 6, '2025-11-10', 1, 3, 2, 'Venta POS #SETP990000018', 25, 'Salida', 1, 1, 0, '2025-11-11 04:34:07', '2025-11-11 04:34:07'),
	(34, 23, 1, 6, '2025-11-10', 1, 9, 8, 'Venta POS #SETP990000018', 25, 'Salida', 1, 1, 0, '2025-11-11 04:34:07', '2025-11-11 04:34:07'),
	(35, 33, 1, 6, '2025-11-10', 1, 2, 1, 'Venta POS #SETP990000018', 25, 'Salida', 1, 1, 0, '2025-11-11 04:34:07', '2025-11-11 04:34:07'),
	(36, 34, 1, 6, '2025-11-10', 1, 36, 35, 'Venta POS #SETP990000018', 25, 'Salida', 1, 1, 0, '2025-11-11 04:34:07', '2025-11-11 04:34:07'),
	(37, 39, 1, 6, '2025-11-10', 1, 2, 1, 'Venta POS #SETP990000018', 25, 'Salida', 1, 1, 0, '2025-11-11 04:34:07', '2025-11-11 04:34:07'),
	(38, 37, 1, 6, '2025-11-10', 1, 20, 19, 'Venta POS #SETP990000018', 25, 'Salida', 1, 1, 0, '2025-11-11 04:34:07', '2025-11-11 04:34:07'),
	(39, 69, 1, 6, '2025-11-12', 2, 16, 14, 'Venta #SETP990000019', 26, 'Salida', 1, 1, 0, '2025-11-13 04:38:13', '2025-11-13 04:38:13'),
	(40, 66, 1, 6, '2025-11-12', 1, 7, 6, 'Venta #SETP990000019', 26, 'Salida', 1, 1, 0, '2025-11-13 04:38:13', '2025-11-13 04:38:13'),
	(41, 62, 1, 6, '2025-11-12', 1, 7, 6, 'Venta #SETP990000019', 26, 'Salida', 1, 1, 0, '2025-11-13 04:38:13', '2025-11-13 04:38:13'),
	(42, 39, 1, 6, '2025-11-12', 1, 1, 0, 'Venta #SETP990000019', 26, 'Salida', 1, 1, 0, '2025-11-13 04:38:13', '2025-11-13 04:38:13'),
	(43, 37, 1, 6, '2025-11-12', 1, 19, 18, 'Venta #SETP990000019', 26, 'Salida', 1, 1, 0, '2025-11-13 04:38:13', '2025-11-13 04:38:13'),
	(44, 36, 1, 6, '2025-11-12', 1, 9, 8, 'Venta #SETP990000019', 26, 'Salida', 1, 1, 0, '2025-11-13 04:38:13', '2025-11-13 04:38:13'),
	(45, 35, 1, 6, '2025-11-12', 1, 23, 22, 'Venta #SETP990000019', 26, 'Salida', 1, 1, 0, '2025-11-13 04:38:13', '2025-11-13 04:38:13'),
	(46, 33, 1, 6, '2025-11-12', 1, 1, 0, 'Venta #SETP990000019', 26, 'Salida', 1, 1, 0, '2025-11-13 04:38:13', '2025-11-13 04:38:13'),
	(47, 32, 1, 6, '2025-11-12', 1, 8, 7, 'Venta #SETP990000019', 26, 'Salida', 1, 1, 0, '2025-11-13 04:38:13', '2025-11-13 04:38:13'),
	(48, 69, 1, 2, NULL, 1, 14, 15, 'Compra de producto', 52, 'Entrada', 1, 1, 0, '2025-11-13 04:43:23', '2025-11-13 04:43:23'),
	(49, 39, 1, 2, NULL, 1, 0, 1, 'Compra de producto', 52, 'Entrada', 1, 1, 0, '2025-11-13 04:43:23', '2025-11-13 04:43:23'),
	(50, 32, 1, 2, NULL, 1, 7, 8, 'Compra de producto', 52, 'Entrada', 1, 1, 0, '2025-11-13 04:43:23', '2025-11-13 04:43:23'),
	(51, 21, 1, 6, '2025-12-01', 1, 45, 44, 'Venta #SETP990000020', 27, 'Salida', 1, 1, 0, '2025-12-01 06:04:39', '2025-12-01 06:04:39'),
	(52, 21, 1, 2, NULL, 2, 44, 46, 'Compra de producto', 53, 'Entrada', 1, 1, 0, '2025-12-01 06:09:37', '2025-12-01 06:09:37'),
	(53, 22, 1, 6, '2025-12-09', 1, 48, 47, 'Venta POS #SETP990000021', 28, 'Salida', 1, 1, 0, '2025-12-09 05:11:07', '2025-12-09 05:11:07'),
	(54, 23, 1, 2, NULL, 1, 8, 9, 'Compra de producto', 54, 'Entrada', 1, 1, 0, '2025-12-09 06:14:13', '2025-12-09 06:14:13'),
	(55, 24, 1, 6, '2025-12-10', 1, 2, 1, 'Venta #SETP990000022', 29, 'Salida', 1, 1, 0, '2025-12-10 06:16:14', '2025-12-10 06:16:14'),
	(56, 26, 1, 6, '2025-12-12', 1, 31, 30, 'Venta POS #SETP990000023', 30, 'Salida', 1, 1, 0, '2025-12-12 06:06:21', '2025-12-12 06:06:21'),
	(57, 30, 1, 6, '2025-12-12', 1, 38, 37, 'Venta POS #SETP990000023', 30, 'Salida', 1, 1, 0, '2025-12-12 06:06:21', '2025-12-12 06:06:21'),
	(58, 24, 1, 6, '2025-12-14', 1, 1, 0, 'Venta #SETP990000024', 31, 'Salida', 1, 1, 0, '2025-12-15 00:59:12', '2025-12-15 00:59:12'),
	(59, 23, 1, 6, '2025-12-14', 1, 9, 8, 'Venta #SETP990000025', 32, 'Salida', 1, 1, 0, '2025-12-15 01:08:55', '2025-12-15 01:08:55');

-- Volcando estructura para tabla point_pos.item_warehouse
CREATE TABLE IF NOT EXISTS `item_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `stock` float DEFAULT NULL,
  `min_quantity` float DEFAULT NULL,
  `max_quantity` float DEFAULT NULL,
  `reorder_level` float DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_item_warehouse` (`item_id`,`warehouse_id`),
  KEY `idx_item_warehouse_item_warehouse` (`item_id`,`warehouse_id`,`is_delete`),
  KEY `idx_item_warehouse_company` (`company_id`,`is_delete`),
  KEY `idx_item_warehouse_warehouse` (`warehouse_id`,`is_delete`),
  KEY `idx_item_warehouse_stock` (`stock`,`is_delete`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.item_warehouse: ~38 rows (aproximadamente)
INSERT INTO `item_warehouse` (`id`, `item_id`, `warehouse_id`, `stock`, `min_quantity`, `max_quantity`, `reorder_level`, `created_by`, `company_id`, `is_delete`, `created_at`, `updated_at`) VALUES
	(56, 21, 1, 46, 10, 100, 20, 4, 1, 0, '2025-05-29 21:15:58', '2025-12-01 06:09:37'),
	(57, 22, 1, 47, 5, 100, 20, 4, 1, 0, '2025-05-29 21:19:39', '2025-12-09 05:11:07'),
	(58, 23, 1, 8, 10, 100, 20, 4, 1, 0, '2025-05-29 21:21:40', '2025-12-15 01:08:55'),
	(59, 24, 1, 0, 10, 100, 20, 4, 1, 0, '2025-05-29 21:53:10', '2025-12-15 00:59:12'),
	(60, 25, 1, 11, 10, 100, 20, 4, 1, 0, '2025-05-29 21:57:00', '2025-07-31 00:46:44'),
	(61, 26, 1, 30, 10, 100, 20, 4, 1, 0, '2025-05-29 21:59:22', '2025-12-12 06:06:21'),
	(62, 27, 1, 33, 10, 100, 20, 4, 1, 0, '2025-05-29 22:02:47', '2025-11-11 04:31:00'),
	(63, 28, 1, 32, NULL, 100, 20, 4, 1, 0, '2025-05-29 22:04:54', '2025-11-11 04:31:00'),
	(64, 29, 1, 1, 10, 100, 20, 4, 1, 0, '2025-05-29 22:07:02', '2025-11-11 04:31:00'),
	(65, 30, 1, 37, 10, 200, 20, 4, 1, 0, '2025-05-29 22:08:40', '2025-12-12 06:06:21'),
	(66, 31, 1, 33, 10, 100, 10, 4, 1, 0, '2025-05-29 22:11:15', '2025-06-06 23:06:58'),
	(67, 32, 1, 8, 10, 100, 20, 4, 1, 0, '2025-05-29 22:12:30', '2025-11-13 04:43:23'),
	(68, 33, 1, 0, 100, 200, 10, 4, 1, 0, '2025-05-29 22:16:28', '2025-11-13 04:38:13'),
	(69, 34, 1, 35, 50, 200, 20, 4, 1, 0, '2025-05-29 22:18:07', '2025-11-11 04:34:07'),
	(70, 35, 1, 22, 20, 200, 20, 4, 1, 0, '2025-05-29 22:26:23', '2025-11-13 04:38:13'),
	(71, 36, 1, 8, 100, 200, 30, 4, 1, 0, '2025-05-29 22:27:39', '2025-11-13 04:38:13'),
	(72, 37, 1, 18, NULL, NULL, NULL, 4, 1, 0, '2025-05-29 22:29:57', '2025-11-13 04:38:13'),
	(74, 39, 1, 1, 2, 100, 5, 1, 1, 0, '2025-06-02 18:22:02', '2025-11-13 04:43:23'),
	(76, 41, 1, 7, 5, 100, 20, 1, NULL, 0, '2025-06-02 18:26:06', '2025-07-30 23:43:53'),
	(78, 43, 1, 12, 10, 200, 20, 1, NULL, 0, '2025-06-02 18:27:47', '2025-07-30 23:43:53'),
	(80, 45, 1, 4, 10, 100, 20, 1, NULL, 0, '2025-06-02 18:31:01', '2025-06-02 18:31:01'),
	(81, 46, 1, 2, 10, 200, 30, 1, NULL, 0, '2025-06-02 18:33:15', '2025-06-02 18:33:15'),
	(83, 48, 1, 1, 20, 100, 30, 1, NULL, 0, '2025-06-02 18:35:01', '2025-11-11 04:31:00'),
	(85, 50, 1, 14, 20, 200, 25, 1, NULL, 0, '2025-06-02 18:37:18', '2025-11-11 04:23:14'),
	(87, 52, 1, 8, 10, 100, 20, 1, NULL, 0, '2025-06-02 18:39:12', '2025-06-02 18:39:12'),
	(89, 54, 1, 3, 10, 100, 20, 1, NULL, 0, '2025-06-02 18:41:14', '2025-06-02 18:41:14'),
	(91, 56, 1, 3, 10, 100, 20, 1, NULL, 0, '2025-06-02 18:43:31', '2025-06-02 18:43:31'),
	(93, 58, 1, 7, 10, 200, 20, 1, NULL, 0, '2025-06-02 18:51:49', '2025-06-02 18:51:49'),
	(95, 60, 1, 19, 20, 200, 25, 1, NULL, 0, '2025-06-02 18:56:48', '2025-11-11 04:23:14'),
	(96, 61, 1, 21, 20, 200, 25, 1, NULL, 0, '2025-06-02 18:56:48', '2025-06-02 18:56:48'),
	(97, 62, 1, 6, 20, 200, 30, 1, 1, 0, '2025-06-02 19:04:57', '2025-11-13 04:38:13'),
	(101, 66, 1, 6, 30, 100, 20, 1, 1, 0, '2025-06-02 19:25:20', '2025-11-13 04:38:13'),
	(103, 68, 1, 2, 10, 200, 30, 1, 1, 0, '2025-06-02 19:32:23', '2025-06-02 19:32:23'),
	(104, 69, 1, 15, 10, 200, 20, 4, 1, 0, '2025-06-02 20:50:42', '2025-11-13 04:43:23'),
	(105, 70, 1, 21, 10, 50, 25, 4, 1, 0, '2025-06-02 20:55:36', '2025-07-31 00:53:50'),
	(106, 71, 1, 30, 10, 100, 25, 1, 1, 0, '2025-06-21 05:10:14', '2025-07-31 00:53:50'),
	(107, 73, 1, 10, 5, 30, 5, 1, 1, 0, '2025-08-02 00:37:39', '2025-08-02 00:37:39'),
	(108, 74, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, '2025-08-12 06:30:31', '2025-08-12 06:30:31');

-- Volcando estructura para tabla point_pos.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.jobs: ~20 rows (aproximadamente)
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
	(1, 'default', '{"uuid":"fdf1c38d-b8ce-4c6a-abc4-70e7e6f60ebb","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:23:\\"ingjerson2014@gmail.com\\";}"}}', 0, NULL, 1752009550, 1752009550),
	(2, 'default', '{"uuid":"07d2075a-a89b-461f-951d-8bf67e1f427a","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:23:\\"ingjerson2014@gmail.com\\";}"}}', 0, NULL, 1752009585, 1752009585),
	(3, 'default', '{"uuid":"d353648a-74f7-4bfd-adbc-d40c02e86cb5","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:23:\\"ingjerson2014@gmail.com\\";}"}}', 0, NULL, 1752009634, 1752009634),
	(4, 'default', '{"uuid":"c894060a-79f3-4e1f-923b-77be76348ecd","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752009837, 1752009837),
	(5, 'default', '{"uuid":"0c0dad3b-0ad0-4c64-81a3-ebcd6fb38440","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752010097, 1752010097),
	(6, 'default', '{"uuid":"bfd2cd85-6914-4264-ab33-b646dd57a167","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752010221, 1752010221),
	(7, 'default', '{"uuid":"54644563-4671-4177-8772-894f0926936e","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752011111, 1752011111),
	(8, 'default', '{"uuid":"21050e04-5860-446e-ad6c-23b8a60ddb7d","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752011147, 1752011147),
	(9, 'default', '{"uuid":"194ca01c-c667-446e-bd62-0bdbcd3e1721","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752022645, 1752022645),
	(10, 'default', '{"uuid":"37b3a0c2-6181-4e82-adff-626088e8126e","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752022995, 1752022995),
	(11, 'default', '{"uuid":"166bbd76-f5b1-47b2-b84b-5ffb9f3aa73a","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752023127, 1752023127),
	(12, 'default', '{"uuid":"f5ce4fb2-fd11-42ca-9851-505cd1224517","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752024186, 1752024186),
	(13, 'default', '{"uuid":"f71be198-55ae-4b58-beb1-e2aa453a5f5f","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752024332, 1752024332),
	(14, 'default', '{"uuid":"49f3584c-f38e-49b0-8a29-00980d3c4610","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752024626, 1752024626),
	(15, 'default', '{"uuid":"8bf98ac8-4137-40db-829b-cec8904bf325","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752024738, 1752024738),
	(16, 'default', '{"uuid":"8a3e4602-4a3f-4892-9ba3-e4ada5ea9f96","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752024835, 1752024835),
	(17, 'default', '{"uuid":"4f32c946-3a0b-47fd-b6bf-890ed4e26c3d","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752025898, 1752025898),
	(18, 'default', '{"uuid":"a34d5127-029f-4f5b-b991-ff71b364438f","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752026189, 1752026189),
	(19, 'default', '{"uuid":"6b08e459-b067-4bcd-a527-b02e99205f19","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752027045, 1752027045),
	(20, 'default', '{"uuid":"2504d221-ea95-469c-8378-c915b2199ce5","displayName":"App\\\\Jobs\\\\CreateBackupJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\CreateBackupJob","command":"O:24:\\"App\\\\Jobs\\\\CreateBackupJob\\":1:{s:20:\\"\\u0000*\\u0000notificationEmail\\";s:17:\\"admin@example.com\\";}"}}', 0, NULL, 1752027117, 1752027117);

-- Volcando estructura para tabla point_pos.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.job_batches: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.measures
CREATE TABLE IF NOT EXISTS `measures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(250) DEFAULT NULL,
  `measure_name` varchar(250) DEFAULT NULL,
  `abbreviation` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='medidas';

-- Volcando datos para la tabla point_pos.measures: ~6 rows (aproximadamente)
INSERT INTO `measures` (`id`, `code`, `measure_name`, `abbreviation`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, '94', 'UNIDAD', 'UN', NULL, '2024-12-06 20:49:42', '2024-12-06 20:49:42'),
	(2, 'KGM', 'KILOGRAMO', 'KG', NULL, '2024-12-07 18:52:18', '2025-06-06 22:32:28'),
	(5, 'MTR', 'Metro', 'MT', NULL, '2025-05-29 20:56:52', '2025-06-06 22:32:55'),
	(6, 'GLL', 'Miligramo', 'ML', NULL, '2025-05-29 20:57:18', '2025-06-06 22:33:15'),
	(7, 'CMT', 'Centimetro', 'CM', NULL, '2025-06-06 22:37:44', '2025-06-06 22:37:44'),
	(8, 'LIB', 'Libra', 'LB', NULL, '2025-08-12 06:11:57', '2025-08-12 06:11:57');

-- Volcando estructura para tabla point_pos.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.migrations: ~4 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2024_01_01_000000_add_indexes_to_inventory_tables', 2);

-- Volcando estructura para tabla point_pos.movement_categories
CREATE TABLE IF NOT EXISTS `movement_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `movement_type` enum('Ingreso','Egreso','Transferencia','Ajuste') NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Categorías de movimientos de caja';

-- Volcando datos para la tabla point_pos.movement_categories: ~9 rows (aproximadamente)
INSERT INTO `movement_categories` (`id`, `name`, `description`, `movement_type`, `is_active`, `company_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Ventas en Efectivo', 'Ventas realizadas en efectivo', 'Ingreso', 1, 1, 1, '2025-03-27 11:47:39', '2025-03-27 11:47:39'),
	(2, 'Pagos a Proveedores', 'Pagos realizados a proveedores', 'Egreso', 1, 1, 1, '2025-03-27 11:47:39', '2025-03-27 11:47:39'),
	(3, 'Gastos de Oficina', 'Gastos relacionados con la oficina', 'Egreso', 1, 1, 1, '2025-03-27 11:47:39', '2025-03-27 11:47:39'),
	(4, 'Transferencia a Sucursal A', 'Transferencia de efectivo a la sucursal A', 'Transferencia', 1, 1, 1, '2025-03-27 11:47:39', '2025-03-27 11:47:39'),
	(5, 'Ajuste por Arqueo', 'Ajuste realizado por diferencias en el arqueo de caja', 'Ajuste', 1, 1, 1, '2025-03-27 11:47:39', '2025-03-27 11:47:39'),
	(6, 'Ventas con Tarjeta', 'Ventas realizadas con tarjeta de crédito/débito', 'Ingreso', 1, 1, 1, '2025-03-27 11:47:39', '2025-03-27 11:47:39'),
	(7, 'Nómina', 'Pagos de nómina a empleados', 'Egreso', 1, 1, 1, '2025-03-27 11:47:39', '2025-03-27 11:47:39'),
	(8, 'Ingreso CXC', 'Ingreso por pago de clientes', 'Ingreso', 1, 1, 1, '2025-03-28 11:13:04', '2025-03-28 11:13:04'),
	(9, 'Apertura Caja', 'Apertura Caja', 'Ingreso', 1, 1, 1, '2025-04-03 15:55:26', '2025-04-03 15:55:28');

-- Volcando estructura para tabla point_pos.note_concepts
CREATE TABLE IF NOT EXISTS `note_concepts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `note_type` enum('credit','debit','both') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_code` (`code`),
  KEY `idx_note_type` (`note_type`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Conceptos DIAN para notas de crédito y débito';

-- Volcando datos para la tabla point_pos.note_concepts: ~7 rows (aproximadamente)
INSERT INTO `note_concepts` (`id`, `code`, `name`, `description`, `note_type`, `is_active`, `company_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, '1', 'Devolución de parte de los bienes', 'Devolución parcial o total de mercancías', 'credit', 1, 1, 1, '2025-07-03 14:59:36', '2025-07-03 15:07:18'),
	(2, '2', 'Anulación de factura', 'Anulación total de la factura original', 'credit', 1, 1, 1, '2025-07-03 14:59:36', '2025-07-03 15:07:21'),
	(3, '3', 'Rebaja o descuento', 'Descuento otorgado posterior a la facturación', 'credit', 1, 1, 1, '2025-07-03 14:59:36', '2025-07-03 15:07:23'),
	(4, '4', 'Ajuste de precio', 'Corrección en el precio facturado', 'credit', 1, 1, 1, '2025-07-03 14:59:36', '2025-07-03 15:07:26'),
	(5, '5', 'Otros conceptos', 'Otros conceptos de notas de crédito', 'credit', 1, 1, 1, '2025-07-03 14:59:36', '2025-07-03 15:07:27'),
	(15, '6', 'Intereses', 'Intereses por mora en el pago', 'debit', 1, 1, 1, '2025-07-03 15:04:26', '2025-07-03 15:07:31'),
	(16, '7', 'Gastos por cobrar', 'Gastos adicionales a cobrar', 'debit', 1, 1, 1, '2025-07-03 15:08:13', '2025-07-03 15:08:33');

-- Volcando estructura para tabla point_pos.opportunities
CREATE TABLE IF NOT EXISTS `opportunities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `third_id` int(11) DEFAULT NULL COMMENT 'persona(tercero)',
  `contact_name` varchar(500) DEFAULT NULL,
  `contact_email` varchar(500) DEFAULT NULL,
  `contact_phone` varchar(500) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL COMMENT 'de donde proviene ',
  `stage_id` int(11) DEFAULT NULL COMMENT 'etapa de la oportunidad',
  `estimated_value` double(15,2) DEFAULT 0.00,
  `probability` decimal(5,2) DEFAULT 0.00,
  `estimated_closing_date` date DEFAULT NULL,
  `closing_date` date DEFAULT NULL,
  `reason_lost` text DEFAULT NULL,
  `responsible_user_id` int(11) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `status` enum('Open','Won','Lost','Cancelled') DEFAULT 'Open',
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.opportunities: ~2 rows (aproximadamente)
INSERT INTO `opportunities` (`id`, `name`, `description`, `third_id`, `contact_name`, `contact_email`, `contact_phone`, `source_id`, `stage_id`, `estimated_value`, `probability`, `estimated_closing_date`, `closing_date`, `reason_lost`, `responsible_user_id`, `priority_id`, `status`, `company_id`, `created_by`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'JDSYSTEMAS', 'oportunidad de pruebas', 14, 'Pruebas', 'pruebas@gmail.com', '654656465', 1, 1, 100000.00, 5.00, '2025-10-16', NULL, NULL, 1, NULL, 'Open', 1, 1, 0, '2025-10-14 03:54:24', '2025-10-14 03:54:24'),
	(2, 'Intermedia', 'otra oportunidad', 16, 'otro', 'otro@gmail.com', '8998', 1, 1, 45000.00, 2.00, '2025-10-23', NULL, NULL, 1, NULL, 'Open', 1, 1, 0, '2025-10-16 07:47:40', '2025-10-16 07:47:40');

-- Volcando estructura para tabla point_pos.opportunity_priorities
CREATE TABLE IF NOT EXISTS `opportunity_priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.opportunity_priorities: ~4 rows (aproximadamente)
INSERT INTO `opportunity_priorities` (`id`, `name`, `color`, `description`, `is_delete`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
	(1, 'Baja', '#0b07ed', 'Prioridad alta', 0, 1, 1, '2025-10-11 23:24:38', '2025-10-12 04:55:33'),
	(2, 'Media', '#a41919', 'Prioridad Media', 0, 1, 1, '2025-10-11 23:25:02', '2025-10-12 04:56:05'),
	(3, 'Alta', '#dab707', 'Prioridad alta', 0, 1, 1, '2025-10-11 23:25:27', '2025-10-12 04:56:17'),
	(4, 'Critica', '#fb0404', 'Prioridad critica', 0, 1, 1, '2025-10-11 23:25:50', '2025-10-12 04:56:27');

-- Volcando estructura para tabla point_pos.opportunity_stages
CREATE TABLE IF NOT EXISTS `opportunity_stages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `closing_percentage` decimal(12,2) DEFAULT 0.00,
  `colour` varchar(50) DEFAULT NULL,
  `is_closing_stage` tinyint(1) DEFAULT 0,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='etapas oportunidad';

-- Volcando datos para la tabla point_pos.opportunity_stages: ~2 rows (aproximadamente)
INSERT INTO `opportunity_stages` (`id`, `name`, `description`, `order`, `closing_percentage`, `colour`, `is_closing_stage`, `company_id`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Prospecto', 'Cliente potencial identificado', 1, 10.00, '#007bff', 0, 1, 1, 1, 0, '2025-09-23 06:20:20', '2025-09-23 06:20:20'),
	(2, 'Contacto Inicial', 'Primer contacto realizado', 2, 20.00, '#47b116', 0, 1, 1, 1, 0, '2025-09-23 06:26:25', '2025-10-12 05:08:36');

-- Volcando estructura para tabla point_pos.opportunity_states
CREATE TABLE IF NOT EXISTS `opportunity_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.opportunity_states: ~4 rows (aproximadamente)
INSERT INTO `opportunity_states` (`id`, `name`, `description`, `is_delete`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
	(1, 'Abierta', 'estado abierto', 0, 1, 1, '2025-10-12 21:45:51', '2025-10-13 02:50:00'),
	(2, 'Ganada', 'etapa  con exito', 0, 1, 1, '2025-10-13 20:29:56', '2025-10-13 20:29:56'),
	(3, 'Perdida', 'etapa con daños no tubo exito', 0, 1, 1, '2025-10-13 20:30:25', '2025-10-13 20:30:25'),
	(4, 'Cancelada', 'el proceso se cancela por  algun motivo', 0, 1, NULL, '2025-10-13 20:30:45', '2025-10-13 20:30:45');

-- Volcando estructura para tabla point_pos.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la venta',
  `voucher_type_id` int(11) NOT NULL COMMENT 'Tipo de comprobante (Factura electrónica: 01, Nota crédito: 91, Nota débito: 92)',
  `customer_id` int(11) NOT NULL COMMENT 'ID del cliente',
  `quotation_id` int(11) DEFAULT NULL COMMENT 'ID de la cotización relacionada',
  `created_by` int(11) DEFAULT NULL COMMENT 'ID del usuario que creó la venta',
  `cude` varchar(100) DEFAULT NULL COMMENT 'Código Único de Documento Electrónico (CUDE) según DIAN',
  `prefix` varchar(4) NOT NULL COMMENT 'Prefijo autorizado por la DIAN',
  `invoice_number` varchar(50) NOT NULL COMMENT 'Número de factura consecutivo según DIAN',
  `issue_date` datetime NOT NULL COMMENT 'Fecha y hora de emisión del documento',
  `payment_due_date` date DEFAULT NULL COMMENT 'Fecha de vencimiento del pago (para crédito)',
  `delivery_date` date DEFAULT NULL COMMENT 'Fecha de entrega de bienes/servicios',
  `state_type_id` int(11) NOT NULL COMMENT '1: Registrado, 2: Enviado a DIAN, 3: Aceptado, 4: Rechazado, 5: Anulado',
  `payment_status_id` int(11) DEFAULT 1 COMMENT '1: Pendiente, 2: Parcial, 3: Pagado',
  `delivery_status` enum('pending','in_transit','delivered','cancelled') DEFAULT 'pending' COMMENT 'Estado de entrega',
  `currency_id` int(11) NOT NULL DEFAULT 1 COMMENT '1: COP, 2: USD, etc. Referencia a tabla currencies',
  `exchange_rate` decimal(15,6) NOT NULL DEFAULT 1.000000 COMMENT 'Tasa de cambio si la moneda no es COP',
  `taxable_amount` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Base gravable (19% IVA)',
  `tax_exempt_amount` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Valor exento de IVA',
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total impuestos (IVA)',
  `additional_charges` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Cargos adicionales (fletes, etc)',
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Descuentos globales',
  `total` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total factura',
  `payment_form_id` int(11) NOT NULL COMMENT '1: Contado, 2: Crédito',
  `payment_method_id` int(11) DEFAULT NULL COMMENT '10: Efectivo, 20: Tarjeta, etc.',
  `payment_terms` varchar(255) DEFAULT NULL COMMENT 'Plazos si es crédito',
  `electronic_status` enum('pending','accepted','rejected','cancelled') NOT NULL DEFAULT 'pending' COMMENT 'Estado documento electrónico',
  `electronic_errors` text DEFAULT NULL COMMENT 'Errores reportados por la DIAN',
  `electronic_response` text DEFAULT NULL COMMENT 'Respuesta completa de la DIAN',
  `electronic_pdf_url` varchar(255) DEFAULT NULL COMMENT 'URL del PDF de la factura electrónica',
  `electronic_xml_url` varchar(255) DEFAULT NULL COMMENT 'URL del XML firmado',
  `electronic_issue_date` datetime DEFAULT NULL COMMENT 'Fecha de aceptación por la DIAN',
  `shipping_method` varchar(100) DEFAULT NULL COMMENT 'Método de envío',
  `shipping_address` text DEFAULT NULL COMMENT 'Dirección de entrega',
  `shipping_cost` decimal(15,2) DEFAULT 0.00 COMMENT 'Costo de envío',
  `company_id` int(11) NOT NULL COMMENT 'ID de la empresa emisora',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si la venta está anulada/eliminada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de anulación/eliminación',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_orders_number` (`company_id`,`prefix`,`invoice_number`) COMMENT 'Número de factura debe ser único por empresa',
  KEY `idx_orders_customer` (`customer_id`),
  KEY `idx_orders_company` (`company_id`),
  KEY `idx_orders_voucher_type` (`voucher_type_id`),
  KEY `idx_orders_electronic` (`electronic_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla de órdenes ajustada a la normatividad colombiana (Resolución 042 de 2020 DIAN)';

-- Volcando datos para la tabla point_pos.orders: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `discount` decimal(15,2) DEFAULT 0.00,
  `tax_id` int(11) DEFAULT NULL,
  `tax_rate` decimal(15,2) DEFAULT NULL,
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `is_taxed` tinyint(1) DEFAULT 0,
  `is_exonerated` tinyint(1) DEFAULT 0,
  `is_unaffected` tinyint(1) DEFAULT 0,
  `observations` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='detalle ventas';

-- Volcando datos para la tabla point_pos.order_details: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.order_status
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.order_status: ~11 rows (aproximadamente)
INSERT INTO `order_status` (`id`, `name`, `description`, `created_by`, `company_id`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Borrador', 'La orden de compra ha sido creada pero aún no ha sido enviada ni aprobada. Puede estar en proceso de edición o revisión.', 1, 1, 0, '2025-03-14 04:20:15', '2025-03-14 04:20:15'),
	(2, 'Enviada', 'La orden de compra ha sido enviada para su aprobación, pero aún no ha sido confirmada', NULL, NULL, 0, '2025-03-14 04:21:46', '2025-03-14 04:21:46'),
	(3, 'Aprobada', 'La orden de compra ha sido revisada y aprobada por las personas o departamentos correspondientes. Está lista para ser enviada al proveedor.', NULL, NULL, 0, '2025-03-14 04:22:09', '2025-03-14 04:22:09'),
	(4, 'Enviada al Proveedor', 'La orden de compra ha sido enviada al proveedor para su procesamiento.', NULL, NULL, 0, '2025-03-14 04:22:32', '2025-03-14 04:22:32'),
	(5, 'En Proceso', 'El proveedor ha aceptado la orden y está en proceso de preparación o fabricación de los productos solicitados.', NULL, NULL, 0, '2025-03-14 04:35:04', '2025-03-14 04:35:04'),
	(6, 'Parcialmente Recibida', 'Se ha recibido una parte de los productos o servicios solicitados en la orden de compra, pero no la totalidad.', NULL, NULL, 0, '2025-03-14 04:35:40', '2025-03-14 04:35:40'),
	(7, 'Recibida', 'Todos los productos o servicios solicitados en la orden de compra han sido recibidos.', NULL, NULL, 0, '2025-03-14 04:36:04', '2025-03-14 04:36:04'),
	(8, 'Facturada', 'El proveedor ha enviado la factura correspondiente a la orden de compra', NULL, NULL, 0, '2025-03-14 04:36:33', '2025-03-14 04:36:33'),
	(9, 'Cancelada', 'La orden de compra ha sido cancelada antes de su finalización. Esto puede ocurrir por diversas razones, como cambios en los requisitos o errores en la orden.', NULL, NULL, 0, '2025-03-14 04:36:59', '2025-03-14 04:36:59'),
	(10, 'Rechazada', 'La orden de compra no fue aprobada y ha sido rechazada, generalmente debido a errores, falta de presupuesto o cambios en las necesidades.', NULL, NULL, 0, '2025-03-14 04:37:23', '2025-03-14 04:37:23'),
	(11, 'En Espera', 'La orden de compra está en espera de alguna acción, como la aprobación de un presupuesto o la disponibilidad de stock.', NULL, NULL, 0, '2025-03-14 04:37:46', '2025-03-14 04:37:46');

-- Volcando estructura para tabla point_pos.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.payments_purchases
CREATE TABLE IF NOT EXISTS `payments_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_payable_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `payment_amount` decimal(20,6) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='pagos de la factura';

-- Volcando datos para la tabla point_pos.payments_purchases: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.payments_sales
CREATE TABLE IF NOT EXISTS `payments_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_receivable_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `payment_amount` decimal(20,6) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='pagos de la factura';

-- Volcando datos para la tabla point_pos.payments_sales: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.payment_method
CREATE TABLE IF NOT EXISTS `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='forma de pagos';

-- Volcando datos para la tabla point_pos.payment_method: ~7 rows (aproximadamente)
INSERT INTO `payment_method` (`id`, `code`, `name`, `days`, `created_by`, `company_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, '01', 'Efectivo', 0, 1, 1, 0, 0, '2025-02-13 03:04:02', '2025-03-12 05:59:31'),
	(2, '2', 'Anticipado', 0, 1, 1, 0, 0, '2025-02-13 03:07:31', '2025-02-13 03:07:31'),
	(3, '25', 'Crédito 15 Días', 15, 1, 1, 0, 0, '2025-02-13 03:47:33', '2025-02-13 19:29:02'),
	(5, '25', 'Crédito 30 Días', 30, 1, 1, 0, 0, '2025-02-13 03:48:30', '2025-02-13 19:29:33'),
	(7, '5', 'Crédito 60 Dias', 60, 1, 1, 0, 1, '2025-02-15 00:54:47', '2025-02-15 00:55:03'),
	(8, '6', 'Transferencia', 0, 1, 1, 0, 0, '2025-02-15 00:55:44', '2025-02-15 00:55:44'),
	(9, '07', 'Chueque', 0, 1, 1, 0, 0, '2025-03-12 05:53:04', '2025-03-12 05:53:04');

-- Volcando estructura para tabla point_pos.payment_statuses
CREATE TABLE IF NOT EXISTS `payment_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Nombre del estado de pago',
  `description` varchar(255) DEFAULT NULL COMMENT 'Descripción del estado de pago',
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Estados de pago';

-- Volcando datos para la tabla point_pos.payment_statuses: ~3 rows (aproximadamente)
INSERT INTO `payment_statuses` (`id`, `name`, `description`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'pending', 'Pago Pendiente', 1, 0, 0, '2025-03-03 16:25:24', '2025-03-03 16:29:25'),
	(2, 'paid', 'Pago Completado', 1, 0, 0, '2025-03-03 16:25:43', '2025-03-03 16:29:28'),
	(3, 'partial', 'PAGO PARCIAL', 1, 0, 0, '2025-03-03 16:26:56', '2025-03-03 16:29:31');

-- Volcando estructura para tabla point_pos.payment_type
CREATE TABLE IF NOT EXISTS `payment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='formas de pago';

-- Volcando datos para la tabla point_pos.payment_type: ~3 rows (aproximadamente)
INSERT INTO `payment_type` (`id`, `payment_type`, `description`, `status`, `is_delete`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
	(1, 'Contado', 'contado para facturas', 0, 0, 1, 1, '2025-03-03 01:24:28', '2025-03-03 01:24:29'),
	(2, 'Credito', 'credito', 0, 0, 1, 1, NULL, NULL),
	(3, 'Credi Contado', 'credito en cuotas', 0, 0, 1, 1, NULL, NULL);

-- Volcando estructura para tabla point_pos.persons
CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_third_id` int(11) DEFAULT NULL,
  `identification_type_id` int(11) DEFAULT NULL,
  `identification_number` varchar(50) DEFAULT NULL,
  `dv` varchar(50) DEFAULT NULL COMMENT 'digito de verificacion',
  `company_name` varchar(250) DEFAULT NULL,
  `name_trade` varchar(250) DEFAULT NULL COMMENT 'nombre comercial',
  `first_name` varchar(250) DEFAULT NULL,
  `second_name` varchar(250) DEFAULT NULL,
  `last_name` varchar(250) DEFAULT NULL,
  `second_last_name` varchar(250) DEFAULT NULL,
  `type_person_id` int(11) DEFAULT NULL COMMENT 'persona juricia , persona natural',
  `type_regimen_id` int(11) DEFAULT NULL COMMENT 'responsable de iva y no responsalbe',
  `type_liability_id` int(11) DEFAULT NULL,
  `activity_economic` varchar(200) DEFAULT NULL,
  `ciiu_code` varchar(200) DEFAULT NULL,
  `great_taxpayer` tinyint(1) DEFAULT 0 COMMENT 'Gran contribuyente',
  `self_withholder` tinyint(1) DEFAULT 0 COMMENT 'Autorretenedor',
  `ica_activity` varchar(50) DEFAULT NULL COMMENT 'Código actividad ICA',
  `ica_rate` decimal(5,4) DEFAULT NULL COMMENT 'Tarifa ICA',
  `commercial_registry` varchar(50) DEFAULT NULL,
  `registration_date` date DEFAULT NULL COMMENT 'Fecha matrícula mercantil',
  `country_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `avatar_url` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='terceros';

-- Volcando datos para la tabla point_pos.persons: ~29 rows (aproximadamente)
INSERT INTO `persons` (`id`, `type_third_id`, `identification_type_id`, `identification_number`, `dv`, `company_name`, `name_trade`, `first_name`, `second_name`, `last_name`, `second_last_name`, `type_person_id`, `type_regimen_id`, `type_liability_id`, `activity_economic`, `ciiu_code`, `great_taxpayer`, `self_withholder`, `ica_activity`, `ica_rate`, `commercial_registry`, `registration_date`, `country_id`, `department_id`, `city_id`, `address`, `phone`, `email`, `avatar_url`, `created_by`, `company_id`, `status`, `is_delete`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(10, 1, 1, '1047378361', NULL, NULL, NULL, 'CLIENTE DE PRUEBAS', NULL, 'DE PRUEBAS', NULL, 1, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'BARRIO CENT4O', '213213213', 'karen025@gmail.com', NULL, 1, 1, 0, 0, '2025-02-19 19:35:18', '2025-05-30 18:48:36', '2025-05-30 18:48:36'),
	(11, 2, 3, '10473783645', NULL, 'PROVEEDOR DE MOSTRAR', NULL, 'Jamez', NULL, NULL, NULL, 1, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 3, 'BARRIO CENTrO', '32056666', 'elizabth023@gmail.com', NULL, 1, 1, 0, 0, '2025-02-20 02:32:25', '2025-05-30 21:19:27', NULL),
	(12, 2, 3, '1257800000', NULL, 'TEST TEST', NULL, 'TEST', NULL, 'TEST', NULL, 1, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'Purisima', '32056666', 'unitecltd@gmail.com', NULL, 1, 1, 0, 0, '2025-03-03 22:02:29', '2025-03-03 22:02:29', NULL),
	(13, 2, 3, '14788888', NULL, 'MI EMPRESA', NULL, 'MI EMPRESA', NULL, 'MI EMPRESA', NULL, 1, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 3, 'EL CENTRO', '65465465', 'miempresa@gmail.com', NULL, 1, 1, 0, 0, '2025-03-03 22:11:52', '2025-03-03 22:11:52', NULL),
	(14, 1, 1, '1025362222', NULL, NULL, NULL, 'Jerson', 'Daniel', NULL, NULL, 1, 1, 1, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'jorge@gmail.com', '3256001222', 'jorge@gmail.com', NULL, 1, 1, 0, 0, '2025-03-21 21:06:34', '2025-03-21 21:06:34', NULL),
	(15, 4, 1, '258522222', NULL, NULL, NULL, 'JUAN', NULL, 'BALDEZ', NULL, 1, 1, 1, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'san jacinto', '36580000', 'juanvaldez@gmail.com', NULL, 1, 1, 0, 0, '2025-03-21 21:11:42', '2025-03-21 21:11:42', NULL),
	(16, 1, 1, '222222222222', NULL, NULL, NULL, 'CONSUMIDOR', NULL, 'FINAL', NULL, 1, 1, 1, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'NO TIENE DIRECCION', '0000000001', 'besasam327@binafex.com', NULL, 1, 1, 1, 0, '2025-03-26 19:41:42', '2025-05-30 17:24:26', NULL),
	(19, 1, 1, '25875555', NULL, 'diana', NULL, 'Diana', NULL, 'Jimenez', NULL, 1, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'EL CARMEN DE BOLIVAR', '13123232', 'dianana@gmail.com', NULL, 4, 1, 0, 0, '2025-05-30 18:34:47', '2025-05-30 18:49:07', '2025-05-30 18:49:07'),
	(20, 1, 1, '1201478888', NULL, 'PROVEEDOR DE MOSTRAR test', NULL, 'eliminame EDITANDO', NULL, 'Hernandez', NULL, 1, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'El Carmen de Bolivar', '30214554555', 'test01@gmail.com', NULL, 1, 1, 0, 0, '2025-05-30 21:09:32', '2025-05-30 21:09:32', NULL),
	(21, 2, 3, '8001568892', NULL, 'DISTRIBUIDORA KIRAMAR S A S XXXXXXXX XXXXXXX', NULL, NULL, NULL, NULL, NULL, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'kr43g calle 24', '302566666666', 'karimar@gmail.com', NULL, 1, 1, 0, 0, '2025-06-02 17:26:39', '2025-06-02 17:26:39', NULL),
	(22, 2, 3, '8901011760', NULL, 'MEICO S.A.S', NULL, 'Wilson Arrieta', NULL, NULL, NULL, 1, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'CALLE30 #15-276', '30122222522', 'meico@gmail.com', NULL, 1, 1, 0, 0, '2025-06-02 17:30:13', '2025-06-02 17:30:13', NULL),
	(23, 2, 3, '8909000982', NULL, 'LANDERS SAS', NULL, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'CR 53 #30-27 MEDELLIN', '3014587777', 'facturacion@landers.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:32:13', '2025-06-02 17:32:13', NULL),
	(24, 2, 3, '8001568893', NULL, 'KIRAMAR SAS', NULL, 'Amelia', NULL, 'Nieto', NULL, 1, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'dig..51 #31-120 soledad atlantico', '3113239975', 'facturacion@kiramar.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:34:29', '2025-06-02 17:34:29', NULL),
	(25, 2, 3, '9012466946', NULL, 'Argos representaciones sas', NULL, 'Tomás', NULL, 'Hernandez', NULL, 1, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'KM 4 PLT RICA SAN JERONIMO', '3176590160', 'facturacion@ARGOS.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:36:28', '2025-06-02 17:36:28', NULL),
	(26, 2, 3, '90136513600', NULL, 'TOOLS DISTRIBUCIONES JS SAS', NULL, NULL, NULL, NULL, NULL, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'TV 54#21B 50BG 5', '6521268', 'facturacion@tools.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:38:39', '2025-06-02 17:38:39', NULL),
	(27, 2, 3, '8909009431', NULL, 'CORBETA SAS', NULL, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'TV 54#21B 50BG 5', '3426456', 'facturacion@corbeta.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:40:06', '2025-06-02 17:40:06', NULL),
	(28, 2, 3, '901148822', NULL, 'COMERCIALIZA SAS', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 2, 3, 'CALLE 68B #68-73 BARRANQUILLA', '6053694584', 'facturacion@COMERCIALIZA.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:42:21', '2025-06-02 17:42:21', NULL),
	(29, 2, 3, '9010083278', NULL, 'FABRIPOR', NULL, NULL, NULL, NULL, NULL, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'KM 45 VIA CIENEGA DE ORO', '3152116655', 'facturacion@FABRIPOR.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:47:19', '2025-06-02 17:47:19', NULL),
	(30, 2, 3, '90113369273', NULL, 'FOAMTECK SAS', NULL, NULL, NULL, NULL, NULL, 1, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'CALLE 70# 7R BIS 107', '4359914', 'facturacion@FOAMTECK.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:49:45', '2025-06-02 17:49:45', NULL),
	(31, 2, 3, '9010972714', NULL, 'SORPLAST SAS', NULL, NULL, NULL, NULL, NULL, 2, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'CALLE 32# 41-139 ITAGUI', '3006545773', 'facturacion@SORPLAST.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:57:05', '2025-06-02 17:57:05', NULL),
	(32, 2, 1, '35962891', NULL, 'TALLER FAMILIAR', NULL, NULL, NULL, NULL, NULL, 2, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 2, 3, 'CR 40 #32-28 BARRANQUILLA', '30125477777', 'facturacion@TALLERFAMILIAR.com.co', NULL, 1, 1, 0, 0, '2025-06-02 17:59:59', '2025-06-02 17:59:59', NULL),
	(33, 2, 3, '805014351', NULL, 'PLASTI CAUCHO', NULL, NULL, NULL, NULL, NULL, 2, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'CR 35 #13-55 VALLE DEL CAUCA', '4898999', 'recepcionfacturadeventa@plasticaucho.com', NULL, 1, 1, 0, 0, '2025-06-02 18:06:54', '2025-06-02 18:06:54', NULL),
	(34, 2, 3, '8909225861', NULL, 'TEXT COMERCIAL', NULL, NULL, NULL, NULL, NULL, 2, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 2, 3, 'KM 5 VIA GALAPAGO BARRANQUILLA', NULL, 'facturacion@TEXTCOMERCIAL.com.co', NULL, 1, 1, 0, 0, '2025-06-02 18:08:26', '2025-06-02 18:08:26', NULL),
	(35, 2, 3, '9003341322', NULL, 'PLASDECPOR SAS', NULL, NULL, NULL, NULL, NULL, 2, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'CL 37 # 1B MONTERIA', '7842812', 'info@plasdecor.com.co', NULL, 1, 1, 0, 0, '2025-06-02 18:10:52', '2025-06-02 18:10:52', NULL),
	(36, 1, 1, '1052080150', '1', NULL, NULL, 'Anderson', NULL, 'Cohen Luna', NULL, 1, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'EL CARMEN', '32014555551', 'annderson@gmail.com', NULL, 1, 1, 0, 0, '2025-06-02 18:14:51', '2025-07-09 07:15:25', NULL),
	(37, 2, 3, '14782222478', '2', 'EMPRESA PROVEEDOR', 'PROVEEDOR DE PRUEBAS', 'PROVEEDOR DE PRUEBAS', NULL, 'PROVEEDOR DE PRUEBAS', NULL, 1, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'EL CARMEN DE BOLIVAR', '3014778888', 'proveedor@gmail.com', NULL, 1, 1, 0, 0, '2025-09-18 00:16:35', '2025-09-18 00:16:35', NULL),
	(38, 1, 1, '120578888', '1', NULL, NULL, 'Daniela', NULL, 'Martinez', NULL, 1, 1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 1, 'EL CARMEN DE BOLIVAR', '3013230867', 'daniela@gmail.com', NULL, 1, NULL, 0, 0, '2025-11-11 04:19:45', '2025-11-11 04:19:45', NULL),
	(39, 1, 1, '4575587444', '2', NULL, NULL, 'Melany', NULL, 'Arroyo', NULL, 1, 2, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 46, 1, 2, 'centro amurallado', '16656545494', 'melany@gmail.com', NULL, 1, NULL, 0, 0, '2025-11-11 04:27:12', '2025-11-11 04:27:12', NULL),
	(40, 1, 1, '14782222477', '2', NULL, NULL, 'Karen', NULL, 'Hernandez', NULL, 1, 2, 2, NULL, NULL, 0, 0, '1522', 2.0000, '10245', '2025-12-11', 46, 1, 1, 'EL CARMEN DE BOLIVAR', '3017580397', 'karen_test@gmail.com', NULL, 1, NULL, 0, 0, '2025-12-15 00:34:52', '2025-12-15 00:34:52', NULL);

-- Volcando estructura para tabla point_pos.product_color
CREATE TABLE IF NOT EXISTS `product_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.product_color: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.puc_accounts
CREATE TABLE IF NOT EXISTS `puc_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_code` varchar(10) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `parent_code` varchar(10) DEFAULT NULL,
  `account_type` enum('ASSETS','LIABILITIES','EQUITY','INCOME','EXPENSES','COST') NOT NULL,
  `nature` enum('DEBIT','CREDIT') NOT NULL,
  `third_party_handling` tinyint(1) DEFAULT 0,
  `cost_center_handling` tinyint(1) DEFAULT 0,
  `accept_movement` tinyint(1) DEFAULT 1,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_code` (`account_code`),
  KEY `idx_parent_code` (`parent_code`),
  KEY `idx_account_type` (`account_type`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.puc_accounts: ~47 rows (aproximadamente)
INSERT INTO `puc_accounts` (`id`, `account_code`, `account_name`, `level`, `parent_code`, `account_type`, `nature`, `third_party_handling`, `cost_center_handling`, `accept_movement`, `company_id`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
	(1, '1', 'ACTIVO', 1, NULL, 'ASSETS', 'DEBIT', 0, 0, 0, 1, 1, 1, '2025-08-14 21:22:21', '2025-08-14 21:22:38'),
	(2, '11', 'DISPONIBLE', 2, '1', 'ASSETS', 'DEBIT', 0, 0, 0, 1, 1, 1, '2025-08-15 02:41:40', '2025-08-14 21:44:50'),
	(3, '1105', 'CAJA', 3, '1', 'ASSETS', 'DEBIT', 0, 0, 0, 1, 1, 1, '2025-08-15 02:42:45', '2025-08-14 21:44:54'),
	(4, '110505', 'CAJA  GENERAL', 4, '1105', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 02:50:23', '2025-08-15 02:50:23'),
	(5, '110510', 'CAJA MENOR', 4, '1105', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 02:52:35', '2025-08-15 02:52:35'),
	(6, '110515', 'MONEDA NACIONAL', 4, '1105', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 02:53:37', '2025-08-15 02:53:37'),
	(7, '1110', 'BANCO', 3, '1', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:03:42', '2025-08-15 03:03:42'),
	(8, '111005', 'MONEDA NACIONAL', 4, '1110', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:05:27', '2025-08-15 03:05:27'),
	(9, '1120', 'Cuentas de ahorro', 3, '11', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:13:58', '2025-08-15 03:13:58'),
	(10, '112005', 'BANCOS', 4, '11', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:15:05', '2025-08-15 03:15:05'),
	(11, '112010', 'Corporaciones de ahorro y vivienda', 4, '1', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:15:57', '2025-08-15 03:15:57'),
	(12, '112015', 'Organismos cooperativos financieros', 4, '11', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:16:49', '2025-08-15 03:16:49'),
	(13, '12', 'INVERSIONES', 2, NULL, 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:18:57', '2025-08-15 03:18:57'),
	(14, '1205', 'ACCIONES', 4, '12', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:20:39', '2025-08-15 03:20:39'),
	(15, '120520', 'Industria manufacturera', 4, '12', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:21:42', '2025-08-15 03:21:42'),
	(16, '1299', 'PROVISIONES', 3, '12', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:22:20', '2025-08-15 03:22:20'),
	(17, '129905', 'ACCIONES', 4, '1299', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:22:48', '2025-08-15 03:22:48'),
	(18, '13', 'DEUDORES', 2, NULL, 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:24:03', '2025-08-15 03:24:03'),
	(19, '1305', 'CLIENTES', 4, '13', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:30:30', '2025-08-15 03:30:30'),
	(20, '130505', 'NACIONALES', 4, '13', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:33:41', '2025-08-15 03:33:41'),
	(21, '130510', 'DE EXTERIOR', 4, '13', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-08-15 03:34:17', '2025-08-15 03:34:17'),
	(22, '1325', 'Cuentas por cobrar a socios y accionistas', 3, '13', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-26 23:53:31', '2025-10-26 23:53:31'),
	(23, '132505', 'A socios', 4, '13', 'ASSETS', 'DEBIT', 0, 0, 1, 1, 1, 1, '2025-10-26 23:55:10', '2025-10-26 23:55:10'),
	(24, '132510', 'A accionistas', 4, '13', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-26 23:56:43', '2025-10-26 23:56:43'),
	(25, '1330', 'Anticipos y avances', 3, '13', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:23:34', '2025-10-27 02:23:34'),
	(26, '133005', 'A proveedores', 4, '1330', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:24:38', '2025-10-27 02:24:38'),
	(27, '133015', 'A trabajadores', 4, '1330', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:25:36', '2025-10-27 02:25:36'),
	(28, '1355', 'Anticipo impuestos y contribuciones o saldos favor', 3, '13', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:26:44', '2025-10-27 02:26:44'),
	(29, '135515', 'Retención en la fuente', 4, '1355', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:27:26', '2025-10-27 02:27:26'),
	(30, '135517', 'Impuesto a las ventas retenido', 4, '1355', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:28:08', '2025-10-27 02:28:08'),
	(31, '135518', 'Impuesto de industria y comercio retenido', 4, '1355', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:28:50', '2025-10-27 02:28:50'),
	(32, '135595', 'Otros', 4, '1355', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:29:21', '2025-10-27 02:29:21'),
	(33, '1365', 'Cuentas por cobrar a trabajadores', 4, '13', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:40:01', '2025-10-27 02:40:01'),
	(34, '136505', 'Vivienda', 4, '1355', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:44:53', '2025-10-27 02:44:53'),
	(35, '136510', 'Vehiculos', 4, '1355', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:45:29', '2025-10-27 02:45:29'),
	(36, '136515', 'Educacion', 4, '1355', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:46:21', '2025-10-27 02:46:21'),
	(37, '136525', 'Calamidad domestica', 4, '1355', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:48:17', '2025-10-27 02:48:17'),
	(38, '1380', 'Deudores Varios', 3, '13', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-27 02:50:19', '2025-10-27 02:50:19'),
	(39, '138020', 'Cuentas por cobrar de terceros', 4, '1380', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-28 06:10:00', '2025-10-28 06:10:00'),
	(40, '1390', 'Deudas de difícil cobro', 3, '13', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-28 06:10:44', '2025-10-28 06:10:44'),
	(41, '139001', 'Deudas de difícil cobro', 1, '1390', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-28 06:11:41', '2025-10-28 06:11:41'),
	(42, '1399', 'Provisiones', 3, '13', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-28 06:12:14', '2025-10-28 06:12:14'),
	(43, '139910', 'Cuentas corrientes comerciales', 4, '1399', 'ASSETS', 'DEBIT', 1, 0, 1, 1, 1, 1, '2025-10-28 06:13:29', '2025-10-28 06:13:29'),
	(44, '14', 'Inventarios', 2, '1', 'ASSETS', 'DEBIT', 0, 1, 1, 1, 1, 1, '2025-10-28 06:14:39', '2025-10-28 06:14:39'),
	(45, '1405', 'Materias primas', 3, '14', 'ASSETS', 'DEBIT', 0, 1, 1, 1, 1, 1, '2025-10-28 06:16:11', '2025-10-28 06:16:11'),
	(46, '140501', 'Materias primas', 4, '1405', 'ASSETS', 'DEBIT', 0, 1, 1, 1, 1, 1, '2025-10-28 06:16:39', '2025-10-28 06:16:39'),
	(47, '1435', 'Mercancías no fabricadas por la empresa', 3, '14', 'ASSETS', 'DEBIT', 0, 1, 1, 1, 1, 1, '2025-10-28 06:17:56', '2025-10-28 06:17:56');

-- Volcando estructura para tabla point_pos.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_type_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `invoice_no` char(50) DEFAULT NULL,
  `state_type_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `payment_form_id` int(11) DEFAULT NULL,
  `date_of_issue` date DEFAULT NULL COMMENT 'Fecha de emisión del documento',
  `date_of_due` date DEFAULT NULL COMMENT 'Fecha de vencimiento del pago',
  `time_of_issue` time DEFAULT NULL COMMENT 'Hora de emisión del documento',
  `series` char(50) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL COMMENT 'monedas',
  `payment_method_id` int(11) DEFAULT NULL COMMENT 'metodos de pago',
  `purchase_order_id` int(11) DEFAULT NULL,
  `total_subtotal` decimal(10,2) DEFAULT NULL,
  `total_tax` decimal(10,2) DEFAULT NULL COMMENT 'total impuestos',
  `total_discount` decimal(10,2) DEFAULT NULL,
  `total_purchase` decimal(10,2) DEFAULT NULL COMMENT 'Total compra',
  `total_prepayment` decimal(10,2) DEFAULT NULL,
  `total_charge` decimal(10,2) DEFAULT NULL,
  `total_taxed` decimal(10,2) DEFAULT NULL,
  `total_unaffected` decimal(10,2) DEFAULT NULL,
  `total_exonerated` decimal(10,2) DEFAULT NULL,
  `cufe` varchar(500) DEFAULT NULL,
  `payment_status_id` int(11) DEFAULT NULL,
  `electronic_document_status` enum('pending','accepted','rejected') DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `currency_id` (`currency_id`),
  KEY `payment_method_type_id` (`payment_method_id`) USING BTREE,
  KEY `document_type_id` (`voucher_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='compras';

-- Volcando datos para la tabla point_pos.purchases: ~2 rows (aproximadamente)
INSERT INTO `purchases` (`id`, `voucher_type_id`, `supplier_id`, `created_by`, `invoice_no`, `state_type_id`, `warehouse_id`, `payment_form_id`, `date_of_issue`, `date_of_due`, `time_of_issue`, `series`, `number`, `currency_id`, `payment_method_id`, `purchase_order_id`, `total_subtotal`, `total_tax`, `total_discount`, `total_purchase`, `total_prepayment`, `total_charge`, `total_taxed`, `total_unaffected`, `total_exonerated`, `cufe`, `payment_status_id`, `electronic_document_status`, `observations`, `company_id`, `is_delete`, `created_at`, `updated_at`) VALUES
	(53, 1, 11, 1, '5212233', 1, 1, 1, '2025-12-01', '2025-12-01', '01:09:37', 'FC', 145222, 170, 1, NULL, 56000.00, 10640.00, 0.00, 66640.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-12-01 06:09:37', '2025-12-01 06:09:37'),
	(54, 3, 12, 1, '1452333', 1, 1, 1, '2025-12-09', '2025-12-09', '01:14:13', 'FC', 145227, 170, 1, NULL, 58000.00, 11020.00, 0.00, 69020.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-12-09 06:14:13', '2025-12-09 06:14:13');

-- Volcando estructura para tabla point_pos.purchase_items
CREATE TABLE IF NOT EXISTS `purchase_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `cost_price` decimal(12,2) DEFAULT NULL,
  `discount_percent` decimal(12,2) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.purchase_items: ~2 rows (aproximadamente)
INSERT INTO `purchase_items` (`id`, `purchase_id`, `item_id`, `quantity`, `cost_price`, `discount_percent`, `created_by`, `created_at`, `updated_at`) VALUES
	(35, 53, 21, 2, 28000.00, 0.00, NULL, '2025-12-01 06:09:37', '2025-12-01 06:09:37'),
	(36, 54, 23, 1, 58000.00, 0.00, NULL, '2025-12-09 06:14:13', '2025-12-09 06:14:13');

-- Volcando estructura para tabla point_pos.purchase_orders
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `status_order_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `prefix` varchar(250) DEFAULT 'OC',
  `currency_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `expected_date` date DEFAULT NULL,
  `time_of_issue` date DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT 0.00,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `total_prepayment` decimal(10,2) DEFAULT 0.00,
  `total_charge` decimal(10,2) DEFAULT 0.00,
  `total_discount` decimal(10,2) DEFAULT 0.00,
  `total_exportation` decimal(10,2) DEFAULT 0.00,
  `total_free` decimal(10,2) DEFAULT 0.00,
  `total_taxed` decimal(10,2) DEFAULT 0.00,
  `total_unaffected` decimal(10,2) DEFAULT 0.00,
  `total_exonerated` decimal(10,2) DEFAULT 0.00,
  `total_igv` decimal(10,2) DEFAULT 0.00,
  `total_base_isc` decimal(10,2) DEFAULT 0.00,
  `total_isc` decimal(10,2) DEFAULT 0.00,
  `total_base_other_taxes` decimal(10,2) DEFAULT 0.00,
  `total_other_taxes` decimal(10,2) DEFAULT 0.00,
  `total_taxes` decimal(10,2) DEFAULT 0.00,
  `total_value` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `filename` varchar(255) DEFAULT NULL,
  `upload_filename` varchar(255) DEFAULT NULL,
  `purchase_quotation_id` int(11) DEFAULT NULL,
  `payment_method_type_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ordenes de compra a proveedor';

-- Volcando datos para la tabla point_pos.purchase_orders: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.purchase_order_item
CREATE TABLE IF NOT EXISTS `purchase_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `tax_rate` decimal(10,2) DEFAULT 0.00,
  `tax_amount` decimal(10,2) DEFAULT 0.00,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.purchase_order_item: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.quotations
CREATE TABLE IF NOT EXISTS `quotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `state_type_id` int(11) DEFAULT NULL,
  `prefix` char(10) DEFAULT 'COT',
  `number` varchar(50) DEFAULT NULL,
  `date_of_issue` datetime DEFAULT NULL,
  `date_of_expiration` date DEFAULT NULL,
  `validity_days` smallint(6) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `payment_conditions` varchar(500) DEFAULT NULL,
  `payment_form_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `exchange_rate` decimal(15,2) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL,
  `total_discount` decimal(15,2) DEFAULT NULL,
  `total_tax` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `withholding_tax` decimal(15,2) DEFAULT NULL,
  `ica_tax` decimal(15,2) DEFAULT NULL,
  `iva_tax` decimal(15,2) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `status_quotation_id` int(11) DEFAULT NULL,
  `converted_to_invoice` tinyint(1) DEFAULT 0,
  `sale_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='cotizaciones';

-- Volcando datos para la tabla point_pos.quotations: ~1 rows (aproximadamente)
INSERT INTO `quotations` (`id`, `voucher_type_id`, `user_id`, `state_type_id`, `prefix`, `number`, `date_of_issue`, `date_of_expiration`, `validity_days`, `customer_id`, `warehouse_id`, `payment_conditions`, `payment_form_id`, `currency_id`, `payment_method_id`, `exchange_rate`, `subtotal`, `total_discount`, `total_tax`, `total`, `withholding_tax`, `ica_tax`, `iva_tax`, `notes`, `approved_by`, `approval_date`, `status_quotation_id`, `converted_to_invoice`, `sale_id`, `company_id`, `is_delete`, `created_at`, `updated_at`) VALUES
	(8, 12, 1, NULL, NULL, '000008', '2025-07-09 00:00:00', '2025-07-09', 15, 36, 1, NULL, 1, 170, 1, NULL, 460000.00, 0.00, 87400.00, 547400.00, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, 1, 0, '2025-07-09 18:32:54', '2025-07-17 03:01:26');

-- Volcando estructura para tabla point_pos.quotation_items
CREATE TABLE IF NOT EXISTS `quotation_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quotation_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `unit_type_id` int(10) unsigned NOT NULL,
  `tax_id` int(10) unsigned DEFAULT NULL,
  `total_tax` decimal(18,2) NOT NULL,
  `subtotal` decimal(18,2) NOT NULL,
  `discount` decimal(18,2) NOT NULL,
  `quantity` decimal(12,4) NOT NULL,
  `unit_price` decimal(16,6) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.quotation_items: ~1 rows (aproximadamente)
INSERT INTO `quotation_items` (`id`, `quotation_id`, `item_id`, `company_id`, `unit_type_id`, `tax_id`, `total_tax`, `subtotal`, `discount`, `quantity`, `unit_price`, `total`, `created_at`, `updated_at`) VALUES
	(7, 8, 21, 1, 1, 5, 87400.00, 460000.00, 0.00, 10.0000, 46000.000000, 460000.00, '2025-07-09 18:32:54', '2025-07-09 18:32:54');

-- Volcando estructura para tabla point_pos.quotation_status_history
CREATE TABLE IF NOT EXISTS `quotation_status_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quotation_id` int(10) unsigned NOT NULL,
  `status_id` char(2) NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.quotation_status_history: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.receipt_types
CREATE TABLE IF NOT EXISTS `receipt_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `prefix` varchar(5) DEFAULT NULL,
  `current_sequential` int(11) DEFAULT 0,
  `modify_third_parties` tinyint(1) DEFAULT 0,
  `modify_inventories` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.receipt_types: ~6 rows (aproximadamente)
INSERT INTO `receipt_types` (`id`, `code`, `name`, `prefix`, `current_sequential`, `modify_third_parties`, `modify_inventories`, `status`, `company_id`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'FV', 'Factura Venta', 'FV', 1, 1, 1, 1, 1, 1, '2025-10-26 21:58:12', '2025-10-27 00:53:23'),
	(2, 'FC', 'Factura de compra', 'FC', 2, 1, 1, 1, 1, 1, '2025-10-27 06:07:08', '2025-10-27 01:09:00'),
	(3, 'NC', 'Nota Crédito', 'NC', 3, 1, 1, 1, 1, 1, '2025-10-27 06:10:44', '2025-10-27 06:10:44'),
	(4, 'CZ', 'Cotizacion', 'COT', 4, 1, 0, 1, 1, 1, '2025-10-27 06:11:32', '2025-10-27 06:11:32'),
	(5, 'RC', 'Recibo de caja', 'FC', 5, 1, 0, 1, 1, 1, '2025-10-27 06:16:08', '2025-10-27 06:16:08'),
	(6, 'NCC', 'Nota Crédito Compra', 'NCC', 6, 1, 1, 1, 1, 1, '2025-10-27 06:26:31', '2025-10-27 06:26:31');

-- Volcando estructura para tabla point_pos.resolutions
CREATE TABLE IF NOT EXISTS `resolutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_type_id` int(11) DEFAULT NULL COMMENT 'tipo de documento',
  `name` varchar(500) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `resolution` varchar(500) DEFAULT NULL,
  `date_resolution` date DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `consecutive_from` int(11) DEFAULT NULL,
  `consecutive_to` int(11) DEFAULT NULL,
  `current_consecutive` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_expired` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='almacen las resoluciones para facturacion electronica';

-- Volcando datos para la tabla point_pos.resolutions: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.sessions: ~3 rows (aproximadamente)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('9nay2puGvonPNlfDwtEQix2jB9MBrDF5ysWSvefV', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib05LaFBWWllvemhnM1VQb3dCV29IeUxoOHBRdHZJd2hoMmRUeUFwaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9sb2NhbGhvc3QvcHJvamVjdHMvcG9zLXBvaW50L3B1YmxpYy9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1766763919),
	('P6T0RRsVCo1LT7RUOJMmkOdFeGquHhuP7HCfmKET', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT1pNYlZoTGpnMVFrSmZ6cTU1emxreXZ2b1ZhRktYR3EzR05WNDRyNSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1OToiaHR0cDovL2xvY2FsaG9zdC9wcm9qZWN0cy9wb3MtcG9pbnQvcHVibGljL2FkbWluL3NhbGVzL2xpc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765743037),
	('Viixy33MSJr7L7qC5nP6jjM1kb6hIcSZ2XdFltcb', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOVdVMG1DSWNEZ1JFZHZGWU51T1ZOTXlLbGtYNDJtOXU4Yk9XdGN0YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly9sb2NhbGhvc3QvcHJvamVjdHMvcG9zLXBvaW50L3B1YmxpYy9hZG1pbi9pdGVtcy9saXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1765927773);

-- Volcando estructura para tabla point_pos.state_types
CREATE TABLE IF NOT EXISTS `state_types` (
  `id` char(2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `state_types_id_index` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.state_types: ~7 rows (aproximadamente)
INSERT INTO `state_types` (`id`, `description`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	('1', 'Registrado', 1, 1, 0, '2025-03-03 00:04:41', '2025-03-03 00:04:42'),
	('2', 'Enviado', 1, 1, 0, '2025-03-03 00:15:36', '2025-03-03 00:15:37'),
	('3', 'Aceptado', 1, 1, 0, '2025-03-03 00:15:56', '2025-03-03 00:15:58'),
	('4', 'Observado', 1, 1, 0, '2025-03-03 00:16:17', '2025-03-03 00:16:18'),
	('5', 'Rechazado', 1, 1, 0, '2025-03-03 00:16:42', '2025-03-03 00:16:43'),
	('6', 'Anulado', 1, 1, 0, '2025-03-03 00:17:02', '2025-03-03 00:17:03'),
	('7', 'Por Anular', 1, 1, 0, '2025-03-03 00:17:25', '2025-03-03 00:17:26');

-- Volcando estructura para tabla point_pos.status_order_details
CREATE TABLE IF NOT EXISTS `status_order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.status_order_details: ~5 rows (aproximadamente)
INSERT INTO `status_order_details` (`id`, `name`, `company_id`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Pending', 1, 1, 1, 0, '2025-06-09 21:52:39', '2025-06-09 21:52:40'),
	(2, 'Prepared', 1, 1, 1, 0, '2025-06-09 21:52:52', '2025-06-09 21:52:53'),
	(3, 'Dispatched', 1, 1, 1, 0, '2025-06-09 21:53:14', '2025-06-09 21:53:15'),
	(4, 'Invoiced', 1, 1, 1, 0, '2025-06-09 21:53:34', '2025-06-09 21:53:35'),
	(5, 'Cancelled', 1, 1, 1, 0, '2025-06-09 21:53:53', '2025-06-09 21:53:54');

-- Volcando estructura para tabla point_pos.status_quotation
CREATE TABLE IF NOT EXISTS `status_quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='estados de la cotizacion';

-- Volcando datos para la tabla point_pos.status_quotation: ~7 rows (aproximadamente)
INSERT INTO `status_quotation` (`id`, `name`, `description`, `color`, `is_active`, `is_system`, `is_delete`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
	(1, 'Borrador', 'Inicio de la cotizacion', '#fff', 1, 0, 0, 1, 1, '2025-04-02 16:17:24', '2025-04-02 16:17:25'),
	(2, 'Enviada', NULL, '#008000', 1, 0, 0, 1, 1, '2025-04-02 16:50:07', '2025-04-02 16:50:14'),
	(3, 'Aceptada', NULL, NULL, 1, 0, 0, 1, 1, '2025-04-02 16:51:38', '2025-04-02 16:51:39'),
	(4, 'Rechazada', NULL, NULL, 1, 0, 0, 1, 1, '2025-04-02 16:52:06', '2025-04-02 16:52:07'),
	(5, 'Vencida', NULL, NULL, 1, 0, 0, 1, 1, '2025-04-02 16:52:31', '2025-04-02 16:52:33'),
	(6, 'Convertida', 'convertida a factura de venta', NULL, 1, 0, 0, 1, 1, '2025-04-02 16:52:56', '2025-04-02 16:52:57'),
	(7, 'Pendiente', 'Por aprobar', NULL, 1, 0, 0, 1, 1, '2025-07-10 02:00:03', '2025-07-10 02:00:05');

-- Volcando estructura para tabla point_pos.status_transfer
CREATE TABLE IF NOT EXISTS `status_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='estado del traslado';

-- Volcando datos para la tabla point_pos.status_transfer: ~4 rows (aproximadamente)
INSERT INTO `status_transfer` (`id`, `name`, `description`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Pendiente', 'Estado creado', 1, 0, 0, '2025-02-24 16:45:36', '2025-02-24 16:45:38'),
	(2, 'En Curso', 'estado en proceso de bodegas', 1, 0, 0, '2025-02-24 16:45:56', '2025-02-24 16:45:57'),
	(3, 'Compleado', 'traslado completado entre bodegas', 1, 0, 0, '2025-02-24 16:46:24', '2025-02-24 16:46:25'),
	(4, 'Cancelado', 'traslado cancelado por algunos errors', 1, 0, 0, '2025-02-24 16:46:51', '2025-02-24 16:46:52');

-- Volcando estructura para tabla point_pos.sub_categories
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.sub_categories: ~1 rows (aproximadamente)
INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `slug`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `created_by`, `company_id`, `is_delete`, `status`, `created_at`, `updated_at`) VALUES
	(1, 3, 'Ventiladores Samuray Mejor Calidad', 'Ventiladores', 'Ventiladores excelentes', 'Ventiladores', 'Ventiladores', 'Ventiladores, Abanicos', 1, 1, 0, 1, '2025-06-19 06:40:07', '2025-06-19 07:08:58');

-- Volcando estructura para tabla point_pos.suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identification_type_id` int(11) DEFAULT NULL,
  `identification_number` varchar(50) DEFAULT NULL,
  `company_name` varchar(250) DEFAULT NULL COMMENT 'razon social',
  `contact_name` varchar(250) DEFAULT NULL,
  `contact_last_name` varchar(250) DEFAULT NULL,
  `type_person` enum('legal_entity','natural_person') DEFAULT NULL COMMENT 'persona juricia , persona natural',
  `tax_liability` enum('vat_responsible','not_liable_for_vat') DEFAULT NULL COMMENT 'responsable de iva y no responsalbe',
  `department_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='clientes o proveedores';

-- Volcando datos para la tabla point_pos.suppliers: ~3 rows (aproximadamente)
INSERT INTO `suppliers` (`id`, `identification_type_id`, `identification_number`, `company_name`, `contact_name`, `contact_last_name`, `type_person`, `tax_liability`, `department_id`, `city_id`, `address`, `phone`, `email`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
	(2, 3, '222222222222', 'CONSUMIDOR FINAL', 'CONSUMIDOR FINAL', 'PROBANDO', 'legal_entity', 'vat_responsible', 1, 1, 'KRA45', '32056666', 'consumidorfinal@gmail.com', NULL, 1, '2024-12-14 05:43:43', '2024-12-21 05:56:39'),
	(3, 3, '10245782222', 'PROVEEDOR GENERAL', 'PROVEEDOR  DE PRUEBAS', 'GENERAL', 'legal_entity', 'vat_responsible', 1, 2, 'BARRIO CENT4O', '65465465', 'proveedor@gmail.com', NULL, 0, '2024-12-16 23:46:37', '2024-12-17 21:13:32'),
	(8, 3, '10245782222', 'KAREN EMPRESA', 'CLIENTE DE PRUEBAS', 'PROBANDO', 'legal_entity', 'vat_responsible', 1, 1, 'EL CENTRO', '32056666', 'kamaheto@gmail.com', 1, 0, '2024-12-21 05:29:51', '2024-12-21 06:12:06');

-- Volcando estructura para tabla point_pos.supplier_comments
CREATE TABLE IF NOT EXISTS `supplier_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(500) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='comentarios del proveedor';

-- Volcando datos para la tabla point_pos.supplier_comments: ~1 rows (aproximadamente)
INSERT INTO `supplier_comments` (`id`, `comment`, `supplier_id`, `created_at`, `updated_at`) VALUES
	(1, 'proveedor de pruebas', 8, NULL, NULL);

-- Volcando estructura para tabla point_pos.taxes
CREATE TABLE IF NOT EXISTS `taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_type` enum('iva','inc','icui','otro') DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `tax_name` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='impuestos';

-- Volcando datos para la tabla point_pos.taxes: ~5 rows (aproximadamente)
INSERT INTO `taxes` (`id`, `tax_type`, `rate`, `tax_name`, `description`, `created_by`, `company_id`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'otro', 0, 'Ninguno', 'No tiene', 1, 1, 0, '2024-12-07 20:15:29', '2024-12-07 20:15:29'),
	(2, 'iva', 0, 'Iva Excento', 'Las actividades exentas de IVA son aquellas entregas de bienes y prestaciones de servicios que, por su naturaleza, resultan un hecho imponible y originan la obligación de aplicar el IVA, pero que la Ley dispone dejarlas al margen de este impuesto y liberar al ciudadano del pago.', 1, 1, 0, '2024-12-07 20:18:36', '2024-12-07 20:18:36'),
	(3, 'iva', 0, 'Iva Excluido', 'Excluidos: Son aquellos que por expresa disposición legal no causan el impuesto a las ventas. Exentos: Aquellos gravados a tarifa de 0%. No gravados o no sometidos: Son aquellos que no están catalogados en el régimen del impuesto sobre las ventas como: gravados, excluidos o exentos.', 1, 1, 0, '2024-12-07 20:19:26', '2024-12-07 20:19:26'),
	(4, 'iva', 5, 'IVA(5%)', 'Iva 5%', 1, 1, 0, '2024-12-07 20:20:02', '2024-12-07 20:20:02'),
	(5, 'iva', 19, 'Iva(19%)', 'En Colombia la tasa de IVA estándar es del 19 %. Se aplica a la mayoría de los bienes y servicios.', 1, 1, 0, '2024-12-07 20:20:55', '2024-12-08 02:06:20');

-- Volcando estructura para tabla point_pos.tmp_order_purchases
CREATE TABLE IF NOT EXISTS `tmp_order_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) DEFAULT NULL,
  `cost_price` decimal(20,2) DEFAULT 0.00,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `item_id` int(11) DEFAULT NULL,
  `session_id` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='tabla temporal';

-- Volcando datos para la tabla point_pos.tmp_order_purchases: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.tmp_purchases
CREATE TABLE IF NOT EXISTS `tmp_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) DEFAULT NULL,
  `cost_price` decimal(20,2) DEFAULT 0.00,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `item_id` int(11) DEFAULT NULL,
  `session_id` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='tabla temporal';

-- Volcando datos para la tabla point_pos.tmp_purchases: ~3 rows (aproximadamente)
INSERT INTO `tmp_purchases` (`id`, `quantity`, `cost_price`, `discount_percent`, `item_id`, `session_id`, `created_at`, `updated_at`) VALUES
	(79, 1, 12000.00, 0.00, 14, 'Spq0XpWi6cq1WrfEX9gw9Bl6ajV17MBbsp741toA', '2025-03-21 02:05:37', '2025-03-21 02:05:37'),
	(110, 1, 100000.00, 0.00, 9, 'GIC85QC0zwHEFi3wQJHkm5vXngvZPUVVE0CD0Spv', '2025-05-27 07:17:33', '2025-05-27 07:17:33'),
	(117, 1, 28000.00, 0.00, 21, 'HqrBupblZSNfI4SoOcqJg8YOY9yKN5cPIEJ2R4DJ', '2025-07-30 07:01:21', '2025-07-30 07:01:21');

-- Volcando estructura para tabla point_pos.transfer
CREATE TABLE IF NOT EXISTS `transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_warehouse_id` int(11) DEFAULT NULL,
  `to_warehouse_id` int(11) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status_transfer_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_delete` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='traslados entre productos';

-- Volcando datos para la tabla point_pos.transfer: ~10 rows (aproximadamente)
INSERT INTO `transfer` (`id`, `from_warehouse_id`, `to_warehouse_id`, `transfer_date`, `description`, `status_transfer_id`, `created_by`, `is_delete`, `created_at`, `updated_at`) VALUES
	(24, 1, 4, '2025-02-26', 'trasladando', 1, 1, 0, '2025-02-27 03:48:43', '2025-02-27 03:48:43'),
	(25, 1, 4, '2025-02-26', 'trasladando', 1, 1, 0, '2025-02-27 03:56:31', '2025-02-27 03:56:31'),
	(26, 1, 6, '2025-02-26', 'OTRO TRASLADADO', 1, 1, 0, '2025-02-27 04:02:17', '2025-02-27 04:02:17'),
	(27, 1, 4, '2025-02-26', 'nuevo traslado', 1, 1, 0, '2025-02-27 06:33:46', '2025-02-27 06:33:46'),
	(28, 1, 6, '2025-02-27', 'traslado de hoy', 1, 1, 0, '2025-02-27 22:25:19', '2025-02-27 22:25:19'),
	(29, 1, 4, '2025-02-27', 'otro ejemplo', 2, 1, 0, '2025-02-27 23:05:02', '2025-02-27 23:05:02'),
	(30, 1, 6, '2025-02-27', 'traslando para ver', 3, 1, 0, '2025-02-28 06:31:40', '2025-02-28 06:31:40'),
	(31, 1, 4, '2025-02-28', 'traslado de hoy', 3, 1, 0, '2025-02-28 20:42:51', '2025-02-28 20:42:51'),
	(35, 1, 4, '2025-03-16', 'mi traslado', 1, 1, 0, '2025-03-17 00:25:13', '2025-03-17 00:25:13'),
	(36, 1, 4, '2025-05-27', 'traslado', 1, 1, 0, '2025-05-28 07:31:02', '2025-05-28 07:31:02');

-- Volcando estructura para tabla point_pos.transfer_detail
CREATE TABLE IF NOT EXISTS `transfer_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='detalle traslados';

-- Volcando datos para la tabla point_pos.transfer_detail: ~16 rows (aproximadamente)
INSERT INTO `transfer_detail` (`id`, `transfer_id`, `item_id`, `quantity`, `created_at`, `updated_at`) VALUES
	(12, 24, 9, 2, '2025-02-27 03:48:43', '2025-02-27 03:48:43'),
	(13, 25, 10, 3, '2025-02-27 03:56:31', '2025-02-27 03:56:31'),
	(14, 25, 11, 2, '2025-02-27 03:56:31', '2025-02-27 03:56:31'),
	(15, 26, 9, 20, '2025-02-27 04:02:17', '2025-02-27 04:02:17'),
	(16, 26, 13, 20, '2025-02-27 04:02:17', '2025-02-27 04:02:17'),
	(17, 27, 13, 10, '2025-02-27 06:33:46', '2025-02-27 06:33:46'),
	(18, 27, 12, 5, '2025-02-27 06:33:46', '2025-02-27 06:33:46'),
	(19, 28, 11, 10, '2025-02-27 22:25:19', '2025-02-27 22:25:19'),
	(20, 28, 12, 3, '2025-02-27 22:25:19', '2025-02-27 22:25:19'),
	(21, 28, 10, 3, '2025-02-27 22:25:19', '2025-02-27 22:25:19'),
	(22, 29, 10, 1, '2025-02-27 23:05:02', '2025-02-27 23:05:02'),
	(23, 30, 9, 5, '2025-02-28 06:31:40', '2025-02-28 06:31:40'),
	(24, 30, 12, 3, '2025-02-28 06:31:40', '2025-02-28 06:31:40'),
	(25, 31, 9, 3, '2025-02-28 20:42:51', '2025-02-28 20:42:51'),
	(29, 35, 9, 2, '2025-03-17 00:25:13', '2025-03-17 00:25:13'),
	(30, 36, 9, 1, '2025-05-28 07:31:02', '2025-05-28 07:31:02');

-- Volcando estructura para tabla point_pos.types_companies
CREATE TABLE IF NOT EXISTS `types_companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `status` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='tipo de empresas';

-- Volcando datos para la tabla point_pos.types_companies: ~0 rows (aproximadamente)

-- Volcando estructura para tabla point_pos.type_movement_items
CREATE TABLE IF NOT EXISTS `type_movement_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='tipo movimientos de los items';

-- Volcando datos para la tabla point_pos.type_movement_items: ~6 rows (aproximadamente)
INSERT INTO `type_movement_items` (`id`, `name`, `description`, `is_delete`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
	(1, 'Ingreso', 'Producto Nuevo', 0, 1, 1, '2025-03-14 23:09:42', '2025-03-14 23:09:43'),
	(2, 'Compra', 'Entrada por compras', 0, 1, 1, '2025-03-16 18:18:10', '2025-03-16 18:18:10'),
	(3, 'Traslado_Salida', 'Traslado entre bodegas', 0, 1, 1, '2025-03-16 19:07:00', '2025-03-16 19:07:00'),
	(4, 'Traslado_Entrada', 'Entrada por traslado', 0, 1, 1, '2025-03-16 19:11:35', '2025-03-16 19:11:35'),
	(5, 'Ajuste_Manual', 'Ajuste de stock', 0, 1, 1, '2025-03-16 22:27:04', '2025-03-16 22:27:04'),
	(6, 'Salida_Venta', 'Saldia productos por ventas', 0, 1, 1, '2025-03-21 20:51:16', '2025-03-21 20:51:17');

-- Volcando estructura para tabla point_pos.type_obligation
CREATE TABLE IF NOT EXISTS `type_obligation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `liability_name` varchar(255) NOT NULL,
  `code` char(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.type_obligation: ~4 rows (aproximadamente)
INSERT INTO `type_obligation` (`id`, `liability_name`, `code`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Gran Contribuyente', 'O-13', 1, '2025-02-17 22:49:18', '2025-09-20 20:18:47'),
	(2, 'No Aplica- Otros', 'R-99-PN', 1, '2025-02-17 22:50:35', '2025-09-20 20:18:51'),
	(3, 'Autorretenedor', 'O-15', 1, '2025-02-17 22:51:02', '2025-09-20 20:18:59'),
	(4, 'Agente de retención IVA', 'O-23', 1, '2025-02-17 22:51:20', '2025-09-20 20:19:03');

-- Volcando estructura para tabla point_pos.type_person
CREATE TABLE IF NOT EXISTS `type_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_person` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.type_person: ~2 rows (aproximadamente)
INSERT INTO `type_person` (`id`, `type_person`, `created_by`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Persona Natural', 1, 0, 0, '2025-02-17 15:56:35', '2025-02-17 15:56:36'),
	(2, 'Persona Juridica', 1, 0, 0, '2025-02-17 15:56:48', '2025-02-17 15:56:48');

-- Volcando estructura para tabla point_pos.type_regimen
CREATE TABLE IF NOT EXISTS `type_regimen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `regimen_name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.type_regimen: ~2 rows (aproximadamente)
INSERT INTO `type_regimen` (`id`, `code`, `regimen_name`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, '1', 'Responsable de Iva', 0, 0, NULL, '2025-02-15 02:23:25', '2025-02-15 02:23:25'),
	(2, '2', 'No Responsable de Iva', 0, 0, NULL, '2025-02-15 02:26:43', '2025-02-15 02:26:43');

-- Volcando estructura para tabla point_pos.type_third
CREATE TABLE IF NOT EXISTS `type_third` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_third` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.type_third: ~4 rows (aproximadamente)
INSERT INTO `type_third` (`id`, `type_third`, `description`, `status`, `is_delete`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Cliente', 'Cliente de empresa', 0, 0, 1, '2025-02-17 00:59:35', '2025-02-17 00:59:36'),
	(2, 'Proveedor', 'Proveedor de  productos', 0, 0, 1, '2025-02-17 01:00:00', '2025-02-17 01:00:02'),
	(3, 'Empresa', 'Empresa que yo le pueda vender', 0, 0, 1, '2025-02-17 01:00:23', '2025-02-17 01:00:25'),
	(4, 'Empleado', 'empleados', 0, 0, 1, '2025-02-17 01:00:41', '2025-02-17 01:00:42');

-- Volcando estructura para tabla point_pos.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_role` tinyint(4) DEFAULT 2 COMMENT '1: admin, 2: users,3:super_admin',
  `is_delete` tinyint(4) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla point_pos.users: ~4 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `is_role`, `is_delete`, `status`, `company_id`, `created_at`, `updated_at`) VALUES
	(1, 'Jerson', 'Batista', 'ingjerson2014@gmail.com', '2024-12-02 21:37:20', '$2y$12$N6UMi3P79UUaPyC.LnALJOD3jiWZ8cAaRsrAnd6lQ74iGigPfGu7S', 'LmLQ8qUU4cloO3zqph1GyIMgmMasjLfk8ZKR8VOpIrX3PABOs8lOpISb98i5', 1, 0, 1, 1, '2024-12-02 21:37:26', '2024-12-02 21:37:27'),
	(2, 'Daniel', 'Batista', 'daniel@gmail.com', '2024-12-03 01:06:24', '$2y$12$N6UMi3P79UUaPyC.LnALJOD3jiWZ8cAaRsrAnd6lQ74iGigPfGu7S', 'dokA4zTPnuyyTzD1F9YmTCfToaHJpRAfRcz8autBW40pbEDlR5JEbccHcbfs', 2, 0, 1, 1, '2024-12-03 01:06:35', '2024-12-03 01:06:36'),
	(4, 'Alberto Eloy Conde Ferrer', NULL, 'almacenalcon1@gmail.com', '2025-05-29 19:59:50', '$2y$12$JNxOmxtk6oKR0deYcK1HL.NNXm7eX9uFlRmD.9qRf.9q0Wvrdws3O', 'a5vT6kJzv6JCe6DSmJ33hwKsKZbfw6T0XzRPVYt3PMEAaJ0PdqiE34aCQO4o', 1, 0, 1, 1, '2025-05-29 20:51:25', '2025-05-29 20:51:25'),
	(5, 'Jerson', 'Batista', 'test2024@gmail.com', NULL, '$2y$12$ugQvLt3YU6eA8ci6jjF11ebNs7PmWuEALKhZx19k0D.H1SEgpA/su', NULL, 3, 0, 1, 1, '2025-08-11 23:50:08', '2025-08-11 23:50:08');

-- Volcando estructura para tabla point_pos.voucher_types
CREATE TABLE IF NOT EXISTS `voucher_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_delete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla point_pos.voucher_types: ~12 rows (aproximadamente)
INSERT INTO `voucher_types` (`id`, `code`, `name`, `created_by`, `company_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, '1', 'Factura de Compra', 1, 1, 0, 0, '2025-02-11 06:41:26', '2025-02-11 06:41:26'),
	(2, '02', 'Factura de Venta', 1, 1, 0, 0, '2025-02-11 06:50:20', '2025-03-20 01:12:20'),
	(3, '03', 'Pago de Compras', 1, 1, 0, 0, '2025-02-21 18:17:35', '2025-02-21 18:17:35'),
	(4, '04', 'Pago de Gastos', 1, 1, 0, 0, '2025-02-21 18:17:55', '2025-02-21 18:17:55'),
	(5, '05', 'Pagos del Cliente', 1, 1, 0, 0, '2025-02-21 18:18:14', '2025-02-21 18:18:14'),
	(6, '06', 'Pagos a empleados', 1, 1, 0, 0, '2025-02-21 18:18:33', '2025-02-21 18:18:33'),
	(7, '07', 'Facturas FE', 1, 1, 0, 0, '2025-02-21 18:18:50', '2025-02-21 18:41:48'),
	(8, '08', 'Factura POS', 1, 1, 0, 0, '2025-02-21 18:30:05', '2025-02-21 18:42:02'),
	(9, '09', 'Débitos cta por pagar', 1, 1, 0, 0, '2025-02-21 18:30:54', '2025-02-21 18:30:54'),
	(10, '10', 'Crédido cta por cobrar', 1, 1, 0, 0, '2025-02-21 22:09:52', '2025-02-21 22:09:52'),
	(11, '11', 'Orden de Compra', 1, 1, 0, 0, '2025-03-17 01:34:03', '2025-03-17 01:34:03'),
	(12, '12', 'Cotizacion', 1, 1, 0, 0, '2025-04-01 02:00:12', '2025-04-01 02:00:12');

-- Volcando estructura para tabla point_pos.warehouses
CREATE TABLE IF NOT EXISTS `warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_name` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='bodegas';

-- Volcando datos para la tabla point_pos.warehouses: ~3 rows (aproximadamente)
INSERT INTO `warehouses` (`id`, `warehouse_name`, `address`, `created_by`, `updated_by`, `company_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
	(1, 'Principal', 'el carmen de bolivar', 1, NULL, 1, 1, 0, '2024-12-04 17:09:55', '2024-12-04 17:09:56'),
	(7, 'Bodega 2', 'Cartagena', 1, 1, 1, 1, 0, '2025-05-29 21:33:13', '2025-07-09 18:29:19'),
	(8, 'Eliminame', 'Eliminar', 1, NULL, 1, 1, 1, '2025-07-09 18:30:08', '2025-07-09 18:30:18');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
