# Gestión de Permisos

Esta es la funcionalidad completa para gestionar permisos en el sistema POS Point.

## Archivos Creados

### 1. Migración
- **Ruta**: `database/migrations/2024_01_15_000000_create_permissions_table.php`
- **Descripción**: Crea la tabla `permissions` con las columnas especificadas

### 2. Modelo
- **Ruta**: `app/Models/Permission.php`
- **Funcionalidades**:
  - Métodos para agrupar permisos por módulo
  - Búsqueda por categoría
  - Verificación de existencia de permisos

### 3. Controlador
- **Ruta**: `app/Http/Controllers/PermissionController.php`
- **Métodos CRUD**:
  - `list()` - Mostrar vista de listado
  - `getPermissions()` - Obtener todos los permisos (JSON)
  - `create()` - Mostrar formulario de creación
  - `store()` - Guardar nuevo permiso
  - `edit()` - Obtener datos de permiso para editar
  - `update()` - Actualizar permiso
  - `destroy()` - Eliminar permiso individual
  - `bulkDelete()` - Eliminar múltiples permisos
  - `getPermissionsGrouped()` - Obtener permisos agrupados por módulo
  - `getPermissionsByCategory()` - Obtener permisos por categoría

### 4. Vistas (Blade)
- **Lista**: `resources/views/admin/permissions/list.blade.php`
  - Tabla interactiva con filtros
  - Selección múltiple
  - Eliminación en lotes
  
- **Crear**: `resources/views/admin/permissions/create.blade.php`
  - Formulario para crear nuevo permiso
  
- **Editar**: `resources/views/admin/permissions/edit.blade.php`
  - Formulario para editar permiso existente

### 5. Seeder
- **Ruta**: `database/seeders/PermissionSeeder.php`
- **Descripción**: Carga permisos iniciales del sistema

## Instalación

### Paso 1: Ejecutar la Migración
```bash
php artisan migrate
```

### Paso 2: Ejecutar el Seeder
```bash
php artisan db:seed --class=PermissionSeeder
```

O ejecutar todos los seeders:
```bash
php artisan db:seed
```

## Rutas Disponibles

### Vistas
- `GET /admin/permissions/list` - Listado de permisos
- `GET /permissions/create` - Formulario para crear permiso

### API (JSON)
- `GET /permissions` - Obtener todos los permisos
- `POST /permissions` - Crear nuevo permiso
- `GET /permissions/{id}/edit` - Obtener datos de permiso
- `PUT /permissions/{id}` - Actualizar permiso
- `DELETE /permissions/{id}` - Eliminar permiso
- `POST /permissions/bulk-delete` - Eliminar múltiples permisos
- `GET /permissions/grouped` - Obtener permisos agrupados
- `GET /permissions/category/{category}` - Obtener por categoría

## Estructura de la Tabla

```sql
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `is_system` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_module_action` (`module`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Ejemplo de Uso

### Crear un Permiso
```php
use App\Models\Permission;

$permission = Permission::create([
    'module' => 'usuarios',
    'action' => 'crear',
    'description' => 'Crear nuevos usuarios',
    'category' => 'administración',
    'is_system' => false
]);
```

### Obtener Permisos por Módulo
```php
use App\Models\Permission;

$permissions = Permission::where('module', 'usuarios')->get();
```

### Obtener Permisos Agrupados
```php
$grouped = Permission::groupedByModule();
```

### Verificar Existencia
```php
$exists = Permission::checkPermission('usuarios', 'crear');
```

## Características

✅ **CRUD Completo**: Crear, leer, actualizar y eliminar permisos
✅ **Validación**: Unicidad de módulo + acción
✅ **Protección de Permisos del Sistema**: No se pueden eliminar permisos marcados como sistema
✅ **Eliminación en Lotes**: Seleccionar y eliminar múltiples permisos
✅ **Filtros**: Búsqueda por módulo, acción y categoría
✅ **Categorización**: Organizar permisos por categorías
✅ **API RESTful**: Endpoints JSON para integración
✅ **Seeding Inicial**: Permisos predefinidos del sistema

## Notas

- Los permisos marcados como `is_system = 1` no pueden ser eliminados
- La combinación de `module` + `action` es única en la base de datos
- El campo `category` es opcional para agrupar permisos relacionados
- Las fechas de creación y actualización se registran automáticamente
