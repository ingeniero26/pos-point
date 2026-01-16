# Instalación y Configuración del Sistema de Permisos

## 📋 Resumen de la Funcionalidad

Se ha creado un sistema completo de gestión de permisos para la aplicación POS Point que incluye:

- ✅ Modelo de datos para permisos
- ✅ Controlador con CRUD completo
- ✅ Interfaz web para administrar permisos
- ✅ API RESTful para consultas
- ✅ Seeding inicial con permisos del sistema
- ✅ Servicio de utilidades para control de acceso

---

## 🚀 Pasos de Instalación

### 1. Ejecutar Migración

```bash
cd c:\xampp\htdocs\projects\pos-point
php artisan migrate
```

**Qué hace**: Crea la tabla `permissions` en la base de datos con la siguiente estructura:
- `id`: Identificador único
- `module`: Nombre del módulo (ej: usuarios, inventario, ventas)
- `action`: Tipo de acción (ej: crear, editar, eliminar, ver)
- `description`: Descripción del permiso
- `category`: Categoría para agrupar permisos (ej: administración, operación, reporte)
- `is_system`: Indica si es un permiso de sistema (no se puede eliminar)
- `created_at` / `updated_at`: Timestamps automáticos

### 2. Ejecutar Seeder (Opcional pero Recomendado)

```bash
php artisan db:seed --class=PermissionSeeder
```

**Qué hace**: Carga 26 permisos iniciales del sistema:
- Permisos para **Usuarios** (crear, editar, eliminar, ver)
- Permisos para **Inventario** (crear, editar, eliminar, ver, ajuste)
- Permisos para **Ventas** (crear, editar, eliminar, ver)
- Permisos para **Compras** (crear, editar, eliminar, ver)
- Permisos para **Caja** (abrir, cerrar, ver_movimientos)
- Permisos para **Reportes** (ver, exportar)
- Permisos para **Configuración** (editar, ver)
- Permisos para **Permisos** (crear, editar, eliminar, ver)

---

## 📁 Archivos Creados

### Backend
```
app/
├── Models/
│   └── Permission.php                 (Modelo de Permiso)
├── Http/Controllers/
│   └── PermissionController.php       (Controlador CRUD)
├── Services/
│   └── PermissionService.php          (Servicio de utilidades)
database/
├── migrations/
│   └── 2024_01_15_000000_create_permissions_table.php
└── seeders/
    └── PermissionSeeder.php
```

### Frontend
```
resources/views/admin/permissions/
├── list.blade.php                     (Listado con filtros y CRUD)
├── create.blade.php                   (Formulario de creación)
└── edit.blade.php                     (Formulario de edición)
```

### Configuración
```
routes/web.php                         (Rutas actualizadas)
PERMISSIONS_SETUP.md                   (Documentación técnica)
INSTALLATION_GUIDE.md                  (Este archivo)
```

---

## 🌐 Rutas Disponibles

### Vistas (HTML)
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/admin/permissions/list` | Listado de permisos con CRUD integrado |
| GET | `/permissions/create` | Formulario para crear nuevo permiso |

### API REST (JSON)
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/permissions` | Obtener todos los permisos |
| POST | `/permissions` | Crear nuevo permiso |
| GET | `/permissions/{id}/edit` | Obtener datos de un permiso |
| PUT | `/permissions/{id}` | Actualizar permiso |
| DELETE | `/permissions/{id}` | Eliminar permiso |
| POST | `/permissions/bulk-delete` | Eliminar múltiples permisos |
| GET | `/permissions/grouped` | Obtener permisos agrupados por módulo |
| GET | `/permissions/category/{category}` | Obtener permisos por categoría |

---

## 💻 Ejemplos de Uso

### 1. Acceder al Listado de Permisos

```
URL: http://localhost/admin/permissions/list
```

**Funcionalidades**:
- Tabla interactiva con todos los permisos
- Filtros en tiempo real por módulo, acción y categoría
- Botones para editar cada permiso
- Eliminación individual con confirmación
- Selección múltiple para eliminación en lotes
- Indicador visual de permisos de sistema

### 2. Crear Nuevo Permiso

**Vía Web**:
```
1. Ir a http://localhost/admin/permissions/list
2. Hacer clic en "Nuevo Permiso"
3. Llenar el formulario con:
   - Módulo: "productos"
   - Acción: "descargar"
   - Categoría: "operación"
   - Descripción: "Descargar listado de productos"
   - Marcar "Permiso de Sistema" si es crítico
4. Guardar
```

**Vía API**:
```bash
curl -X POST http://localhost/permissions \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: {token}" \
  -d '{
    "module": "productos",
    "action": "descargar",
    "description": "Descargar listado de productos",
    "category": "operación",
    "is_system": false
  }'
```

### 3. Editar Permiso Existente

**Vía Web**:
```
1. En el listado, hacer clic en el botón de editar (lápiz)
2. Modificar los campos necesarios
3. Guardar cambios
```

**Vía API**:
```bash
curl -X PUT http://localhost/permissions/1 \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: {token}" \
  -d '{
    "module": "productos",
    "action": "descargar",
    "description": "Nuevo descripción",
    "category": "reporte",
    "is_system": false
  }'
```

### 4. Eliminar Permiso

**Eliminar uno**:
```bash
curl -X DELETE http://localhost/permissions/1 \
  -H "X-CSRF-TOKEN: {token}"
```

**Eliminar múltiples**:
```bash
curl -X POST http://localhost/permissions/bulk-delete \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: {token}" \
  -d '{
    "ids": [1, 2, 3]
  }'
```

### 5. Consultar Permisos (sin interfaz)

**Todos los permisos**:
```bash
curl http://localhost/permissions
```

**Agrupados por módulo**:
```bash
curl http://localhost/permissions/grouped
```

**Por categoría**:
```bash
curl http://localhost/permissions/category/operacion
```

---

## 🔒 Seguridad

### Protecciones Implementadas

1. **Permisos de Sistema**: No se pueden eliminar permisos marcados como `is_system = 1`
2. **Validación de Datos**: Todos los campos se validan antes de guardar
3. **Unicidad**: No se pueden crear dos permisos con el mismo módulo y acción
4. **CSRF**: Todas las rutas POST/PUT/DELETE requieren token CSRF
5. **Autorización**: Las rutas están protegidas por middleware `admin`

### Manejo de Errores

La aplicación retorna códigos HTTP apropiados:
- `201 Created`: Permiso creado exitosamente
- `200 OK`: Actualización exitosa
- `404 Not Found`: Permiso no encontrado
- `409 Conflict`: Intento de crear permiso duplicado
- `403 Forbidden`: Intento de eliminar permiso de sistema

---

## 🛠️ Próximos Pasos (Recomendados)

### 1. Conectar con Sistema de Roles

Crear tabla `role_permissions` para asignar permisos a roles:

```sql
CREATE TABLE role_permissions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  role_id INT NOT NULL,
  permission_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
  FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
  UNIQUE KEY unique_role_permission (role_id, permission_id)
);
```

### 2. Middleware de Verificación

Crear middleware para verificar permisos en controladores:

```php
// app/Http/Middleware/CheckPermission.php
public function handle($request, Closure $next, $module, $action) {
    if (!auth()->user()->hasPermission($module, $action)) {
        abort(403, 'No autorizado');
    }
    return $next($request);
}

// Uso en rutas:
Route::post('/productos', [...])
    ->middleware('permission:productos,crear');
```

### 3. Directiva Blade

Agregar directiva para mostrar/ocultar elementos según permisos:

```php
// app/Providers/AppServiceProvider.php
Blade::if('permission', function ($module, $action) {
    return auth()->user()->hasPermission($module, $action);
});

// Uso en vistas:
@permission('productos', 'crear')
  <button>Crear Producto</button>
@endpermission
```

---

## 📊 Estructura de Datos Ejemplo

Después de ejecutar el seeder, la tabla `permissions` contendrá:

```
id | module        | action        | category         | is_system | created_at
---+---------------+---------------+------------------+-----------+----------
 1 | usuarios      | crear         | administración   |     1     | 2024-01-15
 2 | usuarios      | editar        | administración   |     1     | 2024-01-15
 3 | usuarios      | eliminar      | administración   |     1     | 2024-01-15
 4 | usuarios      | ver           | administración   |     1     | 2024-01-15
 5 | inventario    | crear         | operación        |     1     | 2024-01-15
...
```

---

## 🆘 Solución de Problemas

### Error: CSRF Token Mismatch
**Solución**: Asegúrate de incluir el token CSRF en requests POST/PUT/DELETE:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

### Error: Permiso de Sistema no se puede eliminar
**Solución**: Normal. Los permisos marcados como sistema no se pueden eliminar. Cambiar `is_system` a 0 primero si es necesario.

### Error: Módulo + Acción duplicados
**Solución**: No se puede crear dos permisos iguales. Verificar que la combinación sea única.

### Tabla no existe
**Solución**: Ejecutar `php artisan migrate`

### Permisos iniciales no cargados
**Solución**: Ejecutar `php artisan db:seed --class=PermissionSeeder`

---

## 📝 Notas Importantes

- ✅ Toda la funcionalidad CRUD está lista para usar
- ✅ El sistema valida la unicidad de módulo + acción
- ✅ Los permisos de sistema están protegidos contra eliminación
- ✅ Las vistas incluyen JavaScript para mejor UX
- ✅ El modelo incluye métodos útiles para consultas
- ✅ Las rutas están protegidas por middleware de autenticación
- ⚠️ Para integración con roles, ver sección "Próximos Pasos"

---

## 📞 Soporte

Para más información técnica, consultar:
- `PERMISSIONS_SETUP.md` - Documentación técnica detallada
- `app/Models/Permission.php` - Métodos disponibles del modelo
- `app/Http/Controllers/PermissionController.php` - Lógica de negocio
- `app/Services/PermissionService.php` - Utilidades y helpers
