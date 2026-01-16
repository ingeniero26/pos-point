# 📚 EJEMPLOS DETALLADOS POR MÓDULO

Aquí encontrarás ejemplos específicos y listos para copiar/pegar para cada módulo.

---

## 1️⃣ MÓDULO: USUARIOS

### HTML - Formulario Web
```html
http://localhost/admin/permissions/list
→ Nuevo Permiso
```

### PHP - Tinker
```php
php artisan tinker

Permission::create([
    'module' => 'usuarios',
    'action' => 'crear',
    'description' => 'Crear nuevos usuarios',
    'category' => 'administración',
    'is_system' => 1
]);

Permission::create([
    'module' => 'usuarios',
    'action' => 'editar',
    'description' => 'Editar usuarios existentes',
    'category' => 'administración',
    'is_system' => 1
]);

# Repetir para: eliminar, ver, cambiar_contraseña
```

### SQL
```sql
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('usuarios', 'crear', 'Crear nuevos usuarios', 'administración', 1),
('usuarios', 'editar', 'Editar usuarios existentes', 'administración', 1),
('usuarios', 'eliminar', 'Eliminar usuarios', 'administración', 1),
('usuarios', 'ver', 'Ver listado de usuarios', 'administración', 1),
('usuarios', 'cambiar_contraseña', 'Cambiar contraseña', 'administración', 0);
```

### Verificación
```php
php artisan tinker
Permission::where('module', 'usuarios')->get();
# Debe retornar 5 registros
```

---

## 2️⃣ MÓDULO: INVENTARIO

### Crear Uno a Uno
```php
php artisan tinker

$acciones = [
    'crear' => 'Crear nuevos productos',
    'editar' => 'Editar productos',
    'eliminar' => 'Eliminar productos',
    'ver' => 'Ver inventario',
    'ajuste' => 'Realizar ajustes de inventario',
    'transferencia' => 'Transferir entre almacenes'
];

foreach ($acciones as $accion => $descripcion) {
    Permission::create([
        'module' => 'inventario',
        'action' => $accion,
        'description' => $descripcion,
        'category' => 'operación',
        'is_system' => $accion === 'transferencia' ? 0 : 1
    ]);
}
```

### SQL Directo
```sql
INSERT INTO permissions (module, action, description, category, is_system) VALUES
('inventario', 'crear', 'Crear nuevos productos', 'operación', 1),
('inventario', 'editar', 'Editar productos', 'operación', 1),
('inventario', 'eliminar', 'Eliminar productos', 'operación', 1),
('inventario', 'ver', 'Ver inventario', 'operación', 1),
('inventario', 'ajuste', 'Realizar ajustes', 'operación', 1),
('inventario', 'transferencia', 'Transferencias', 'operación', 0);
```

---

## 3️⃣ MÓDULO: VENTAS

### Con Validation
```php
php artisan tinker

$ventasPermisos = [
    ['module' => 'ventas', 'action' => 'crear', 'description' => 'Crear nuevas ventas', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'ventas', 'action' => 'editar', 'description' => 'Editar ventas', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'ventas', 'action' => 'eliminar', 'description' => 'Eliminar ventas', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'ventas', 'action' => 'ver', 'description' => 'Ver ventas', 'category' => 'operación', 'is_system' => 1],
    ['module' => 'ventas', 'action' => 'anular', 'description' => 'Anular ventas', 'category' => 'operación', 'is_system' => 0],
    ['module' => 'ventas', 'action' => 'imprimir', 'description' => 'Imprimir facturas', 'category' => 'operación', 'is_system' => 0],
];

foreach ($ventasPermisos as $permiso) {
    Permission::firstOrCreate(
        ['module' => $permiso['module'], 'action' => $permiso['action']],
        $permiso
    );
    echo "✅ {$permiso['module']} > {$permiso['action']}\n";
}
```

---

## 4️⃣ MÓDULO: CLIENTES

### Crear Múltiples
```php
php artisan tinker

$modulos = [
    'clientes' => [
        'crear' => ['description' => 'Crear nuevos clientes', 'is_system' => 0],
        'editar' => ['description' => 'Editar clientes', 'is_system' => 0],
        'eliminar' => ['description' => 'Eliminar clientes', 'is_system' => 0],
        'ver' => ['description' => 'Ver clientes', 'is_system' => 0],
        'historial' => ['description' => 'Ver historial', 'is_system' => 0],
    ]
];

foreach ($modulos as $module => $acciones) {
    foreach ($acciones as $action => $data) {
        Permission::create([
            'module' => $module,
            'action' => $action,
            'description' => $data['description'],
            'category' => 'operación',
            'is_system' => $data['is_system']
        ]);
    }
}
```

---

## 5️⃣ MÓDULO: REPORTES

### Con Categorización
```php
php artisan tinker

$reportes = [
    'ver' => ['category' => 'reporte', 'is_system' => 1],
    'exportar' => ['category' => 'reporte', 'is_system' => 0],
    'impuestos' => ['category' => 'reporte', 'is_system' => 0],
    'inventario' => ['category' => 'reporte', 'is_system' => 0],
    'ventas' => ['category' => 'reporte', 'is_system' => 0],
    'clientes' => ['category' => 'reporte', 'is_system' => 0],
];

foreach ($reportes as $action => $data) {
    Permission::create([
        'module' => 'reportes',
        'action' => $action,
        'description' => 'Reporte de ' . $action,
        'category' => $data['category'],
        'is_system' => $data['is_system']
    ]);
}
```

---

## 6️⃣ MÓDULO: CONFIGURACIÓN

### Con Dependencias
```php
php artisan tinker

// Configuración general
Permission::create([
    'module' => 'configuración',
    'action' => 'editar',
    'description' => 'Editar configuración del sistema',
    'category' => 'administración',
    'is_system' => 1
]);

// Configuración de compañía
Permission::create([
    'module' => 'compañia',
    'action' => 'editar',
    'description' => 'Editar datos de compañía',
    'category' => 'administración',
    'is_system' => 0
]);

// Sucursales
$sucursal_actions = ['crear', 'editar', 'eliminar'];
foreach ($sucursal_actions as $action) {
    Permission::create([
        'module' => 'sucursales',
        'action' => $action,
        'description' => ucfirst($action) . ' sucursales',
        'category' => 'administración',
        'is_system' => 0
    ]);
}
```

---

## 🔄 CREAR TODOS LOS PERMISOS DE UNA VEZ

### Opción: Usar PermissionService

```php
php artisan tinker

use App\Services\PermissionService;

$permisos_nuevos = [
    [
        'module' => 'tu_modulo',
        'action' => 'tu_accion',
        'description' => 'Descripción',
        'category' => 'operación',
        'is_system' => 0
    ],
    // ... más permisos
];

$creados = PermissionService::createBatch($permisos_nuevos);
echo "Se crearon " . count($creados) . " permisos";
```

---

## ✅ VERIFICAR INSTALACIÓN

### Ver todos por módulo
```php
php artisan tinker

Permission::all()->groupBy('module')->map(function ($group, $module) {
    echo "$module: " . $group->count() . " permisos\n";
});
```

### Ver específico
```php
Permission::where('module', 'usuarios')->get();
```

### Contar
```php
Permission::count(); // Total
Permission::where('is_system', 1)->count(); // Sistema
Permission::where('is_system', 0)->count(); // Personalizables
```

---

## 🎯 PLANTILLA PARA TU PROPIO MÓDULO

```php
php artisan tinker

// Reemplazar valores según necesites
Permission::create([
    'module' => 'mi_modulo',           # Nombre del módulo
    'action' => 'mi_accion',            # Tipo de acción
    'description' => 'Descripción clara',  # Para qué sirve
    'category' => 'operación',          # Categoría (administración, operación, configuración, reporte)
    'is_system' => 0                    # 1=sistema (no se borra), 0=personalizable
]);
```

---

## 🚀 FLUJO COMPLETO (5 minutos)

### 1. Abre Terminal
```bash
cd c:\xampp\htdocs\projects\pos-point
php artisan tinker
```

### 2. Copiar uno de los ejemplos arriba

### 3. Pegar en terminal

### 4. Presionar Enter

### 5. Ver resultado
```php
Permission::count()  # Debe mostrar total
```

---

## 📖 ARCHIVO MASTER

Para ingresar TODOS (127 permisos):
- Archivo: `EJEMPLOS_PERMISOS_MODULOS.php`
- Copiar todo el contenido en `php artisan tinker`
- Listo en 30 segundos

---

## 💡 TIPS

### Crear y Verificar
```php
Permission::create([...]);
Permission::where('module', 'usuarios')->count();
```

### Actualizar
```php
$perm = Permission::where('module', 'usuarios')->where('action', 'crear')->first();
$perm->update(['description' => 'Nueva descripción']);
```

### Eliminar (si no es sistema)
```php
$perm = Permission::find(5);
if (!$perm->is_system) {
    $perm->delete();
}
```

---

**Referencia**: EJEMPLOS_PERMISOS_MODULOS.php  
**Guía**: GUIA_INGRESAR_PERMISOS.md  
**Script SQL**: PERMISOS_SCRIPT_SQL.sql
