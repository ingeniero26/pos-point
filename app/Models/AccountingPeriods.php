<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AccountingPeriods extends Model
{
    protected $table = 'accounting_periods';

    protected $fillable = [
        'company_id',
        'year',
        'month',
        'period_name',
        'start_date',
        'end_date',
        'status',
        'closed_at',
        'closed_by',
        'notes',
        'is_delete',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'closed_at' => 'datetime',
        'is_delete' => 'boolean',
    ];

    /**
     * Relación con la empresa
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    /**
     * Relación con el usuario que cerró el período
     */
    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    /**
     * Alcance para obtener solo registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_delete', false);
    }

    /**
     * Alcance para obtener períodos abiertos
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Alcance para obtener períodos cerrados
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Alcance para obtener períodos bloqueados
     */
    public function scopeLocked($query)
    {
        return $query->where('status', 'locked');
    }

    /**
     * Alcance para obtener períodos por empresa
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Alcance para obtener períodos por año
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Obtiene los meses en español
     */
    public static function getMonthName($month)
    {
        $months = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];
        return $months[$month] ?? '';
    }

    /**
     * Obtiene el nombre del período formateado
     */
    public function getFormattedPeriodName()
    {
        return $this->period_name ?? self::getMonthName($this->month) . ' ' . $this->year;
    }

    /**
     * Verifica si el período está abierto
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Verifica si el período está cerrado
     */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    /**
     * Verifica si el período está bloqueado
     */
    public function isLocked(): bool
    {
        return $this->status === 'locked';
    }

    /**
     * Cierra el período contable
     */
    public function close($userId = null)
    {
        if ($this->isClosed()) {
            throw new \Exception('El período ya está cerrado');
        }

        $this->status = 'closed';
        $this->closed_at = now();
        $this->closed_by = $userId;
        $this->save();

        return $this;
    }

    /**
     * Bloquea el período contable
     */
    public function lock()
    {
        if (!$this->isClosed()) {
            throw new \Exception('Solo se pueden bloquear períodos cerrados');
        }

        $this->status = 'locked';
        $this->save();

        return $this;
    }

    /**
     * Desbloquea el período contable
     */
    public function unlock()
    {
        if (!$this->isLocked()) {
            throw new \Exception('El período no está bloqueado');
        }

        $this->status = 'closed';
        $this->save();

        return $this;
    }

    /**
     * Reabre el período contable
     */
    public function reopen()
    {
        if (!$this->isClosed() && !$this->isLocked()) {
            throw new \Exception('El período no está cerrado');
        }

        $this->status = 'open';
        $this->closed_at = null;
        $this->closed_by = null;
        $this->save();

        return $this;
    }

    /**
     * Cambia el estado del período
     */
    public function changeStatus($newStatus)
    {
        $validStatuses = ['open', 'closed', 'locked'];

        if (!in_array($newStatus, $validStatuses)) {
            throw new \Exception('Estado no válido');
        }

        $this->status = $newStatus;
        $this->save();

        return $this;
    }

    /**
     * Obtiene el siguiente período
     */
    public function getNextPeriod()
    {
        $nextMonth = $this->month + 1;
        $nextYear = $this->year;

        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }

        return self::where('company_id', $this->company_id)
            ->where('year', $nextYear)
            ->where('month', $nextMonth)
            ->first();
    }

    /**
     * Obtiene el período anterior
     */
    public function getPreviousPeriod()
    {
        $previousMonth = $this->month - 1;
        $previousYear = $this->year;

        if ($previousMonth < 1) {
            $previousMonth = 12;
            $previousYear--;
        }

        return self::where('company_id', $this->company_id)
            ->where('year', $previousYear)
            ->where('month', $previousMonth)
            ->first();
    }

    /**
     * Obtiene el total de días del período
     */
    public function getDaysCount(): int
    {
        return $this->end_date->diffInDays($this->start_date) + 1;
    }

    /**
     * Verifica si el período está vencido
     */
    public function isExpired(): bool
    {
        return now()->isAfter($this->end_date);
    }

    /**
     * Verifica si la fecha está dentro del período
     */
    public function isDateInPeriod($date): bool
    {
        $date = Carbon::parse($date);
        return $date->isBetween($this->start_date, $this->end_date);
    }

    /**
     * Obtiene los días restantes del período
     */
    public function getDaysRemaining(): int
    {
        if ($this->isExpired()) {
            return 0;
        }

        return now()->diffInDays($this->end_date);
    }

    /**
     * Obtiene el porcentaje de completitud del período
     */
    public function getCompletedPercentage(): float
    {
        $totalDays = $this->getDaysCount();
        $daysElapsed = $this->start_date->diffInDays(now());

        if ($daysElapsed > $totalDays) {
            return 100;
        }

        return round(($daysElapsed / $totalDays) * 100, 2);
    }
}
