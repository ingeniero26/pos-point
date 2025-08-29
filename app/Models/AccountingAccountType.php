<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingAccountType extends Model
{
    protected $table = 'accounting_account_types';
    //
    public function accounts()
    {
        return $this->hasMany(AccountingAccount::class, 'account_type_id');
    }
}
