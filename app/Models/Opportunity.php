<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Opportunity extends Model
{
    protected $table = 'opportunities';
    
    protected $fillable = [
        'name', 
        'description', 
        'third_id', 
        'contact_name', 
        'contact_phone', 
        'contact_email',
        'source_id', 
        'stage_id', 
        'estimated_value', 
        'probability', 
        'estimated_closing_date',
        'closing_date', 
        'reason_lost', 
        'responsible_user_id', 
        'priority_id', 
        'status',
        'company_id', 
        'created_by', 
        'is_delete'
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
        'probability' => 'decimal:2',
        'estimated_closing_date' => 'date',
        'closing_date' => 'date',
        'is_delete' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'estimated_value' => 0.00,
        'probability' => 0.00,
        'is_delete' => false,
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_delete', false);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByStage($query, $stageId)
    {
        return $query->where('stage_id', $stageId);
    }

    public function scopeByResponsible($query, $userId)
    {
        return $query->where('responsible_user_id', $userId);
    }

    public function scopeOpen($query)
    {
        return $query->whereHas('stage', function($q) {
            $q->where('is_closing_stage', false);
        });
    }

    public function scopeClosed($query)
    {
        return $query->whereHas('stage', function($q) {
            $q->where('is_closing_stage', true);
        });
    }

    public function scopeWon($query)
    {
        return $query->whereHas('stage', function($q) {
            $q->where('is_closing_stage', true)
              ->where('closing_percentage', 100);
        });
    }

    public function scopeLost($query)
    {
        return $query->whereHas('stage', function($q) {
            $q->where('is_closing_stage', true)
              ->where('closing_percentage', 0);
        });
    }

    // Relationships
    public function third()
    {
        return $this->belongsTo(PersonModel::class, 'third_id');
    }

    public function source()
    {
        return $this->belongsTo(ContactSource::class, 'source_id');
    }

    public function stage()
    {
        return $this->belongsTo(OpportunityStage::class, 'stage_id');
    }

    public function priority()
    {
        return $this->belongsTo(OpportunityPriority::class, 'priority_id');
    }

   

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getEstimatedValueFormattedAttribute()
    {
        return '$' . number_format($this->estimated_value, 2);
    }

    public function getProbabilityFormattedAttribute()
    {
        return number_format($this->probability, 2) . '%';
    }

    public function getStatusAttribute()
    {
        if ($this->stage && $this->stage->is_closing_stage) {
            return $this->stage->closing_percentage == 100 ? 'won' : 'lost';
        }
        return 'open';
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'won':
                return 'Ganada';
            case 'lost':
                return 'Perdida';
            default:
                return 'Abierta';
        }
    }

    public function getDaysToCloseAttribute()
    {
        if (!$this->estimated_closing_date) {
            return null;
        }
        
        return now()->diffInDays($this->estimated_closing_date, false);
    }

    public function getIsOverdueAttribute()
    {
        return $this->days_to_close !== null && $this->days_to_close < 0 && $this->status === 'open';
    }

    // Mutators
    public function setProbabilityAttribute($value)
    {
        $this->attributes['probability'] = max(0, min(100, $value));
    }

    // Methods
    public function softDelete()
    {
        $this->is_delete = true;
        return $this->save();
    }

    public function restore()
    {
        $this->is_delete = false;
        return $this->save();
    }

    public function isActive()
    {
        return !$this->is_delete;
    }

    public function isOpen()
    {
        return $this->status === 'open';
    }

    public function isClosed()
    {
        return in_array($this->status, ['won', 'lost']);
    }

    public function isWon()
    {
        return $this->status === 'won';
    }

    public function isLost()
    {
        return $this->status === 'lost';
    }

    public function moveToStage($stageId, $reason = null)
    {
        $oldStage = $this->stage_id;
        $this->stage_id = $stageId;
        
        // Si se mueve a una etapa de cierre perdida, guardar la razón
        $newStage = OpportunityStage::find($stageId);
        if ($newStage && $newStage->is_closing_stage && $newStage->closing_percentage == 0) {
            $this->reason_lost = $reason;
            $this->closing_date = now();
        } elseif ($newStage && $newStage->is_closing_stage && $newStage->closing_percentage == 100) {
            $this->closing_date = now();
        }
        
        // Actualizar probabilidad basada en la etapa
        if ($newStage) {
            $this->probability = $newStage->closing_percentage;
        }
        
        return $this->save();
    }
}

