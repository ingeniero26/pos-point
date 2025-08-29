<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountingMovement extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounting_movements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'receipt_number',
        'receipt_type_id',
        'receipt_date',
        'due_date',
        'concept',
        'reference',
        'total_debits',
        'total_credits',
        'status',
        'creation_user',
        'confirmation_date',
        'confirmation_user',
        'company_id',
        'created_by',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'receipt_date' => 'date',
        'due_date' => 'date',
        'total_debits' => 'decimal:2',
        'total_credits' => 'decimal:2',
        'creation_date' => 'timestamp',
        'confirmation_date' => 'timestamp',
        'active' => 'boolean',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Status constants
     */
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_CANCELLED = 'CANCELLED';

    /**
     * Get all possible status values
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_DRAFT => 'Borrador',
            self::STATUS_CONFIRMED => 'Confirmado',
            self::STATUS_CANCELLED => 'Cancelado',
        ];
    }

    /**
     * Scope a query to only include active movements.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to filter by status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to filter by date range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('receipt_date', [$startDate, $endDate]);
    }

    /**
     * Get the receipt type that owns the accounting movement.
     */
    public function receiptType()
    {
        return $this->belongsTo(ReceiptType::class);
    }

    /**
     * Get the company that owns the accounting movement.
     */
    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    /**
     * Get the user who created this movement.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creation_user');
    }

    /**
     * Get the user who created this movement (alternative field).
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who confirmed this movement.
     */
    public function confirmedByUser()
    {
        return $this->belongsTo(User::class, 'confirmation_user');
    }

    /**
     * Check if the movement is confirmed.
     *
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    /**
     * Check if the movement is draft.
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Check if the movement is cancelled.
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Confirm the movement.
     *
     * @param int $userId
     * @return bool
     */
    public function confirm($userId = null)
    {
        $this->status = self::STATUS_CONFIRMED;
        $this->confirmation_date = now();
        if ($userId) {
            $this->confirmation_user = $userId;
        }
        
        return $this->save();
    }

    /**
     * Cancel the movement.
     *
     * @return bool
     */
    public function cancel()
    {
        $this->status = self::STATUS_CANCELLED;
        return $this->save();
    }

    /**
     * Get the transaction details for this movement.
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'accounting_movement_id');
    }

    /**
     * Get the balance (credits - debits).
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->total_credits - $this->total_debits;
    }

    /**
     * Update totals based on transaction details.
     *
     * @return bool
     */
    public function updateTotals()
    {
        $totals = $this->transactionDetails()
            ->selectRaw('SUM(debit) as total_debits, SUM(credit) as total_credits')
            ->first();

        $this->total_debits = $totals->total_debits ?? 0;
        $this->total_credits = $totals->total_credits ?? 0;

        return $this->save();
    }

    /**
     * Check if the movement is balanced (total debits = total credits).
     *
     * @return bool
     */
    public function isBalanced()
    {
        return abs($this->total_debits - $this->total_credits) < 0.01;
    }

    /**
     * Validate that the movement has transaction details and is balanced.
     *
     * @return array
     */
    public function validateForConfirmation()
    {
        $errors = [];

        // Check if has transaction details
        if ($this->transactionDetails()->count() === 0) {
            $errors[] = 'El movimiento debe tener al menos un detalle de transacción';
        }

        // Check if is balanced
        if (!$this->isBalanced()) {
            $errors[] = 'El movimiento debe estar balanceado (débitos = créditos)';
        }

        return $errors;
    }
}