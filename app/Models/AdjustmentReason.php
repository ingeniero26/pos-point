<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdjustmentType;
use App\Models\Companies;
use App\Models\User;

class AdjustmentReason extends Model
{
    //
    protected $table = 'adjustment_reason';

    public function adjustment_types()
    {
        return $this->belongsTo(AdjustmentType::class, 'adjustment_type_id');
    }
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
