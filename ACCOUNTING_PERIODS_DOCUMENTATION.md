# Gestión de Períodos Contables - Documentación

## Descripción General

Se ha implementado un sistema completo de gestión de períodos contables para la aplicación POS. Este sistema permite crear, editar, cerrar y bloquear períodos contables por empresa.

## Componentes Implementados

### 1. **Modelo de Datos** (`app/Models/AccountingPeriods.php`)

El modelo incluye:
- **Relaciones:** Empresa y Usuario (quien cerró el período)
- **Estados:** open, closed, locked
- **Métodos útiles:**
  - `isOpen()`, `isClosed()`, `isLocked()` - Verificar estado
  - `close()`, `lock()`, `unlock()`, `reopen()` - Cambiar estado
  - `getFormattedPeriodName()` - Nombre del período formateado
  - `getDaysCount()` - Total de días
  - `getDaysRemaining()` - Días restantes
  - `getCompletedPercentage()` - Porcentaje de completitud
  - `isDateInPeriod()` - Verificar si una fecha está en el período

### 2. **Migración de Base de Datos** (`database/migrations/2024_03_23_000001_create_accounting_periods_table.php`)

Tabla `accounting_periods` con:
- Campos: id, company_id, year, month, period_name, start_date, end_date, status, closed_at, closed_by, notes, is_delete, timestamps
- Índices para optimización: company_id, year, month, status
- Índice único: (company_id, year, month)
- Claves foráneas: company_id, closed_by

### 3. **Servicio de Negocio** (`app/Services/AccountingPeriodService.php`)

Contiene la lógica de negocio con métodos para:
- `createPeriod()` - Crear período con validaciones
- `updatePeriod()` - Actualizar únicamente períodos abiertos
- `closePeriod()` - Cerrar período
- `lockPeriod()` / `unlockPeriod()` - Bloquear/desbloquear
- `reopenPeriod()` - Reabrir período
- `deletePeriod()` - Eliminar lógicamente
- `getCompanyPeriods()` - Obtener períodos por empresa
- `getPeriodByDate()` - Encontrar período por fecha
- `createYearPeriods()` - Crear los 12 meses del año automáticamente
- `getStatistics()` - Obtener estadísticas

### 4. **Controlador** (`app/Http/Controllers/AccountingPeriodsController.php`)

Implementa los siguientes endpoints:
- `list()` - Vista de listado
- `create()` - Formulario de creación
- `store()` - Guardar nuevo período
- `show()` - Detalles del período
- `edit()` - Formulario de edición
- `update()` - Actualizar período
- `destroy()` - Eliminar período
- `close()` - Cerrar período (POST)
- `lock()` - Bloquear período (POST)
- `unlock()` - Desbloquear período (POST)
- `reopen()` - Reabrir período (POST)
- `createYearPeriods()` - Crear períodos del año (POST)
- `getByDate()` - Obtener período por fecha
- `getStatistics()` - Obtener estadísticas

### 5. **Vistas Blade**

#### `list.blade.php`
- Tabla de períodos con filtros por empresa y estado
- Estadísticas: Total, Abiertos, Cerrados, Bloqueados
- Barra de progreso de completitud
- Acciones contextuales por estado

#### `create.blade.php`
- Formulario para crear nuevo período
- Selección de empresa, año y mes
- Fechas calculadas automáticamente
- Información de ayuda

#### `edit.blade.php`
- Formulario para editar período (solo abiertos)
- Información de empresa, año y mes (solo lectura)
- Acciones para cerrar, bloquear, desbloquear, reabrir

#### `show.blade.php`
- Vista detallada del período
- Estadísticas: días, avance, vencimiento
- Información de cierre
- Acciones disponibles según estado

## Rutas Requeridas

Añadir a `routes/web.php` o `routes/api.php`:

```php
// Rutas Web (vistas)
Route::middleware(['auth'])->group(function () {
    Route::prefix('accounting-periods')->name('accounting-periods.')->group(function () {
        Route::get('/', 'AccountingPeriodsController@list')->name('list');
        Route::get('/create', 'AccountingPeriodsController@create')->name('create');
        Route::get('/{accountingPeriods}', 'AccountingPeriodsController@show')->name('show');
        Route::get('/{accountingPeriods}/edit', 'AccountingPeriodsController@edit')->name('edit');
    });
});

// Rutas API (operaciones)
Route::middleware(['auth'])->group(function () {
    Route::prefix('api/accounting-periods')->group(function () {
        Route::post('/', 'AccountingPeriodsController@store');
        Route::put('/{accountingPeriods}', 'AccountingPeriodsController@update');
        Route::delete('/{accountingPeriods}', 'AccountingPeriodsController@destroy');
        Route::post('/{accountingPeriods}/close', 'AccountingPeriodsController@close');
        Route::post('/{accountingPeriods}/lock', 'AccountingPeriodsController@lock');
        Route::post('/{accountingPeriods}/unlock', 'AccountingPeriodsController@unlock');
        Route::post('/{accountingPeriods}/reopen', 'AccountingPeriodsController@reopen');
        Route::post('/create-year', 'AccountingPeriodsController@createYearPeriods');
        Route::get('/by-date', 'AccountingPeriodsController@getByDate');
        Route::get('/statistics', 'AccountingPeriodsController@getStatistics');
    });
});
```

## Procesos y Flujos de Estado

### Estados de Período

```
OPEN (Abierto)
  ↓
  ├─→ CLOSED (Cerrado)
  │     ↓
  │     ├─→ LOCKED (Bloqueado)
  │     │     ↓
  │     │     └─→ CLOSED (Desbloqueado)
  │     │
  │     └─→ OPEN (Reabierto)
  │
  └─→ DELETED (Eliminado)
```

## Funcionalidades Principales

1. **Crear Períodos**
   - Automáticamente por mes o año completo
   - Validación de duplicados
   - Fechas calculadas según mes/año

2. **Gestionar Períodos**
   - Editar solo períodos abiertos
   - Cerrar para finalizar operaciones
   - Bloquear para proteger datos

3. **Consultar Información**
   - Obtener período por fecha
   - Listar por empresa o estado
   - Estadísticas de períodos
   - Progreso y completitud

4. **Seguridad**
   - Validaciones de estado antes de operaciones
   - Control de acceso por middleware de autenticación
   - Registros de quién cerró cada período

## Ejemplo de Uso

### Crear período automáticamente para el año 2024

```php
$service = app(AccountingPeriodService::class);
$periods = $service->createYearPeriods(1, 2024); // company_id=1
```

### Obtener período actual

```php
$period = $service->getCurrentPeriod(1, 2024, 3); // año, mes
```

### Cerrar período

```php
$period = AccountingPeriods::find(1);
$service->closePeriod($period, auth()->id());
```

### Verificar si fecha está en período

```php
$period = AccountingPeriods::find(1);
$inPeriod = $period->isDateInPeriod('2024-03-15');
```

## Instalación y Migración

1. **Ejecutar migraciones:**
```bash
php artisan migrate
```

2. **Registrar rutas en `routes/web.php`**

3. **Crear el directorio de vistas:** (ya creado)
   - `resources/views/admin/accounting_periods/`

## Próximas Mejoras (Opcionales)

- Auditoría completa de cambios
- Exportar períodos a Excel
- Reportes de períodos
- Validaciones de movimientos por período
- Integración con módulo contable
- Notificaciones de cierre de período
- API RESTFUL mejorada
- Tests unitarios

## Notas Importantes

- Los períodos cerrados no pueden ser editados, solo desbloqueados
- Los períodos bloqueados no pueden ser modificados
- Solo se pueden crear períodos únicos por empresa/año/mes
- El servicio realiza validaciones antes de cualquier operación
- Las vistas incluyen validaciones de seguridad y mensajes de confirmación
