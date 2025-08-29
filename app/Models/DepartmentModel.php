<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    //
    protected $table = 'departments';
    protected $fillable = ['name_department'];

    public function countries() {
        return $this->belongsTo(CountryModel::class, 'country_id');
    }

    public function cities() {
        return $this->hasMany(CityModel::class, 'department_id');
    }
}
