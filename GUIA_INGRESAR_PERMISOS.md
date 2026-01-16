# 📋 GUÍA: INGRESAR PERMISOS POR MÓDULO

## 3 Formas de Ingresar los Permisos

---

## **OPCIÓN 1: Artisan Tinker (Recomendado)**

### Ejecutar desde terminal:
```bash
php artisan tinker
```

### Copiar y pegar el código de EJEMPLOS_PERMISOS_MODULOS.php
Todo lo que hay en ese archivo se ejecutará automáticamente.

**Ventajas:**
- ✅ Validación automática
- ✅ Evita duplicados
- ✅ Rápido y sencillo
- ✅ Sin necesidad de archivo adicional

---

## **OPCIÓN 2: Crear Seeder Personalizado**

### 1. Crear el seeder:
```bash
php artisan make:seeder CustomPermissionsSeeder
```

### 2. Copiar contenido en `database/seeders/CustomPermissionsSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class CustomPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // USUARIOS
            ['module' => 'usuarios', 'action' => 'crear', 'description' => 'Crear nuevos usuarios', 'category' => 'administración', 'is_system' => 1],
            ['module' => 'usuarios', 'action' => 'editar', 'description' => 'Editar usuarios', 'category' => 'administración', 'is_system' => 1],
            
            // INVENTARIO
            ['module' => 'inventario', 'action' => 'crear', 'description' => 'Crear productos', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'inventario', 'action' => 'ajuste', 'description' => 'Ajustes de inventario', 'category' => 'operación', 'is_system' => 1],
            
            // VENTAS
            ['module' => 'ventas', 'action' => 'crear', 'description' => 'Crear ventas', 'category' => 'operación', 'is_system' => 1],
            ['module' => 'ventas', 'action' => 'anular', 'description' => 'Anular ventas', 'category' => 'operación', 'is_system' => 0],
            
            // Agregar más...
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'module' => $permission['module'],
                    'action' => $permission['action'],
                ],
                $permission
            );
        }
    }
}
```

### 3. Ejecutar:
```bash
php artisan db:seed --class=CustomPermissionsSeeder
```

---

## **OPCIÓN 3: Interfaz Web**

### 1. Acceder a:
```
http://localhost/admin/permissions/list
```

### 2. Hacer clic en "Nuevo Permiso"

### 3. Llenar el formulario:
```
Módulo: usuarios
Acción: crear
Descripción: Crear nuevos usuarios
Categoría: administración
Marcar: ✓ Permiso de Sistema
```

### 4. Guardar

**Ventajas:**
- ✅ Sin código
- ✅ Interfaz visual
- ✅ Validación en tiempo real

**Desventajas:**
- ❌ Lento para muchos permisos
- ❌ Riesgo de errores

---

## 📊 MÓDULOS Y PERMISOS DISPONIBLES

### 1. **USUARIOS** (5 permisos)
```
usuarios > crear
usuarios > editar
usuarios > eliminar
usuarios > ver
usuarios > cambiar_contraseña
```

### 2. **TIPOS DE USUARIOS** (4 permisos)
```
tipos_usuarios > crear
tipos_usuarios > editar
tipos_usuarios > eliminar
tipos_usuarios > ver
```

### 3. **INVENTARIO** (6 permisos)
```
inventario > crear
inventario > editar
inventario > eliminar
inventario > ver
inventario > ajuste
inventario > transferencia
```

### 4. **PRODUCTOS** (5 permisos)
```
productos > crear
productos > editar
productos > eliminar
productos > ver
productos > precios
```

### 5. **CATEGORÍAS** (7 permisos)
```
categorias > crear
categorias > editar
categorias > eliminar
categorias > ver
subcategorias > crear
subcategorias > editar
subcategorias > eliminar
```

### 6. **VENTAS** (6 permisos)
```
ventas > crear
ventas > editar
ventas > eliminar
ventas > ver
ventas > anular
ventas > imprimir
```

### 7. **COMPRAS** (6 permisos)
```
compras > crear
compras > editar
compras > eliminar
compras > ver
compras > recibir
compras > pagar
```

### 8. **COTIZACIONES** (5 permisos)
```
cotizaciones > crear
cotizaciones > editar
cotizaciones > eliminar
cotizaciones > ver
cotizaciones > convertir_venta
```

### 9. **CAJA** (5 permisos)
```
caja > abrir
caja > cerrar
caja > movimientos
caja > arqueo
caja > deposito
```

### 10. **PAGOS** (4 permisos)
```
pagos > crear
pagos > editar
pagos > eliminar
pagos > ver
```

### 11. **CLIENTES** (5 permisos)
```
clientes > crear
clientes > editar
clientes > eliminar
clientes > ver
clientes > historial
```

### 12. **PROVEEDORES** (4 permisos)
```
proveedores > crear
proveedores > editar
proveedores > eliminar
proveedores > ver
```

### 13. **ALMACENES** (4 permisos)
```
almacenes > crear
almacenes > editar
almacenes > eliminar
almacenes > ver
```

### 14. **MARCAS** (4 permisos)
```
marcas > crear
marcas > editar
marcas > eliminar
marcas > ver
```

### 15. **MÉTODOS DE PAGO** (4 permisos)
```
metodos_pago > crear
metodos_pago > editar
metodos_pago > eliminar
metodos_pago > ver
```

### 16. **IMPUESTOS** (4 permisos)
```
impuestos > crear
impuestos > editar
impuestos > eliminar
impuestos > ver
```

### 17. **UNIDADES DE MEDIDA** (3 permisos)
```
unidades_medida > crear
unidades_medida > editar
unidades_medida > eliminar
```

### 18. **COLORES** (3 permisos)
```
colores > crear
colores > editar
colores > eliminar
```

### 19. **REPORTES** (6 permisos)
```
reportes > ver
reportes > exportar
reportes > impuestos
reportes > inventario
reportes > ventas
reportes > clientes
```

### 20. **CONFIGURACIÓN** (6 permisos)
```
configuración > editar
configuración > ver
compañia > editar
sucursales > crear
sucursales > editar
sucursales > eliminar
```

### 21. **OPORTUNIDADES** (4 permisos)
```
oportunidades > crear
oportunidades > editar
oportunidades > eliminar
oportunidades > ver
```

### 22. **TRANSFERENCIAS** (5 permisos)
```
transferencias > crear
transferencias > editar
transferencias > eliminar
transferencias > ver
transferencias > recibir
```

### 23. **NOTAS** (4 permisos)
```
notas > crear
notas > editar
notas > eliminar
notas > ver
```

### 24. **CUENTAS POR COBRAR** (3 permisos)
```
cuentas_cobrar > ver
cuentas_cobrar > registrar_pago
cuentas_cobrar > reportes
```

### 25. **CUENTAS POR PAGAR** (3 permisos)
```
cuentas_pagar > ver
cuentas_pagar > registrar_pago
cuentas_pagar > reportes
```

### 26. **BACKUP Y MANTENIMIENTO** (4 permisos)
```
backup > crear
backup > restaurar
backup > ver
sistema > logs
```

---

## 🎯 RECOMENDACIÓN RÁPIDA

### Si tienes prisa:
```bash
# Terminal
php artisan tinker

# Copiar y pegar el contenido de EJEMPLOS_PERMISOS_MODULOS.php
# Presionar Ctrl+D
```

### Si prefieres hacerlo paso a paso:
```bash
# Terminal
php artisan tinker

# Ejemplo: Crear permiso de usuarios
Permission::create([
    'module' => 'usuarios',
    'action' => 'crear',
    'description' => 'Crear nuevos usuarios',
    'category' => 'administración',
    'is_system' => 1
]);

# Verificar
Permission::where('module', 'usuarios')->get();
```

### Si prefieres interfaz web:
```
http://localhost/admin/permissions/list
→ Nuevo Permiso → Llenar formulario → Guardar
```

---

## 📈 ESTADÍSTICAS TOTALES

- **Total de módulos**: 26
- **Total de permisos**: 127
- **Permisos de sistema**: 28
- **Permisos personalizables**: 99
- **Categorías**: administración, operación, configuración, reporte

---

## ✅ VERIFICAR INSTALACIÓN

### Ver todos los permisos:
```php
php artisan tinker
Permission::all();
```

### Contar por categoría:
```php
Permission::select('category')
    ->selectRaw('count(*) as count')
    ->groupBy('category')
    ->get();
```

### Contar por módulo:
```php
Permission::select('module')
    ->selectRaw('count(*) as count')
    ->groupBy('module')
    ->get();
```

---

## 🛠️ PRÓXIMOS PASOS

1. ✅ Ingresar los permisos (una de las 3 opciones)
2. ⏳ Crear tabla `role_permissions` para conectar con roles
3. ⏳ Asignar permisos a roles de usuario
4. ⏳ Implementar middleware de validación
5. ⏳ Agregar directivas Blade para mostrar/ocultar elementos

---

**Archivo de referencia**: `EJEMPLOS_PERMISOS_MODULOS.php`  
**Archivo de código**: `app/Http/Controllers/PermissionExampleController.php`  
**Documentación completa**: `INSTALLATION_GUIDE.md`
