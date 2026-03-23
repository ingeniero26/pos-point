<?php

namespace App\Http\Controllers;

use App\Models\AccountingPeriods;
use App\Models\Companies;
use App\Services\AccountingPeriodService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class AccountingPeriodsController extends Controller
{
    protected $accountingPeriodService;

    public function __construct(AccountingPeriodService $accountingPeriodService)
    {
        $this->accountingPeriodService = $accountingPeriodService;
        $this->middleware('auth');
    }

    /**
     * Muestra la lista de períodos contables
     */
    public function list(Request $request): View
    {
        $companyId = $request->get('company_id', auth()->user()->company_id ?? 1);
        
        $periods = $this->accountingPeriodService->getCompanyPeriods($companyId);
        $statistics = $this->accountingPeriodService->getStatistics($companyId);
        $companies = Companies::all();

        return view('admin.accounting_periods.list', compact(
            'periods',
            'statistics',
            'companies',
            'companyId'
        ));
    }

    /**
     * Obtiene todos los períodos contables en JSON
     */
    public function getAccountingPeriods(Request $request): JsonResponse
    {
        $companyId = $request->get('company_id', auth()->user()->company_id ?? 1);
        $status = $request->get('status');

        $query = AccountingPeriods::where('company_id', $companyId)
            ->where('is_delete', false)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        $periods = $query->get();

        return response()->json([
            'success' => true,
            'data' => $periods->map(function ($period) {
                return [
                    'id' => $period->id,
                    'period_name' => $period->getFormattedPeriodName(),
                    'year' => $period->year,
                    'month' => $period->month,
                    'start_date' => $period->start_date->format('Y-m-d'),
                    'end_date' => $period->end_date->format('Y-m-d'),
                    'status' => $period->status,
                    'closed_at' => $period->closed_at?->format('Y-m-d H:i:s'),
                    'closed_by' => $period->closedBy?->name,
                    'days_remaining' => $period->getDaysRemaining(),
                    'completed_percentage' => $period->getCompletedPercentage(),
                ];
            }),
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo período
     */
    public function create(Request $request): View
    {
        $companyId = $request->get('company_id', auth()->user()->company_id ?? 1);
        $companies = Companies::all();
        $currentYear = now()->year;
        $years = range($currentYear - 2, $currentYear + 2);

        return view('admin.accounting_periods.create', compact(
            'companies',
            'companyId',
            'currentYear',
            'years'
        ));
    }

    /**
     * Guarda un nuevo período contable
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'company_id' => 'required|exists:companies,id',
                'year' => 'required|integer|min:2000|max:2099',
                'month' => 'required|integer|min:1|max:12',
                'period_name' => 'nullable|string|max:100',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'notes' => 'nullable|string|max:500',
            ]);

            $period = $this->accountingPeriodService->createPeriod($validated);

            return response()->json([
                'success' => true,
                'message' => 'Período contable creado exitosamente',
                'data' => $period,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Muestra los detalles de un período
     */
    public function show($id): View
    {
        $period = AccountingPeriods::findOrFail($id);
        
        return view('admin.accounting_periods.show', compact('period'));
    }

    /**
     * Muestra el formulario para editar un período
     */
    public function edit(AccountingPeriods $accountingPeriods): View
    {
        if (!$accountingPeriods->isOpen()) {
            abort(403, 'No se puede editar un período cerrado o bloqueado');
        }

        return view('admin.accounting_periods.edit', compact('accountingPeriods'));
    }

    /**
     * Actualiza un período contable
     */
    public function update(Request $request, AccountingPeriods $accountingPeriods): JsonResponse
    {
        try {
            if (!$accountingPeriods->isOpen()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede editar un período cerrado o bloqueado',
                ], 403);
            }

            $validated = $request->validate([
                'period_name' => 'nullable|string|max:100',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'notes' => 'nullable|string|max:500',
            ]);

            $period = $this->accountingPeriodService->updatePeriod($accountingPeriods, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Período contable actualizado exitosamente',
                'data' => $period,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Elimina un período contable
     */
    public function destroy(AccountingPeriods $accountingPeriods): JsonResponse
    {
        try {
            $this->accountingPeriodService->deletePeriod($accountingPeriods);

            return response()->json([
                'success' => true,
                'message' => 'Período contable eliminado exitosamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Cierra un período contable
     */
    public function close(Request $request, AccountingPeriods $accountingPeriods): JsonResponse
    {
        try {
            $this->accountingPeriodService->closePeriod($accountingPeriods, auth()->id());

            return response()->json([
                'success' => true,
                'message' => 'Período contable cerrado exitosamente',
                'data' => $accountingPeriods->fresh(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Bloquea un período contable
     */
    public function lock(Request $request, AccountingPeriods $accountingPeriods): JsonResponse
    {
        try {
            $this->accountingPeriodService->lockPeriod($accountingPeriods);

            return response()->json([
                'success' => true,
                'message' => 'Período contable bloqueado exitosamente',
                'data' => $accountingPeriods->fresh(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Desbloquea un período contable
     */
    public function unlock(Request $request, AccountingPeriods $accountingPeriods): JsonResponse
    {
        try {
            $this->accountingPeriodService->unlockPeriod($accountingPeriods);

            return response()->json([
                'success' => true,
                'message' => 'Período contable desbloqueado exitosamente',
                'data' => $accountingPeriods->fresh(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Reabre un período contable
     */
    public function reopen(Request $request, AccountingPeriods $accountingPeriods): JsonResponse
    {
        try {
            $this->accountingPeriodService->reopenPeriod($accountingPeriods);

            return response()->json([
                'success' => true,
                'message' => 'Período contable reabierto exitosamente',
                'data' => $accountingPeriods->fresh(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Crea los períodos de un año automáticamente
     */
    public function createYearPeriods(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'company_id' => 'required|exists:companies,id',
                'year' => 'required|integer|min:2000|max:2099',
            ]);

            $periods = $this->accountingPeriodService->createYearPeriods(
                $validated['company_id'],
                $validated['year']
            );

            return response()->json([
                'success' => true,
                'message' => "Se crearon {$periods->count()} períodos contables para el año {$validated['year']}",
                'data' => $periods,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Obtiene período por fecha
     */
    public function getByDate(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'company_id' => 'required|exists:companies,id',
                'date' => 'required|date',
            ]);

            $period = $this->accountingPeriodService->getPeriodByDate(
                $validated['company_id'],
                $validated['date']
            );

            if (!$period) {
                return response()->json([
                    'success' => false,
                    'message' => 'No existe período para la fecha especificada',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $period,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Obtiene estadísticas de períodos
     */
    public function getStatistics(Request $request): JsonResponse
    {
        try {
            $companyId = $request->get('company_id', auth()->user()->company_id ?? 1);

            $statistics = $this->accountingPeriodService->getStatistics($companyId);

            return response()->json([
                'success' => true,
                'data' => $statistics,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
