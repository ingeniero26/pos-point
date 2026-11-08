<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'employees';
   
    protected $fillable = [
        'person_id',
        'employee_code',
        'position_id',
        'area_id',
        'hire_date',
        'termination_date',
        'salary',
        'salary_type',
        'payment_method',
        'bank_account_id',
        'health_provider_id',
        'pension_fund_id',
        'arl_provider_id',
        'compensation_fund_id',
        'contract_type_id',
        'work_schedule',
        'emergency_contact',
        'emergency_phone',
        'status',
        'company_id',
        'created_by'
    ];

    public function person()
    {
        return $this->belongsTo(PersonModel::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(AccountBankModel::class);
    }

    public function healthProvider()
    {
        return $this->belongsTo(Eps::class);
    }

    public function pensionFund()
    {
        return $this->belongsTo(PensionFound::class);
    }

    public function arlProvider()
    {
        return $this->belongsTo(ArlProvider::class);
    }

    public function compensationFund()
    {
        return $this->belongsTo(CompensationFund::class);
    }

    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    
}
