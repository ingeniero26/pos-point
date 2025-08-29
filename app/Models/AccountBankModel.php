<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountBankModel extends Model
{
    protected $table = 'bank_accounts';
    
    protected $fillable = [
        'bank_id',
        'account_type_id',
        'currency_id',
        'number',
        'description',
        'amount',
        'available_balance',
        'status',
        'company_id',
        'created_by',
        'is_delete'
    ];
    
    public function banks()
    {
        return $this->belongsTo(BankingInstitutionsModel::class, 'bank_id');
    }

    public function account_types()
    {
        return $this->belongsTo(AccountTypesModel::class, 'account_type_id');
    }
    public function currencies() {
        return $this->belongsTo(CurrenciesModel::class, 'currency_id');
    }

}
