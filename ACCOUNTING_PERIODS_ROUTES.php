<?php

/**
 * RUTAS PARA GESTIÓN DE PERÍODOS CONTABLES
 * 
 * Agregar estas rutas a routes/web.php
 * 
 * NOTA: Asegúrate de que el middleware 'auth' esté correctamente configurado
 */

use App\Http\Controllers\AccountingPeriodsController;

// ============================================================
// RUTAS WEB - Vistas (Formularios y Listados)
// ============================================================

Route::middleware(['auth'])->group(function () {
    
    Route::prefix('accounting-periods')->name('accounting-periods.')->group(function () {
        
        // Listado de períodos contables
        Route::get('/', [AccountingPeriodsController::class, 'list'])->name('list');
        
        // Formulario de creación
        Route::get('/create', [AccountingPeriodsController::class, 'create'])->name('create');
        
        // Ver detalles de un período
        Route::get('/{accountingPeriods}', [AccountingPeriodsController::class, 'show'])->name('show');
        
        // Formulario de edición
        Route::get('/{accountingPeriods}/edit', [AccountingPeriodsController::class, 'edit'])->name('edit');
        
    });
    
});

// ============================================================
// RUTAS API - Operaciones (JSON)
// ============================================================

Route::middleware(['auth'])->group(function () {
    
    Route::prefix('api/accounting-periods')->group(function () {
        
        // Crear nuevo período (POST)
        Route::post('/', [AccountingPeriodsController::class, 'store']);
        
        // Actualizar período (PUT)
        Route::put('/{accountingPeriods}', [AccountingPeriodsController::class, 'update']);
        
        // Eliminar período (DELETE)
        Route::delete('/{accountingPeriods}', [AccountingPeriodsController::class, 'destroy']);
        
        // Cerrar período (POST)
        Route::post('/{accountingPeriods}/close', [AccountingPeriodsController::class, 'close'])->name('close');
        
        // Bloquear período (POST)
        Route::post('/{accountingPeriods}/lock', [AccountingPeriodsController::class, 'lock'])->name('lock');
        
        // Desbloquear período (POST)
        Route::post('/{accountingPeriods}/unlock', [AccountingPeriodsController::class, 'unlock'])->name('unlock');
        
        // Reabrir período (POST)
        Route::post('/{accountingPeriods}/reopen', [AccountingPeriodsController::class, 'reopen'])->name('reopen');
        
        // Crear períodos de un año (POST)
        Route::post('/create-year', [AccountingPeriodsController::class, 'createYearPeriods']);
        
        // Obtener período por fecha (GET)
        Route::get('/by-date', [AccountingPeriodsController::class, 'getByDate']);
        
        // Obtener estadísticas (GET)
        Route::get('/statistics', [AccountingPeriodsController::class, 'getStatistics']);
        
        // Obtener todos los períodos (GET)
        Route::get('/all', [AccountingPeriodsController::class, 'getAccountingPeriods']);
        
    });
    
});

/**
 * ENDPOINTS DISPONIBLES
 * 
 * VISTAS (Web):
 * ─────────────────────────────────────────
 * GET    /accounting-periods                    → Listado
 * GET    /accounting-periods/create             → Crear
 * GET    /accounting-periods/{id}               → Detalles
 * GET    /accounting-periods/{id}/edit          → Editar
 * 
 * API (JSON):
 * ─────────────────────────────────────────
 * GET    /api/accounting-periods/all            → Obtener todos
 * GET    /api/accounting-periods/statistics     → Estadísticas
 * GET    /api/accounting-periods/by-date        → Por fecha
 * POST   /api/accounting-periods                → Crear
 * PUT    /api/accounting-periods/{id}           → Actualizar
 * DELETE /api/accounting-periods/{id}           → Eliminar
 * POST   /api/accounting-periods/{id}/close     → Cerrar
 * POST   /api/accounting-periods/{id}/lock      → Bloquear
 * POST   /api/accounting-periods/{id}/unlock    → Desbloquear
 * POST   /api/accounting-periods/{id}/reopen    → Reabrir
 * POST   /api/accounting-periods/create-year    → Crear año completo
 * 
 * PARÁMETROS DE CONSULTA (Query Parameters):
 * ─────────────────────────────────────────
 * ?company_id=1                 → Filtrar por empresa
 * ?status=open|closed|locked    → Filtrar por estado
 * ?year=2024                    → Filtrar por año
 * ?month=3                      → Filtrar por mes
 * 
 * EJEMPLOS DE USO:
 * ─────────────────────────────────────────
 * 
 * Listar períodos de empresa 1:
 * GET /accounting-periods?company_id=1
 * 
 * Obtener períodos abiertos:
 * GET /api/accounting-periods/all?status=open
 * 
 * Obtener estadísticas:
 * GET /api/accounting-periods/statistics?company_id=1
 * 
 * Obtener período para una fecha:
 * GET /api/accounting-periods/by-date?company_id=1&date=2024-03-15
 * 
 * Crear nuevo período:
 * POST /api/accounting-periods
 * Body: {
 *   "company_id": 1,
 *   "year": 2024,
 *   "month": 3,
 *   "period_name": "Marzo 2024",
 *   "start_date": "2024-03-01",
 *   "end_date": "2024-03-31",
 *   "notes": "Período de prueba"
 * }
 * 
 * Cerrar período:
 * POST /api/accounting-periods/1/close
 * 
 * Crear todos los períodos de 2024:
 * POST /api/accounting-periods/create-year
 * Body: {
 *   "company_id": 1,
 *   "year": 2024
 * }
 */
