<?php

namespace App\Console\Commands;

use App\Models\CashRegisterSession;
use App\Models\CashMovement;
use Illuminate\Console\Command;

class RecalculateCashBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cash:recalculate-balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalcula los saldos actuales de todas las sesiones de caja basado en los movimientos registrados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando recalculation de saldos de caja...');

        $sessions = CashRegisterSession::all();
        $updatedCount = 0;

        foreach ($sessions as $session) {
            // Obtener la suma total de movimientos
            $totalMovements = CashMovement::where('cash_register_session_id', $session->id)
                ->sum('amount');

            // Calcular el nuevo saldo
            $newBalance = $session->opening_balance + $totalMovements;

            // Actualizar si el saldo es diferente
            if ($newBalance != $session->current_balance) {
                $oldBalance = $session->current_balance;
                $session->current_balance = $newBalance;
                $session->save();
                
                $this->line("Sesión #{$session->id}: ${oldBalance} → ${newBalance}");
                $updatedCount++;
            }
        }

        $this->info("✓ Recalculation completado. {$updatedCount} sesiones actualizadas.");
    }
}
