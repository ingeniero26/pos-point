<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'accounting_movement_id',
        'puc_account_id',
        'third_party_id',
        'cost_center_id',
        'concept',
        'debit',
        'credit',
        'base',
        'document_reference',
        'due_date',
        'company_id',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
        'base' => 'decimal:2',
        'due_date' => 'date',
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
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set created_by when creating
        static::creating(function ($model) {
            if (auth()->check() && !$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
    }

    /**
     * Get the accounting movement that owns the transaction detail.
     */
    public function accountingMovement()
    {
        return $this->belongsTo(AccountingMovement::class, 'accounting_movement_id');
    }

    /**
     * Get the PUC account that owns the transaction detail.
     */
    public function pucAccount()
    {
        return $this->belongsTo(PucAccount::class, 'puc_account_id');
    }

    /**
     * Get the third party associated with the transaction detail.
     */
    public function thirdParty()
    {
        return $this->belongsTo(PersonModel::class, 'third_party_id');
    }

    /**
     * Get the cost center associated with the transaction detail.
     */
    public function costCenter()
    {
        return $this->belongsTo(CostCenterModel::class, 'cost_center_id');
    }

    /**
     * Get the company that owns the transaction detail.
     */
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    /**
     * Get the user who created this transaction detail.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include debit transactions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDebits($query)
    {
        return $query->where('debit', '>', 0);
    }

    /**
     * Scope a query to only include credit transactions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCredits($query)
    {
        return $query->where('credit', '>', 0);
    }

    /**
     * Scope a query to filter by PUC account.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $accountId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByAccount($query, $accountId)
    {
        return $query->where('puc_account_id', $accountId);
    }

    /**
     * Scope a query to filter by third party.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $thirdPartyId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByThirdParty($query, $thirdPartyId)
    {
        return $query->where('third_party_id', $thirdPartyId);
    }

    /**
     * Scope a query to filter by cost center.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $costCenterId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCostCenter($query, $costCenterId)
    {
        return $query->where('cost_center_id', $costCenterId);
    }

    /**
     * Scope a query to filter by company.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $companyId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope a query to filter by date range based on accounting movement date.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereHas('accountingMovement', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('receipt_date', [$startDate, $endDate]);
        });
    }

    /**
     * Check if this is a debit transaction.
     *
     * @return bool
     */
    public function isDebit()
    {
        return $this->debit > 0;
    }

    /**
     * Check if this is a credit transaction.
     *
     * @return bool
     */
    public function isCredit()
    {
        return $this->credit > 0;
    }

    /**
     * Get the transaction amount (debit or credit).
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->debit > 0 ? $this->debit : $this->credit;
    }

    /**
     * Get the transaction type (DEBIT or CREDIT).
     *
     * @return string
     */
    public function getType()
    {
        return $this->debit > 0 ? 'DEBIT' : 'CREDIT';
    }

    /**
     * Get the balance for this transaction detail.
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->debit - $this->credit;
    }

    /**
     * Validate that either debit or credit is set, but not both.
     *
     * @return bool
     */
    public function isValidTransaction()
    {
        return ($this->debit > 0 && $this->credit == 0) || ($this->credit > 0 && $this->debit == 0);
    }

    /**
     * Get formatted display text for the transaction.
     *
     * @return string
     */
    public function getDisplayText()
    {
        $amount = number_format($this->getAmount(), 2);
        $type = $this->getType();
        $account = $this->pucAccount ? $this->pucAccount->name : 'N/A';
        
        return "{$account} - {$type}: ${amount}";
    }
}