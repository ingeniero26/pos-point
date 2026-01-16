# Sistema RBAC - Role-Based Access Control (RBAC)

## Descripción General

Sistema completo de control de acceso basado en roles para la aplicación POS Point. Implementa un modelo RBAC de tres niveles:

```
Usuario → Rol → Permiso
```

## Estructura del Sistema

### 1. **Usuarios (Users)**
- Tabla: `users`
- Pueden tener múltiples roles asignados
- Heredan los permisos de sus roles asignados

### 2. **Roles (UserTypes)**
- Tabla: `user_types`
- Contienen conjuntos de permisos
- Pueden ser asignados a múltiples usuarios

### 3. **Permisos (Permissions)**
- Tabla: `permissions`
- Se organizan por módulo y acción
- Pueden ser de sistema (no editables) o personalizados

## Tablas de Pivote

### **user_roles**
Conecta usuarios con roles:
```sql
- user_id (clave foránea)
- role_id (clave foránea)
- company_id (opcional, para multi-tenencia)
- created_at (timestamp)
```
**Clave primaria compuesta:** (user_id, role_id, company_id)

### **role_permissions**
Conecta roles con permisos:
```sql
- role_id (clave foránea)
- permission_id (clave foránea)
- created_at (timestamp)
```
**Clave primaria compuesta:** (role_id, permission_id)

## Modelos

### User Model
```php
// Relaciones
public function roles() // Obtener roles del usuario
public function permissions() // Obtener permisos a través de roles

// Métodos de verificación
public function hasPermission($module, $action) // Verificar un permiso
public function hasAnyPermission(array $permissions) // Verificar si tiene algún permiso
public function hasAllPermissions(array $permissions) // Verificar si tiene todos los permisos
public function hasRole($roleId) // Verificar si tiene un rol específico
```

### UserTypes (Role) Model
```php
// Relaciones
public function users() // Obtener usuarios con este rol
public function permissions() // Obtener permisos del rol

// Métodos de gestión
public function assignPermissions(array $permissionIds) // Asignar permisos
public function syncPermissions(array $permissionIds) // Sincronizar permisos
public function getPermissionsWithDetails() // Obtener permisos agrupados
public function hasPermission($module, $action) // Verificar permiso del rol
```

### Permission Model
```php
// Relaciones
public function roles() // Obtener roles con este permiso
public function rolePermissions() // Obtener asignaciones de rol-permiso

// Métodos auxiliares
public static function getModulePermissions($module) // Permisos por módulo
public static function getModulesPermissions(array $modules) // Permisos múltiples
public function groupedByModule() // Agrupar por módulo
public static function byCategory($category) // Filtrar por categoría
```

## Controlador Principal

### UserRolePermissionController

#### Métodos de Gestión de Roles de Usuarios

**1. listUserRoles()**
- GET: `/admin/user-roles/list`
- Muestra la vista de usuarios y sus roles asignados

**2. getUsersWithRoles()**
- GET: `/user-roles/get-users`
- Retorna JSON con todos los usuarios y sus roles

**3. assignRolesToUser($userId)**
- GET: `/admin/user-roles/assign/{id}`
- Muestra el formulario para asignar roles a un usuario

**4. storeUserRoles(Request $request, $userId)**
- POST: `/user-roles/store/{id}`
- Guarda los roles asignados al usuario

**5. removeRoleFromUser($userId, $roleId)**
- DELETE: `/user-roles/{user}/role/{role}`
- Elimina un rol del usuario

**6. getUserPermissions($userId)**
- GET: `/user-roles/permissions/{userId}`
- Retorna JSON con los permisos heredados del usuario

#### Métodos de Gestión de Permisos de Roles

**7. listRolePermissions()**
- GET: `/admin/role-permissions/list`
- Muestra la vista de roles y sus permisos

**8. getRolesWithPermissions()**
- GET: `/role-permissions/get-roles`
- Retorna JSON con todos los roles y sus permisos

**9. assignPermissionsToRole($roleId)**
- GET: `/role-permissions/assign/{id}`
- Muestra el formulario para asignar permisos a un rol

**10. storeRolePermissions(Request $request, $roleId)**
- POST: `/role-permissions/store/{id}`
- Guarda los permisos asignados al rol
- **Protección:** No permite modificar roles de sistema

**11. getRolePermissions($roleId)**
- GET: `/role-permissions/role-permissions/{roleId}`
- Retorna JSON con los permisos del rol

**12. getAvailablePermissions()**
- GET: `/role-permissions/available`
- Retorna JSON con todos los permisos disponibles

#### Métodos de Dashboard y Estadísticas

**13. dashboard()**
- GET: `/admin/rbac/dashboard`
- Muestra el dashboard de RBAC con estadísticas

**14. getDashboardStats()**
- GET: `/rbac/dashboard-stats`
- Retorna JSON con estadísticas del sistema RBAC

## Vistas Disponibles

### 1. **admin/users/roles/list.blade.php**
- Lista de todos los usuarios con roles asignados
- Columnas: Nombre, Email, Compañía, Roles, Cantidad de Permisos, Estado, Acciones
- Modal para ver detalles de permisos

### 2. **admin/users/roles/assign.blade.php**
- Formulario para asignar roles a un usuario
- Muestra información del usuario (lectura)
- Checkboxes para seleccionar roles
- Visualización en tiempo real de permisos heredados
- Validación en cliente y servidor

### 3. **admin/roles/permissions/list.blade.php**
- Tabla de roles con información de permisos
- Botones para editar permisos
- Modal para ver detalles de permisos por rol

### 4. **admin/roles/permissions/assign.blade.php**
- Formulario para asignar permisos a un rol
- Checkboxes organizados por módulo
- Protección para roles de sistema
- Checkbox maestro para seleccionar todos los permisos de un módulo

### 5. **admin/rbac/dashboard.blade.php**
- Dashboard centralizado del sistema RBAC
- Estadísticas generales (usuarios, roles, permisos, módulos)
- Acciones rápidas
- Panel de usuarios sin roles
- Panel de roles sin permisos
- Gráfico de distribución de permisos
- Top usuarios y roles

## Rutas Configuradas

### Gestión de Roles de Usuarios
```php
GET    /admin/user-roles/list              // Listar usuarios y roles
GET    /user-roles/get-users               // JSON de usuarios con roles
GET    /admin/user-roles/assign/{id}       // Formulario de asignación
POST   /user-roles/store/{id}              // Guardar roles
DELETE /user-roles/{user}/role/{role}      // Eliminar rol de usuario
GET    /user-roles/permissions/{userId}    // JSON de permisos del usuario
```

### Gestión de Permisos de Roles
```php
GET    /admin/role-permissions/list        // Listar roles y permisos
GET    /role-permissions/get-roles         // JSON de roles con permisos
GET    /role-permissions/assign/{id}       // Formulario de asignación
POST   /role-permissions/store/{id}        // Guardar permisos
GET    /role-permissions/role-permissions/{roleId}  // JSON de permisos del rol
GET    /role-permissions/available         // JSON de permisos disponibles
```

### Dashboard RBAC
```php
GET    /admin/rbac/dashboard               // Dashboard RBAC
GET    /rbac/dashboard-stats               // JSON de estadísticas
```

## Ejemplos de Uso

### Verificar si un usuario tiene permiso

```php
$user = User::find(1);

// Verificar un permiso específico
if ($user->hasPermission('usuarios', 'crear')) {
    // Permitir crear usuarios
}

// Verificar si tiene alguno de los permisos
if ($user->hasAnyPermission(['usuarios.crear', 'usuarios.editar'])) {
    // Usuario tiene permisos de administración
}

// Verificar si tiene todos los permisos
if ($user->hasAllPermissions(['usuarios.crear', 'usuarios.editar', 'usuarios.eliminar'])) {
    // Usuario tiene permisos completos
}
```

### Asignar roles a un usuario

```php
$user = User::find(1);
$roleIds = [1, 2, 3]; // IDs de roles

// Crear nuevas asignaciones
foreach ($roleIds as $roleId) {
    UserRole::firstOrCreate([
        'user_id' => $user->id,
        'role_id' => $roleId,
        'company_id' => auth()->user()->company_id
    ]);
}
```

### Asignar permisos a un rol

```php
$role = UserTypes::find(1);
$permissionIds = [1, 2, 3, 4]; // IDs de permisos

$role->assignPermissions($permissionIds);
// O usar sincronización
$role->syncPermissions($permissionIds);
```

### Obtener permisos de un usuario

```php
$user = User::find(1);

// Obtener todos los permisos del usuario
$permissions = $user->permissions()->get();

// Agrupar por módulo
$permissionsByModule = $permissions->groupBy('module');

foreach ($permissionsByModule as $module => $perms) {
    echo "Módulo: $module";
    foreach ($perms as $perm) {
        echo "- {$perm->action}";
    }
}
```

## Instalación y Setup

### 1. Ejecutar Migraciones
```bash
php artisan migrate
```

### 2. Ejecutar Seeders
```bash
php artisan db:seed --class=PermissionSeeder
```

Esto crea 127 permisos predefinidos para los 26 módulos del sistema.

### 3. Asignar Permisos a Roles
Ir a: `/admin/role-permissions/list`

1. Hacer clic en editar para cada rol
2. Seleccionar los permisos deseados
3. Guardar cambios

### 4. Asignar Roles a Usuarios
Ir a: `/admin/user-roles/list`

1. Hacer clic en asignar para cada usuario
2. Seleccionar los roles deseados
3. Ver los permisos heredados en tiempo real
4. Guardar cambios

## Características de Seguridad

### Protección de Roles de Sistema
- Los roles de sistema (is_system = true) no pueden ser modificados
- El controlador retorna error 403 si se intenta modificar
- Las vistas deshabilitan controles para roles de sistema

### Validación en Cliente
- JavaScript valida antes de enviar al servidor
- Feedback visual inmediato

### Validación en Servidor
- Laravel valida todas las peticiones
- Verificación de permisos del usuario actual
- Protección CSRF en todos los formularios

### Cascada de Eliminación
- Eliminar un usuario elimina sus roles automáticamente
- Eliminar un rol elimina sus permisos automáticamente
- Previene registros huérfanos

## Estadísticas y Monitoreo

El dashboard proporciona:

1. **Contador de Usuarios** - Total de usuarios en el sistema
2. **Contador de Roles** - Roles disponibles
3. **Contador de Permisos** - Permisos totales
4. **Contador de Módulos** - Módulos del sistema
5. **Usuarios sin Roles** - Alerta de usuarios sin asignación
6. **Roles sin Permisos** - Alerta de roles vacíos
7. **Gráfico de Distribución** - Permisos por módulo
8. **Top Usuarios** - Usuarios con más roles
9. **Top Roles** - Roles más utilizados
10. **Información del Sistema** - Permisos de sistema vs. personalizados

## Troubleshooting

### Problema: Usuarios no ven sus opciones de menú
**Solución:** Verificar que tengan los roles asignados y que los roles tengan los permisos necesarios.

### Problema: Error al asignar roles
**Solución:** Verificar que el usuario actual tenga permisos de administración.

### Problema: Rol de sistema no se puede editar
**Solución:** Esto es intencional por seguridad. No se pueden editar roles de sistema.

### Problema: Permisos no se actualizan en tiempo real
**Solución:** Refrescar la página. Si persiste, verificar la consola de JavaScript para errores.

## Próximos Pasos (Opcionales)

1. **Crear Middleware de Autorización**
   - Verificar permisos en rutas protegidas
   - Lanzar excepción 403 si no autorizado

2. **Crear Directivas Blade**
   - `@permission('modulo', 'accion')`
   - `@role('nombre_rol')`

3. **Implementar Auditoría**
   - Registrar cambios en roles y permisos
   - Historial de cambios

4. **API Endpoints**
   - Endpoints públicos con token authentication
   - Scopes OAuth 2.0

## Licencia

Este módulo es parte de la aplicación POS Point y está sujeto a sus términos de licencia.
