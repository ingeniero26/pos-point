<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    //
    protected $table = 'contacts';
    public function identification_type()
    {
        return $this->belongsTo(IdentificationTypeModel::class, 'identification_type_id');
    }
    public function departments() 
    {
        return $this->belongsTo(DepartmentModel::class, 'department_id');
    }

    public function cities()
    {
        return $this->belongsTo(CityModel::class, 'city_id');
    }



}
