<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegisterSession extends Model
{
    protected $table = 'cash_register_sessions';
    protected $fillable = [
        'cash_register_id',
        'user_id',
        'opening_balance',
        'actual_closing_balance',
        'expected_closing_balance',
        'difference',
        'current_balance',
        'opened_at',
        'closed_at',
        'status',
        'company_id',
        'created_by',
        'observations_opening',
        'observations_closing'
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_balance' => 'decimal:2',
        'actual_closing_balance' => 'decimal:2',
        'expected_closing_balance' => 'decimal:2',
        'difference' => 'decimal:2',
        'current_balance' => 'decimal:2'
    ];

    protected $hidden = [
        'created_by',
        'updated_by'
    ];

    // Eliminamos $appends ya que no estamos usando los formatted attributes
    // Eliminamos $dates ya que ya están definidos en $casts

    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class, 'cash_register_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    public function cashMovements()
    {
        return $this->hasMany(CashMovement::class);
    }
}
