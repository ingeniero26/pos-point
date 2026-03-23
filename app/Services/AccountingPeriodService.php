<?php

namespace App\Services;

use App\Models\AccountingPeriods;
use App\Models\Companies;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;

class AccountingPeriodService
{
    /**
     * Crea un nuevo período contable
     */
    public function createPeriod(array $data): AccountingPeriods
    {
        $company = Companies::findOrFail($data['company_id']);

        // Validar que no existe un período para el mismo año y mes
        $existingPeriod = AccountingPeriods::where('company_id', $data['company_id'])
            ->where('year', $data['year'])
            ->where('month', $data['month'])
            ->first();

        if ($existingPeriod) {
            throw new \Exception("Ya existe un período contable para {$data['month']}/{$data['year']}");
        }

        // Establecer fechas por defecto
        $year = $data['year'];
        $month = $data['month'];

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();

        // Si se proporcionan fechas personalizadas
        if (isset($data['start_date'])) {
            $startDate = Carbon::parse($data['start_date'])->startOfDay();
        }
        if (isset($data['end_date'])) {
            $endDate = Carbon::parse($data['end_date'])->endOfDay();
        }

        $period = new AccountingPeriods([
            'company_id' => $data['company_id'],
            'year' => $year,
            'month' => $month,
            'period_name' => $data['period_name'] ?? AccountingPeriods::getMonthName($month) . ' ' . $year,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $data['status'] ?? 'open',
            'notes' => $data['notes'] ?? null,
        ]);

        $period->save();

        return $period;
    }

    /**
     * Actualiza un período contable
     */
    public function updatePeriod(AccountingPeriods $period, array $data): AccountingPeriods
    {
        // Solo permitir edición si el período está abierto
        if (!$period->isOpen()) {
            throw new \Exception('No se puede editar un período cerrado o bloqueado');
        }

        if (isset($data['period_name'])) {
            $period->period_name = $data['period_name'];
        }
        if (isset($data['start_date'])) {
            $period->start_date = Carbon::parse($data['start_date'])->startOfDay();
        }
        if (isset($data['end_date'])) {
            $period->end_date = Carbon::parse($data['end_date'])->endOfDay();
        }
        if (isset($data['notes'])) {
            $period->notes = $data['notes'];
        }

        $period->save();

        return $period;
    }

    /**
     * Cierra un período contable
     */
    public function closePeriod(AccountingPeriods $period, ?int $userId = null): AccountingPeriods
    {
        if (!$period->isOpen()) {
            throw new \Exception('El período no está abierto');
        }

        // Aquí se pueden agregar validaciones adicionales
        // por ejemplo, verificar que todos los movimientos estén registrados

        $period->close($userId);

        return $period;
    }

    /**
     * Bloquea un período contable
     */
    public function lockPeriod(AccountingPeriods $period): AccountingPeriods
    {
        if (!$period->isClosed()) {
            throw new \Exception('Solo se pueden bloquear períodos cerrados');
        }

        $period->lock();

        return $period;
    }

    /**
     * Desbloquea un período contable
     */
    public function unlockPeriod(AccountingPeriods $period): AccountingPeriods
    {
        if (!$period->isLocked()) {
            throw new \Exception('El período no está bloqueado');
        }

        $period->unlock();

        return $period;
    }

    /**
     * Reabre un período contable
     */
    public function reopenPeriod(AccountingPeriods $period): AccountingPeriods
    {
        if (!($period->isClosed() || $period->isLocked())) {
            throw new \Exception('El período no está cerrado o bloqueado');
        }

        $period->reopen();

        return $period;
    }

    /**
     * Elimina un período contable (lógico)
     */
    public function deletePeriod(AccountingPeriods $period): void
    {
        if (!$period->isOpen()) {
            throw new \Exception('Solo se pueden eliminar períodos abiertos');
        }

        $period->is_delete = true;
        $period->save();
    }

    /**
     * Obtiene todos los períodos de una empresa
     */
    public function getCompanyPeriods($companyId, $paginate = true)
    {
        $query = AccountingPeriods::where('company_id', $companyId)
            ->where('is_delete', false)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');

        if ($paginate) {
            return $query->paginate(10);
        }

        return $query->get();
    }

    /**
     * Obtiene los períodos abiertos de una empresa
     */
    public function getOpenPeriods($companyId)
    {
        return AccountingPeriods::where('company_id', $companyId)
            ->where('status', 'open')
            ->where('is_delete', false)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }

    /**
     * Obtiene los períodos cerrados de una empresa
     */
    public function getClosedPeriods($companyId)
    {
        return AccountingPeriods::where('company_id', $companyId)
            ->where('status', 'closed')
            ->where('is_delete', false)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }

    /**
     * Obtiene el período actual o más reciente
     */
    public function getCurrentPeriod($companyId, $year = null, $month = null)
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;

        return AccountingPeriods::where('company_id', $companyId)
            ->where('year', $year)
            ->where('month', $month)
            ->where('is_delete', false)
            ->first();
    }

    /**
     * Crea los períodos de un año automáticamente
     */
    public function createYearPeriods($companyId, $year): Collection
    {
        $periods = collect();

        try {
            for ($month = 1; $month <= 12; $month++) {
                try {
                    $period = $this->createPeriod([
                        'company_id' => $companyId,
                        'year' => $year,
                        'month' => $month,
                    ]);
                    $periods->push($period);
                } catch (\Exception $e) {
                    // Continuar con el siguiente mes si ya existe
                    continue;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("Error al crear períodos del año: {$e->getMessage()}");
        }

        return $periods;
    }

    /**
     * Obtiene el período que contiene una fecha específica
     */
    public function getPeriodByDate($companyId, $date)
    {
        $date = Carbon::parse($date);

        return AccountingPeriods::where('company_id', $companyId)
            ->where('year', $date->year)
            ->where('month', $date->month)
            ->where('is_delete', false)
            ->first();
    }

    /**
     * Obtiene estadísticas de períodos de una empresa
     */
    public function getStatistics($companyId): array
    {
        $allPeriods = AccountingPeriods::where('company_id', $companyId)
            ->where('is_delete', false)
            ->get();

        return [
            'total' => $allPeriods->count(),
            'open' => $allPeriods->where('status', 'open')->count(),
            'closed' => $allPeriods->where('status', 'closed')->count(),
            'locked' => $allPeriods->where('status', 'locked')->count(),
        ];
    }

    /**
     * Valida si se puede crear un período
     */
    public function canCreatePeriod($companyId, $year, $month): bool
    {
        $existing = AccountingPeriods::where('company_id', $companyId)
            ->where('year', $year)
            ->where('month', $month)
            ->where('is_delete', false)
            ->exists();

        return !$existing;
    }

    /**
     * Obtiene períodos en rango de fechas
     */
    public function getPeriodsByDateRange($companyId, $startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        return AccountingPeriods::where('company_id', $companyId)
            ->where('is_delete', false)
            ->whereDate('start_date', '>=', $startDate)
            ->whereDate('end_date', '<=', $endDate)
            ->orderBy('start_date')
            ->get();
    }
}
