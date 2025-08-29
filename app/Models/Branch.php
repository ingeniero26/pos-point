<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $table = 'branches';

    // relacion empresa
    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
    public function countries() {
        return $this->belongsTo(CountryModel::class, 'country_id');
    }
    public function departments() 
    {
        return $this->belongsTo(DepartmentModel::class, 'department_id');
    }

    public function cities()
    {
        return $this->belongsTo(CityModel::class, 'city_id');
    }

    public function branchTypes()
    {
        return $this->belongsTo(BranchType::class, 'branch_type_id');
    }

    
    

}
