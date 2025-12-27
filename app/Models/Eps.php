<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{
    //
    protected $table = 'health_providers';
    protected $fillable = ['dane_code','nit', 'name', 'city_id', 'address', 'phone',
     'email','company_id', 'created_by'];

     // relacion con la tabla ciudades
        public function city()
        {
            return $this->belongsTo(CityModel::class);
        }

    // relacion con la tabla empresas
        public function company()
        {
            return $this->belongsTo(Companies::class);
        }
    
    // relacion con la tabla usuarios
        public function creatorUser()
        {
            return $this->belongsTo(User::class, 'created_by');
        }
    
}
