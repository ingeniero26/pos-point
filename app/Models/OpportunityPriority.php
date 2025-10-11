<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpportunityPriority extends Model
{
    //
    protected $table = 'opportunity_priorities';
    protected $fillable = ['name', 'color', 'created_by'];


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function company() {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
