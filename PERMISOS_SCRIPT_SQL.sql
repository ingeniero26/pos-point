-- ============================================================================
-- SCRIPT SQL: INSERTAR PERMISOS DEL SISTEMA
-- ============================================================================
-- Ejecutar en: phpMyAdmin > SQL o MySQL Workbench
-- ============================================================================

-- 1. USUARIOS (5 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('usuarios', 'crear', 'Crear nuevos usuarios', 'administración', 1),
('usuarios', 'editar', 'Editar usuarios existentes', 'administración', 1),
('usuarios', 'eliminar', 'Eliminar usuarios', 'administración', 1),
('usuarios', 'ver', 'Ver listado de usuarios', 'administración', 1),
('usuarios', 'cambiar_contraseña', 'Cambiar contraseña de usuarios', 'administración', 0);

-- 2. TIPOS DE USUARIOS (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('tipos_usuarios', 'crear', 'Crear nuevos tipos de usuarios', 'administración', 1),
('tipos_usuarios', 'editar', 'Editar tipos de usuarios', 'administración', 1),
('tipos_usuarios', 'eliminar', 'Eliminar tipos de usuarios', 'administración', 1),
('tipos_usuarios', 'ver', 'Ver tipos de usuarios', 'administración', 1);

-- 3. INVENTARIO (6 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('inventario', 'crear', 'Crear nuevos productos', 'operación', 1),
('inventario', 'editar', 'Editar productos', 'operación', 1),
('inventario', 'eliminar', 'Eliminar productos', 'operación', 1),
('inventario', 'ver', 'Ver inventario', 'operación', 1),
('inventario', 'ajuste', 'Realizar ajustes de inventario', 'operación', 1),
('inventario', 'transferencia', 'Transferir productos entre almacenes', 'operación', 0);

-- 4. PRODUCTOS (5 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('productos', 'crear', 'Crear nuevos artículos/productos', 'operación', 1),
('productos', 'editar', 'Editar información de productos', 'operación', 1),
('productos', 'eliminar', 'Eliminar productos', 'operación', 1),
('productos', 'ver', 'Ver catálogo de productos', 'operación', 1),
('productos', 'precios', 'Gestionar precios de productos', 'operación', 0);

-- 5. CATEGORÍAS Y SUBCATEGORÍAS (7 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('categorias', 'crear', 'Crear categorías de productos', 'configuración', 0),
('categorias', 'editar', 'Editar categorías', 'configuración', 0),
('categorias', 'eliminar', 'Eliminar categorías', 'configuración', 0),
('categorias', 'ver', 'Ver categorías', 'configuración', 0),
('subcategorias', 'crear', 'Crear subcategorías', 'configuración', 0),
('subcategorias', 'editar', 'Editar subcategorías', 'configuración', 0),
('subcategorias', 'eliminar', 'Eliminar subcategorías', 'configuración', 0);

-- 6. VENTAS (6 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('ventas', 'crear', 'Crear nuevas ventas/facturas', 'operación', 1),
('ventas', 'editar', 'Editar ventas existentes', 'operación', 1),
('ventas', 'eliminar', 'Eliminar ventas/devoluciones', 'operación', 1),
('ventas', 'ver', 'Ver ventas y facturas', 'operación', 1),
('ventas', 'anular', 'Anular ventas', 'operación', 0),
('ventas', 'imprimir', 'Imprimir facturas', 'operación', 0);

-- 7. COMPRAS (6 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('compras', 'crear', 'Crear nuevas compras/órdenes de compra', 'operación', 1),
('compras', 'editar', 'Editar compras existentes', 'operación', 1),
('compras', 'eliminar', 'Eliminar compras', 'operación', 1),
('compras', 'ver', 'Ver compras y órdenes', 'operación', 1),
('compras', 'recibir', 'Recibir mercancía de compras', 'operación', 0),
('compras', 'pagar', 'Registrar pagos de compras', 'operación', 0);

-- 8. COTIZACIONES (5 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('cotizaciones', 'crear', 'Crear cotizaciones', 'operación', 0),
('cotizaciones', 'editar', 'Editar cotizaciones', 'operación', 0),
('cotizaciones', 'eliminar', 'Eliminar cotizaciones', 'operación', 0),
('cotizaciones', 'ver', 'Ver cotizaciones', 'operación', 0),
('cotizaciones', 'convertir_venta', 'Convertir cotización a venta', 'operación', 0);

-- 9. CAJA (5 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('caja', 'abrir', 'Abrir sesión de caja', 'operación', 1),
('caja', 'cerrar', 'Cerrar sesión de caja', 'operación', 1),
('caja', 'movimientos', 'Ver movimientos de caja', 'operación', 1),
('caja', 'arqueo', 'Realizar arqueo de caja', 'operación', 0),
('caja', 'deposito', 'Registrar depósitos bancarios', 'operación', 0);

-- 10. PAGOS (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('pagos', 'crear', 'Registrar pagos de ventas', 'operación', 0),
('pagos', 'editar', 'Editar pagos', 'operación', 0),
('pagos', 'eliminar', 'Eliminar pagos', 'operación', 0),
('pagos', 'ver', 'Ver pagos registrados', 'operación', 0);

-- 11. CLIENTES (5 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('clientes', 'crear', 'Crear nuevos clientes', 'operación', 0),
('clientes', 'editar', 'Editar información de clientes', 'operación', 0),
('clientes', 'eliminar', 'Eliminar clientes', 'operación', 0),
('clientes', 'ver', 'Ver listado de clientes', 'operación', 0),
('clientes', 'historial', 'Ver historial de compras de cliente', 'operación', 0);

-- 12. PROVEEDORES (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('proveedores', 'crear', 'Crear nuevos proveedores', 'operación', 0),
('proveedores', 'editar', 'Editar información de proveedores', 'operación', 0),
('proveedores', 'eliminar', 'Eliminar proveedores', 'operación', 0),
('proveedores', 'ver', 'Ver listado de proveedores', 'operación', 0);

-- 13. ALMACENES (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('almacenes', 'crear', 'Crear nuevos almacenes', 'configuración', 0),
('almacenes', 'editar', 'Editar almacenes', 'configuración', 0),
('almacenes', 'eliminar', 'Eliminar almacenes', 'configuración', 0),
('almacenes', 'ver', 'Ver almacenes', 'configuración', 0);

-- 14. MARCAS (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('marcas', 'crear', 'Crear marcas de productos', 'configuración', 0),
('marcas', 'editar', 'Editar marcas', 'configuración', 0),
('marcas', 'eliminar', 'Eliminar marcas', 'configuración', 0),
('marcas', 'ver', 'Ver marcas', 'configuración', 0);

-- 15. MÉTODOS DE PAGO (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('metodos_pago', 'crear', 'Crear métodos de pago', 'configuración', 0),
('metodos_pago', 'editar', 'Editar métodos de pago', 'configuración', 0),
('metodos_pago', 'eliminar', 'Eliminar métodos de pago', 'configuración', 0),
('metodos_pago', 'ver', 'Ver métodos de pago', 'configuración', 0);

-- 16. IMPUESTOS (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('impuestos', 'crear', 'Crear impuestos', 'configuración', 0),
('impuestos', 'editar', 'Editar impuestos', 'configuración', 0),
('impuestos', 'eliminar', 'Eliminar impuestos', 'configuración', 0),
('impuestos', 'ver', 'Ver impuestos', 'configuración', 0);

-- 17. UNIDADES DE MEDIDA (3 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('unidades_medida', 'crear', 'Crear unidades de medida', 'configuración', 0),
('unidades_medida', 'editar', 'Editar unidades de medida', 'configuración', 0),
('unidades_medida', 'eliminar', 'Eliminar unidades', 'configuración', 0);

-- 18. COLORES (3 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('colores', 'crear', 'Crear colores de productos', 'configuración', 0),
('colores', 'editar', 'Editar colores', 'configuración', 0),
('colores', 'eliminar', 'Eliminar colores', 'configuración', 0);

-- 19. REPORTES (6 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('reportes', 'ver', 'Ver reportes generales', 'reporte', 1),
('reportes', 'exportar', 'Exportar reportes a Excel/PDF', 'reporte', 0),
('reportes', 'impuestos', 'Ver reportes de impuestos', 'reporte', 0),
('reportes', 'inventario', 'Ver reportes de inventario', 'reporte', 0),
('reportes', 'ventas', 'Ver reportes de ventas', 'reporte', 0),
('reportes', 'clientes', 'Ver reportes de clientes', 'reporte', 0);

-- 20. CONFIGURACIÓN (6 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('configuración', 'editar', 'Editar configuración del sistema', 'administración', 1),
('configuración', 'ver', 'Ver configuración', 'administración', 1),
('compañia', 'editar', 'Editar datos de la compañía', 'administración', 0),
('sucursales', 'crear', 'Crear sucursales', 'administración', 0),
('sucursales', 'editar', 'Editar sucursales', 'administración', 0),
('sucursales', 'eliminar', 'Eliminar sucursales', 'administración', 0);

-- 21. OPORTUNIDADES (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('oportunidades', 'crear', 'Crear oportunidades de venta', 'operación', 0),
('oportunidades', 'editar', 'Editar oportunidades', 'operación', 0),
('oportunidades', 'eliminar', 'Eliminar oportunidades', 'operación', 0),
('oportunidades', 'ver', 'Ver oportunidades', 'operación', 0);

-- 22. TRANSFERENCIAS (5 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('transferencias', 'crear', 'Crear transferencias entre almacenes', 'operación', 0),
('transferencias', 'editar', 'Editar transferencias', 'operación', 0),
('transferencias', 'eliminar', 'Eliminar transferencias', 'operación', 0),
('transferencias', 'ver', 'Ver transferencias', 'operación', 0),
('transferencias', 'recibir', 'Recibir mercancía transferida', 'operación', 0);

-- 23. NOTAS DÉBITO/CRÉDITO (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('notas', 'crear', 'Crear notas débito/crédito', 'operación', 0),
('notas', 'editar', 'Editar notas', 'operación', 0),
('notas', 'eliminar', 'Eliminar notas', 'operación', 0),
('notas', 'ver', 'Ver notas emitidas', 'operación', 0);

-- 24. CUENTAS POR COBRAR (3 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('cuentas_cobrar', 'ver', 'Ver cuentas por cobrar', 'reporte', 0),
('cuentas_cobrar', 'registrar_pago', 'Registrar pagos de clientes', 'operación', 0),
('cuentas_cobrar', 'reportes', 'Ver reportes de cobranza', 'reporte', 0);

-- 25. CUENTAS POR PAGAR (3 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('cuentas_pagar', 'ver', 'Ver cuentas por pagar', 'reporte', 0),
('cuentas_pagar', 'registrar_pago', 'Registrar pagos a proveedores', 'operación', 0),
('cuentas_pagar', 'reportes', 'Ver reportes de pagos', 'reporte', 0);

-- 26. BACKUP Y MANTENIMIENTO (4 permisos)
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('backup', 'crear', 'Crear respaldos de base de datos', 'administración', 1),
('backup', 'restaurar', 'Restaurar desde respaldos', 'administración', 1),
('backup', 'ver', 'Ver respaldos realizados', 'administración', 0),
('sistema', 'logs', 'Ver logs del sistema', 'administración', 0);

-- ============================================================================
-- VERIFICACIÓN
-- ============================================================================

-- Verificar total de permisos insertados
SELECT COUNT(*) as total_permisos FROM permissions;

-- Ver permisos por categoría
SELECT category, COUNT(*) as cantidad 
FROM permissions 
GROUP BY category 
ORDER BY category;

-- Ver permisos por módulo
SELECT module, COUNT(*) as cantidad 
FROM permissions 
GROUP BY module 
ORDER BY module;

-- Ver permisos de sistema
SELECT COUNT(*) as permisos_sistema 
FROM permissions 
WHERE is_system = 1;

-- Ver permisos personalizables
SELECT COUNT(*) as permisos_personalizables 
FROM permissions 
WHERE is_system = 0;

-- ============================================================================
-- FIN DEL SCRIPT
-- ============================================================================
