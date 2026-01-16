<?php

/**
 * EJEMPLOS DE INGRESO DE PERMISOS POR MÓDULO
 * 
 * Basado en los modelos del sistema POS Point
 * Ejecutar en: php artisan tinker
 * O copiar en un seeder personalizado
 */

use App\Models\Permission;

// ============================================================================
// 1. MÓDULO: USUARIOS Y ADMINISTRACIÓN
// ============================================================================

$usuariosPermissions = [
    ['module' => 'usuarios', 'action' => 'crear', 'description' => 'Crear nuevos usuarios', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'usuarios', 'action' => 'editar', 'description' => 'Editar usuarios existentes', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'usuarios', 'action' => 'eliminar', 'description' => 'Eliminar usuarios', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'usuarios', 'action' => 'ver', 'description' => 'Ver listado de usuarios', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'usuarios', 'action' => 'cambiar_contraseña', 'description' => 'Cambiar contraseña de usuarios', 'category' => 'administración', 'is_system' => 0],
];

// ============================================================================
// 2. MÓDULO: TIPOS DE USUARIOS Y ROLES
// ============================================================================

$userTypesPermissions = [
    ['module' => 'tipos_usuarios', 'action' => 'crear', 'description' => 'Crear nuevos tipos de usuarios', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'tipos_usuarios', 'action' => 'editar', 'description' => 'Editar tipos de usuarios', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'tipos_usuarios', 'action' => 'eliminar', 'description' => 'Eliminar tipos de usuarios', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'tipos_usuarios', 'action' => 'ver', 'description' => 'Ver tipos de usuarios', 'category' => 'administración', 'is_system' => 1],
];

// ============================================================================
// 3. MÓDULO: INVENTARIO Y PRODUCTOS
// ============================================================================

$inventarioPermissions = [
    ['module' => 'inventario', 'action' => 'crear', 'description' => 'Crear nuevos productos', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'inventario', 'action' => 'editar', 'description' => 'Editar productos', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'inventario', 'action' => 'eliminar', 'description' => 'Eliminar productos', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'inventario', 'action' => 'ver', 'description' => 'Ver inventario', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'inventario', 'action' => 'ajuste', 'description' => 'Realizar ajustes de inventario', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'inventario', 'action' => 'transferencia', 'description' => 'Transferir productos entre almacenes', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 4. MÓDULO: PRODUCTOS Y ARTÍCULOS
// ============================================================================

$productosPermissions = [
    ['module' => 'productos', 'action' => 'crear', 'description' => 'Crear nuevos artículos/productos', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'productos', 'action' => 'editar', 'description' => 'Editar información de productos', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'productos', 'action' => 'eliminar', 'description' => 'Eliminar productos', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'productos', 'action' => 'ver', 'description' => 'Ver catálogo de productos', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'productos', 'action' => 'precios', 'description' => 'Gestionar precios de productos', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 5. MÓDULO: CATEGORÍAS Y SUBCATEGORÍAS
// ============================================================================

$categoriasPermissions = [
    ['module' => 'categorias', 'action' => 'crear', 'description' => 'Crear categorías de productos', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'categorias', 'action' => 'editar', 'description' => 'Editar categorías', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'categorias', 'action' => 'eliminar', 'description' => 'Eliminar categorías', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'categorias', 'action' => 'ver', 'description' => 'Ver categorías', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'subcategorias', 'action' => 'crear', 'description' => 'Crear subcategorías', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'subcategorias', 'action' => 'editar', 'description' => 'Editar subcategorías', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'subcategorias', 'action' => 'eliminar', 'description' => 'Eliminar subcategorías', 'category' => 'configuración', 'is_system' => 0],
];

// ============================================================================
// 6. MÓDULO: VENTAS
// ============================================================================

$ventasPermissions = [
    ['module' => 'ventas', 'action' => 'crear', 'description' => 'Crear nuevas ventas/facturas', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'ventas', 'action' => 'editar', 'description' => 'Editar ventas existentes', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'ventas', 'action' => 'eliminar', 'description' => 'Eliminar ventas/devoluciones', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'ventas', 'action' => 'ver', 'description' => 'Ver ventas y facturas', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'ventas', 'action' => 'anular', 'description' => 'Anular ventas', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'ventas', 'action' => 'imprimir', 'description' => 'Imprimir facturas', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 7. MÓDULO: COMPRAS Y ÓRDENES DE COMPRA
// ============================================================================

$comprasPermissions = [
    ['module' => 'compras', 'action' => 'crear', 'description' => 'Crear nuevas compras/órdenes de compra', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'compras', 'action' => 'editar', 'description' => 'Editar compras existentes', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'compras', 'action' => 'eliminar', 'description' => 'Eliminar compras', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'compras', 'action' => 'ver', 'description' => 'Ver compras y órdenes', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'compras', 'action' => 'recibir', 'description' => 'Recibir mercancía de compras', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'compras', 'action' => 'pagar', 'description' => 'Registrar pagos de compras', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 8. MÓDULO: COTIZACIONES Y PRESUPUESTOS
// ============================================================================

$cotizacionesPermissions = [
    ['module' => 'cotizaciones', 'action' => 'crear', 'description' => 'Crear cotizaciones', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'cotizaciones', 'action' => 'editar', 'description' => 'Editar cotizaciones', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'cotizaciones', 'action' => 'eliminar', 'description' => 'Eliminar cotizaciones', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'cotizaciones', 'action' => 'ver', 'description' => 'Ver cotizaciones', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'cotizaciones', 'action' => 'convertir_venta', 'description' => 'Convertir cotización a venta', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 9. MÓDULO: CAJA Y MOVIMIENTOS DE EFECTIVO
// ============================================================================

$cajaPermissions = [
    ['module' => 'caja', 'action' => 'abrir', 'description' => 'Abrir sesión de caja', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'caja', 'action' => 'cerrar', 'description' => 'Cerrar sesión de caja', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'caja', 'action' => 'movimientos', 'description' => 'Ver movimientos de caja', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'caja', 'action' => 'arqueo', 'description' => 'Realizar arqueo de caja', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'caja', 'action' => 'deposito', 'description' => 'Registrar depósitos bancarios', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 10. MÓDULO: PAGOS
// ============================================================================

$pagosPermissions = [
    ['module' => 'pagos', 'action' => 'crear', 'description' => 'Registrar pagos de ventas', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'pagos', 'action' => 'editar', 'description' => 'Editar pagos', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'pagos', 'action' => 'eliminar', 'description' => 'Eliminar pagos', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'pagos', 'action' => 'ver', 'description' => 'Ver pagos registrados', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 11. MÓDULO: CLIENTES
// ============================================================================

$clientesPermissions = [
    ['module' => 'clientes', 'action' => 'crear', 'description' => 'Crear nuevos clientes', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'clientes', 'action' => 'editar', 'description' => 'Editar información de clientes', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'clientes', 'action' => 'eliminar', 'description' => 'Eliminar clientes', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'clientes', 'action' => 'ver', 'description' => 'Ver listado de clientes', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'clientes', 'action' => 'historial', 'description' => 'Ver historial de compras de cliente', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 12. MÓDULO: PROVEEDORES
// ============================================================================

$proveedoresPermissions = [
    ['module' => 'proveedores', 'action' => 'crear', 'description' => 'Crear nuevos proveedores', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'proveedores', 'action' => 'editar', 'description' => 'Editar información de proveedores', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'proveedores', 'action' => 'eliminar', 'description' => 'Eliminar proveedores', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'proveedores', 'action' => 'ver', 'description' => 'Ver listado de proveedores', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 13. MÓDULO: ALMACENES
// ============================================================================

$almacenesPermissions = [
    ['module' => 'almacenes', 'action' => 'crear', 'description' => 'Crear nuevos almacenes', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'almacenes', 'action' => 'editar', 'description' => 'Editar almacenes', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'almacenes', 'action' => 'eliminar', 'description' => 'Eliminar almacenes', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'almacenes', 'action' => 'ver', 'description' => 'Ver almacenes', 'category' => 'configuración', 'is_system' => 0],
];

// ============================================================================
// 14. MÓDULO: MARCAS
// ============================================================================

$marcasPermissions = [
    ['module' => 'marcas', 'action' => 'crear', 'description' => 'Crear marcas de productos', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'marcas', 'action' => 'editar', 'description' => 'Editar marcas', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'marcas', 'action' => 'eliminar', 'description' => 'Eliminar marcas', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'marcas', 'action' => 'ver', 'description' => 'Ver marcas', 'category' => 'configuración', 'is_system' => 0],
];

// ============================================================================
// 15. MÓDULO: MÉTODOS DE PAGO
// ============================================================================

$metodosPagoPermissions = [
    ['module' => 'metodos_pago', 'action' => 'crear', 'description' => 'Crear métodos de pago', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'metodos_pago', 'action' => 'editar', 'description' => 'Editar métodos de pago', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'metodos_pago', 'action' => 'eliminar', 'description' => 'Eliminar métodos de pago', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'metodos_pago', 'action' => 'ver', 'description' => 'Ver métodos de pago', 'category' => 'configuración', 'is_system' => 0],
];

// ============================================================================
// 16. MÓDULO: IMPUESTOS
// ============================================================================

$impuestosPermissions = [
    ['module' => 'impuestos', 'action' => 'crear', 'description' => 'Crear impuestos', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'impuestos', 'action' => 'editar', 'description' => 'Editar impuestos', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'impuestos', 'action' => 'eliminar', 'description' => 'Eliminar impuestos', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'impuestos', 'action' => 'ver', 'description' => 'Ver impuestos', 'category' => 'configuración', 'is_system' => 0],
];

// ============================================================================
// 17. MÓDULO: UNIDADES DE MEDIDA
// ============================================================================

$unidadesMedidaPermissions = [
    ['module' => 'unidades_medida', 'action' => 'crear', 'description' => 'Crear unidades de medida', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'unidades_medida', 'action' => 'editar', 'description' => 'Editar unidades de medida', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'unidades_medida', 'action' => 'eliminar', 'description' => 'Eliminar unidades', 'category' => 'configuración', 'is_system' => 0],
];

// ============================================================================
// 18. MÓDULO: COLORES
// ============================================================================

$coloresPermissions = [
    ['module' => 'colores', 'action' => 'crear', 'description' => 'Crear colores de productos', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'colores', 'action' => 'editar', 'description' => 'Editar colores', 'category' => 'configuración', 'is_system' => 0],
    ['module' => 'colores', 'action' => 'eliminar', 'description' => 'Eliminar colores', 'category' => 'configuración', 'is_system' => 0],
];

// ============================================================================
// 19. MÓDULO: REPORTES
// ============================================================================

$reportesPermissions = [
    ['module' => 'reportes', 'action' => 'ver', 'description' => 'Ver reportes generales', 'category' => 'reporte', 'is_system' => 1],
    ['module' => 'reportes', 'action' => 'exportar', 'description' => 'Exportar reportes a Excel/PDF', 'category' => 'reporte', 'is_system' => 0],
    ['module' => 'reportes', 'action' => 'impuestos', 'description' => 'Ver reportes de impuestos', 'category' => 'reporte', 'is_system' => 0],
    ['module' => 'reportes', 'action' => 'inventario', 'description' => 'Ver reportes de inventario', 'category' => 'reporte', 'is_system' => 0],
    ['module' => 'reportes', 'action' => 'ventas', 'description' => 'Ver reportes de ventas', 'category' => 'reporte', 'is_system' => 0],
    ['module' => 'reportes', 'action' => 'clientes', 'description' => 'Ver reportes de clientes', 'category' => 'reporte', 'is_system' => 0],
];

// ============================================================================
// 20. MÓDULO: CONFIGURACIÓN Y COMPAÑÍA
// ============================================================================

$configuracionPermissions = [
    ['module' => 'configuración', 'action' => 'editar', 'description' => 'Editar configuración del sistema', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'configuración', 'action' => 'ver', 'description' => 'Ver configuración', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'compañia', 'action' => 'editar', 'description' => 'Editar datos de la compañía', 'category' => 'administración', 'is_system' => 0],
    ['module' => 'sucursales', 'action' => 'crear', 'description' => 'Crear sucursales', 'category' => 'administración', 'is_system' => 0],
    ['module' => 'sucursales', 'action' => 'editar', 'description' => 'Editar sucursales', 'category' => 'administración', 'is_system' => 0],
    ['module' => 'sucursales', 'action' => 'eliminar', 'description' => 'Eliminar sucursales', 'category' => 'administración', 'is_system' => 0],
];

// ============================================================================
// 21. MÓDULO: OPORTUNIDADES / SEGUIMIENTO
// ============================================================================

$oportunidadesPermissions = [
    ['module' => 'oportunidades', 'action' => 'crear', 'description' => 'Crear oportunidades de venta', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'oportunidades', 'action' => 'editar', 'description' => 'Editar oportunidades', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'oportunidades', 'action' => 'eliminar', 'description' => 'Eliminar oportunidades', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'oportunidades', 'action' => 'ver', 'description' => 'Ver oportunidades', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 22. MÓDULO: TRANSFERENCIAS DE INVENTARIO
// ============================================================================

$transferenciasPermissions = [
    ['module' => 'transferencias', 'action' => 'crear', 'description' => 'Crear transferencias entre almacenes', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'transferencias', 'action' => 'editar', 'description' => 'Editar transferencias', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'transferencias', 'action' => 'eliminar', 'description' => 'Eliminar transferencias', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'transferencias', 'action' => 'ver', 'description' => 'Ver transferencias', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'transferencias', 'action' => 'recibir', 'description' => 'Recibir mercancía transferida', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 23. MÓDULO: NOTAS DÉBITO/CRÉDITO
// ============================================================================

$notasPermissions = [
    ['module' => 'notas', 'action' => 'crear', 'description' => 'Crear notas débito/crédito', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'notas', 'action' => 'editar', 'description' => 'Editar notas', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'notas', 'action' => 'eliminar', 'description' => 'Eliminar notas', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'notas', 'action' => 'ver', 'description' => 'Ver notas emitidas', 'category' => 'operación', 'is_system' => 0],
];

// ============================================================================
// 24. MÓDULO: CUENTAS POR COBRAR
// ============================================================================

$cuentasCobranzaPermissions = [
    ['module' => 'cuentas_cobrar', 'action' => 'ver', 'description' => 'Ver cuentas por cobrar', 'category' => 'reporte', 'is_system' => 0],
    ['module' => 'cuentas_cobrar', 'action' => 'registrar_pago', 'description' => 'Registrar pagos de clientes', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'cuentas_cobrar', 'action' => 'reportes', 'description' => 'Ver reportes de cobranza', 'category' => 'reporte', 'is_system' => 0],
];

// ============================================================================
// 25. MÓDULO: CUENTAS POR PAGAR
// ============================================================================

$cuentasPagoPermissions = [
    ['module' => 'cuentas_pagar', 'action' => 'ver', 'description' => 'Ver cuentas por pagar', 'category' => 'reporte', 'is_system' => 0],
    ['module' => 'cuentas_pagar', 'action' => 'registrar_pago', 'description' => 'Registrar pagos a proveedores', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'cuentas_pagar', 'action' => 'reportes', 'description' => 'Ver reportes de pagos', 'category' => 'reporte', 'is_system' => 0],
];

// ============================================================================
// 26. MÓDULO: BACK UP Y MANTENIMIENTO
// ============================================================================

$mantenimientoPermissions = [
    ['module' => 'backup', 'action' => 'crear', 'description' => 'Crear respaldos de base de datos', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'backup', 'action' => 'restaurar', 'description' => 'Restaurar desde respaldos', 'category' => 'administración', 'is_system' => 1],
    ['module' => 'backup', 'action' => 'ver', 'description' => 'Ver respaldos realizados', 'category' => 'administración', 'is_system' => 0],
    ['module' => 'sistema', 'action' => 'logs', 'description' => 'Ver logs del sistema', 'category' => 'administración', 'is_system' => 0],
];

// ============================================================================
// COMBINAR TODOS LOS PERMISOS
// ============================================================================

$allPermissions = array_merge(
    $usuariosPermissions,
    $userTypesPermissions,
    $inventarioPermissions,
    $productosPermissions,
    $categoriasPermissions,
    $ventasPermissions,
    $comprasPermissions,
    $cotizacionesPermissions,
    $cajaPermissions,
    $pagosPermissions,
    $clientesPermissions,
    $proveedoresPermissions,
    $almacenesPermissions,
    $marcasPermissions,
    $metodosPagoPermissions,
    $impuestosPermissions,
    $unidadesMedidaPermissions,
    $coloresPermissions,
    $reportesPermissions,
    $configuracionPermissions,
    $oportunidadesPermissions,
    $transferenciasPermissions,
    $notasPermissions,
    $cuentasCobranzaPermissions,
    $cuentasPagoPermissions,
    $mantenimientoPermissions
);

// ============================================================================
// INSERTAR TODOS LOS PERMISOS
// ============================================================================

echo "Insertando " . count($allPermissions) . " permisos...\n\n";

foreach ($allPermissions as $permission) {
    try {
        Permission::firstOrCreate(
            [
                'module' => $permission['module'],
                'action' => $permission['action'],
            ],
            $permission
        );
        echo "✅ " . $permission['module'] . " > " . $permission['action'] . "\n";
    } catch (\Exception $e) {
        echo "❌ Error en {$permission['module']} > {$permission['action']}: " . $e->getMessage() . "\n";
    }
}

echo "\n✅ ¡Todos los permisos han sido insertados!\n";

// ============================================================================
// RESUMEN DE PERMISOS POR CATEGORÍA
// ============================================================================

echo "\n📊 RESUMEN:\n";
$stats = Permission::select('category')
    ->selectRaw('count(*) as count')
    ->groupBy('category')
    ->get();

foreach ($stats as $stat) {
    echo "   - {$stat->category}: {$stat->count} permisos\n";
}

echo "\n📊 RESUMEN POR MÓDULO:\n";
$moduleStats = Permission::select('module')
    ->selectRaw('count(*) as count')
    ->orderBy('module')
    ->groupBy('module')
    ->get();

foreach ($moduleStats as $stat) {
    echo "   - {$stat->module}: {$stat->count} permisos\n";
}

echo "\n✅ Total de permisos en el sistema: " . Permission::count() . "\n";
