# 📖 Guía de Instalación del Sistema RBAC

## Paso 1: Ejecutar Migraciones

Ejecuta las migraciones para crear las tablas en la base de datos:

```bash
php artisan migrate
```

**Qué se crea:**
- Tabla `permissions` con 127 permisos predefinidos
- Tabla `user_roles` para conectar usuarios con roles
- Tabla `role_permissions` para conectar roles con permisos

## Paso 2: Ejecutar Seeders

Siembra los permisos iniciales en la base de datos:

```bash
php artisan db:seed --class=PermissionSeeder
```

**Qué se crea:**
- 127 permisos predefinidos organizados en 26 módulos
- Permisos de sistema (no editables)
- Estructura lista para asignar a roles

## Paso 3: Configurar Rutas (YA HECHO)

Las rutas ya están configuradas en `routes/web.php`:

```php
// Usuario roles
Route::get('admin/user-roles/list', [UserRolePermissionController::class, 'listUserRoles'])->name('user-roles.list');
Route::get('admin/user-roles/assign/{id}', [UserRolePermissionController::class, 'assignRolesToUser'])->name('user-roles.assign');
// ... más rutas

// Role permissions
Route::get('admin/role-permissions/list', [UserRolePermissionController::class, 'listRolePermissions'])->name('role-permissions.list');
Route::get('role-permissions/assign/{id}', [UserRolePermissionController::class, 'assignPermissionsToRole'])->name('role-permissions.assign');
// ... más rutas

// Dashboard RBAC
Route::get('admin/rbac/dashboard', [UserRolePermissionController::class, 'dashboard'])->name('rbac.dashboard');
```

## Paso 4: Asignar Permisos a Roles

### Opción A: Por Interface Web

1. Accede a: `http://localhost/admin/role-permissions/list`
2. Verás una tabla con todos los roles del sistema
3. Haz clic en el botón "✏️ Editar" para cada rol
4. En la página de edición:
   - Verás todos los permisos organizados por módulo
   - Marca los checkboxes de los permisos que quieres asignar
   - Usa el checkbox maestro de cada módulo para seleccionar todos los permisos del módulo
   - Haz clic en "💾 Guardar Permisos"
5. Verás un mensaje de éxito

### Opción B: Por Código (Laravel Tinker)

```bash
php artisan tinker
```

```php
// Obtener un rol
$role = \App\Models\UserTypes::find(1); // ID del rol

// Obtener IDs de permisos que quieres asignar
$permissionIds = \App\Models\Permission::limit(10)->pluck('id')->toArray();

// Asignar permisos al rol
$role->assignPermissions($permissionIds);

// O sincronizar (reemplazar todos)
$role->syncPermissions($permissionIds);

// Verificar que se asignaron
$role->permissions()->count(); // Debe mostrar 10
```

### Opción C: SQL Directo

```sql
-- Insertar permisos para un rol específico
INSERT INTO role_permissions (role_id, permission_id, created_at) 
SELECT 1, id, NOW() FROM permissions 
WHERE module = 'usuarios' 
ON DUPLICATE KEY UPDATE created_at = NOW();
```

## Paso 5: Asignar Roles a Usuarios

### Opción A: Por Interface Web

1. Accede a: `http://localhost/admin/user-roles/list`
2. Verás una tabla con todos los usuarios
3. Haz clic en el botón "🔗 Asignar" en la columna "Acciones"
4. En la página de asignación:
   - Verás la información del usuario (lectura)
   - Verás todos los roles disponibles con checkboxes
   - Marca los checkboxes de los roles que quieres asignar
   - En el lado derecho, verás los permisos heredados actualizarse en tiempo real
   - Haz clic en "💾 Guardar Roles"
5. Verás un mensaje de éxito
6. Los permisos se actualizarán automáticamente

### Opción B: Por Código (Laravel Tinker)

```bash
php artisan tinker
```

```php
// Obtener un usuario
$user = \App\Models\User::find(1); // ID del usuario

// Asignar roles al usuario
$roleIds = [1, 2]; // IDs de los roles

foreach ($roleIds as $roleId) {
    \App\Models\UserRole::firstOrCreate([
        'user_id' => $user->id,
        'role_id' => $roleId,
        'company_id' => auth()->user()->company_id // Opcional
    ]);
}

// Verificar que se asignaron
$user->roles()->count(); // Debe mostrar 2

// Obtener permisos del usuario
$user->permissions()->count(); // Mostrará todos los permisos de sus roles
```

### Opción C: SQL Directo

```sql
-- Insertar roles para un usuario específico
INSERT INTO user_roles (user_id, role_id, company_id, created_at) 
VALUES 
  (1, 1, 1, NOW()),
  (1, 2, 1, NOW());
```

## Paso 6: Usar en tu Aplicación

### Verificar Permisos

```php
// En un controlador
public function createUser() {
    $user = auth()->user();
    
    // Verificar un permiso específico
    if (!$user->hasPermission('usuarios', 'crear')) {
        abort(403, 'No tienes permiso para crear usuarios');
    }
    
    // Mostrar formulario
    return view('users.create');
}
```

### En Vistas (Blade)

```blade
@if(auth()->user()->hasPermission('usuarios', 'crear'))
    <a href="/users/create" class="btn btn-primary">Crear Usuario</a>
@endif
```

### Obtener Información

```php
// Obtener todos los roles del usuario
$roles = auth()->user()->roles()->get();

// Obtener todos los permisos del usuario
$permissions = auth()->user()->permissions()->get();

// Verificar si tiene un rol específico
if (auth()->user()->hasRole(1)) {
    // Usuario es administrador
}

// Verificar múltiples permisos
if (auth()->user()->hasAnyPermission(['usuarios.crear', 'usuarios.editar'])) {
    // Usuario puede crear o editar usuarios
}
```

## Paso 7: Ver Dashboard

Accede al dashboard RBAC en:
- URL: `http://localhost/admin/rbac/dashboard`
- Nombre: `rbac.dashboard`

En el dashboard podrás ver:
- 📊 Total de usuarios
- 👥 Total de roles
- 🔑 Total de permisos
- 📦 Total de módulos
- 📈 Gráfico de distribución de permisos
- ⚠️ Usuarios sin roles asignados
- ⚠️ Roles sin permisos asignados
- 🏆 Top usuarios con más roles
- 🏆 Top roles más utilizados
- ℹ️ Información del sistema

## Paso 8: Testing (Opcional)

Ejecuta el script de testing para verificar que todo funciona:

```bash
php artisan tinker < rbac_tests.php
```

O línea por línea en tinker:

```bash
php artisan tinker
```

```php
// Verificar que existen usuarios
\App\Models\User::count(); // Debe ser > 0

// Verificar que existen permisos
\App\Models\Permission::count(); // Debe ser 127

// Verificar que existen roles
\App\Models\UserTypes::count(); // Debe ser > 0

// Verificar relaciones
$user = \App\Models\User::first();
$user->roles()->count(); // Debe mostrar roles asignados
$user->permissions()->count(); // Debe mostrar permisos heredados

// Salir
exit
```

## Paso 9: Crear Middleware (Opcional)

Si quieres proteger rutas con middleware de permisos:

```bash
php artisan make:middleware CheckPermission
```

Edita `app/Http/Middleware/CheckPermission.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission {
    public function handle(Request $request, Closure $next, $module, $action) {
        if (!auth()->user()->hasPermission($module, $action)) {
            abort(403, 'Acceso denegado');
        }
        
        return $next($request);
    }
}
```

Registra en `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    // ... middleware existentes
    'permission' => \App\Http\Middleware\CheckPermission::class,
];
```

Úsalo en rutas:

```php
Route::group(['middleware' => 'auth'], function () {
    Route::post('users/create', [UserController::class, 'store'])
        ->middleware('permission:usuarios,crear');
    
    Route::delete('users/{id}', [UserController::class, 'destroy'])
        ->middleware('permission:usuarios,eliminar');
});
```

## Paso 10: Crear Directivas Blade (Opcional)

En `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\Blade;

public function boot() {
    // Directiva para permisos
    Blade::if('permission', function ($module, $action) {
        return auth()->user()->hasPermission($module, $action);
    });
    
    // Directiva para roles
    Blade::if('role', function ($roleId) {
        return auth()->user()->hasRole($roleId);
    });
}
```

Usa en vistas:

```blade
@permission('usuarios', 'crear')
    <a href="/users/create" class="btn btn-primary">Crear Usuario</a>
@endpermission

@role(1)
    <a href="/admin/settings" class="btn btn-secondary">Configuración</a>
@endrole
```

## Troubleshooting

### Problema: "Table user_roles doesn't exist"
**Solución:** Ejecuta `php artisan migrate`

### Problema: "Table role_permissions doesn't exist"
**Solución:** Ejecuta `php artisan migrate`

### Problema: "No permissions found"
**Solución:** Ejecuta `php artisan db:seed --class=PermissionSeeder`

### Problema: "Usuario no ve el botón de crear"
**Solución:** Verifica que:
1. El usuario tiene un rol asignado: `$user->roles()->count() > 0`
2. El rol tiene el permiso asignado: `$role->permissions()->count() > 0`
3. El permiso existe: `Permission::where('module', 'usuarios')->where('action', 'crear')->exists()`

### Problema: "Error al guardar permisos"
**Solución:**
1. Verifica que no es un rol de sistema: `$role->is_system == false`
2. Verifica los IDs de permiso: `Permission::find($id) != null`
3. Verifica en console del navegador los errores JavaScript

### Problema: "Dashboard no muestra datos"
**Solución:**
1. Abre la consola de navegador (F12)
2. Verifica que no hay errores en Network
3. Verifica que `/rbac/dashboard-stats` retorna JSON válido

## Archivos Principales

| Archivo | Descripción |
|---------|-------------|
| `database/migrations/2024_01_15_000000_create_permissions_table.php` | Tabla de permisos |
| `database/migrations/2024_01_15_000001_create_user_roles_and_role_permissions_tables.php` | Tablas pivotes |
| `app/Models/User.php` | Modelo User (actualizado) |
| `app/Models/UserTypes.php` | Modelo de Roles (actualizado) |
| `app/Models/Permission.php` | Modelo de Permisos (actualizado) |
| `app/Models/UserRole.php` | Modelo Pivot Usuario-Rol |
| `app/Models/RolePermission.php` | Modelo Pivot Rol-Permiso |
| `app/Http/Controllers/UserRolePermissionController.php` | Controlador principal |
| `resources/views/admin/users/roles/list.blade.php` | Vista de usuarios |
| `resources/views/admin/users/roles/assign.blade.php` | Vista de asignación |
| `resources/views/admin/roles/permissions/list.blade.php` | Vista de roles |
| `resources/views/admin/roles/permissions/assign.blade.php` | Vista de permisos |
| `resources/views/admin/rbac/dashboard.blade.php` | Dashboard RBAC |
| `routes/web.php` | Rutas configuradas |

## Documentación Adicional

- 📖 `RBAC_SYSTEM_GUIDE.md` - Guía técnica completa
- ✨ `RBAC_IMPLEMENTATION_SUMMARY.md` - Resumen visual
- 💻 `RBAC_PRACTICAL_EXAMPLES.php` - 30 ejemplos de código
- 🧪 `rbac_tests.php` - Script de testing

## Siguientes Pasos

1. ✅ Ejecutar migraciones
2. ✅ Ejecutar seeders
3. ✅ Asignar permisos a roles
4. ✅ Asignar roles a usuarios
5. ✅ Usar en tu código
6. ⏳ Crear middleware (opcional)
7. ⏳ Crear directivas Blade (opcional)
8. ⏳ Implementar auditoría (opcional)

---

**¡Sistema RBAC listo para usar! 🚀**
