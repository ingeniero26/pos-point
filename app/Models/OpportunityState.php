<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpportunityState extends Model
{
    //
    protected $table = 'opportunity_states';
    protected $fillable = ['name', 'description', 'is_delete'];
}
