<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    //
    protected $table = 'cities';

    public function departments()
    {
        return $this->belongsTo(DepartmentModel::class, 'department_id');
    }
    
}
