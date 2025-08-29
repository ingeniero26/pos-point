<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorModel extends Model
{
    //
    protected $table= 'colors';
    protected $fillable = ['name_color', 'code'];
    
}
