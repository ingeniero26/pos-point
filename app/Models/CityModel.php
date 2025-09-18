<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    //
    protected $table = 'cities';
    protected $fillable = ['dane_code','city_name'];

    public function departments()
    {
        return $this->belongsTo(DepartmentModel::class, 'department_id');
    }
    
}
