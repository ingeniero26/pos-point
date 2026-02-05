<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashMovement extends Model
{
    protected $table = 'cash_movements';

    protected $fillable = [
        'cash_register_session_id',
        'cash_movement_type_id',
        'amount',
        'description',
        'reference_document_type',
        'reference_document_number',
        'related_sale_id',
        'related_purchase_id',
        'related_third_party_id',
        'third_party_document_type',
        'third_party_document_number',
        'third_party_name',
        'transaction_time',
        'user_id',
        'company_id',
        'created_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        // Actualizar el saldo de la sesión cuando se guarda un movimiento
        static::saved(function ($movement) {
            if ($movement->cash_register_session_id) {
                $session = CashRegisterSession::find($movement->cash_register_session_id);
                if ($session) {
                    // Recalcular el saldo actual basado en todos los movimientos
                    $totalMovements = self::where('cash_register_session_id', $session->id)
                        ->sum('amount');
                    
                    $session->current_balance = $session->opening_balance + $totalMovements;
                    $session->saveQuietly(); // Evitar loop infinito
                }
            }
        });
    }

    public function cashRegisterSession()
    {
        return $this->belongsTo(CashRegisterSession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sale()
    {
        return $this->belongsTo(Invoices::class, 'related_sale_id');
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseModel::class, 'related_purchase_id');
    }

    public function movementType()
    {
        return $this->belongsTo(TypeMovementCash::class, 'cash_movement_type_id');
    }
}