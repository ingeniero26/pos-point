<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrenciesModel extends Model
{
    //
    protected $table = 'currencies';
    // relacion con items
    public function items()
    {
        return $this->hasMany('App\Models\ItemsModel');
    }
}
