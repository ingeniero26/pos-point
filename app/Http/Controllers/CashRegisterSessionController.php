<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\CashRegisterSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashRegisterSessionController extends Controller
{
   
  
        public function list(Request $request)
        {
            $cashRegisters = CashRegister::all(); // Cambia el nombre y trae todos los registros
            $sessions = CashRegisterSession::with('cashRegister', 'user')->orderBy('opened_at', 'desc')->get();
            return view('admin.cash_register_sessions.list', compact('sessions', 'cashRegisters'));
        }
   
    // Abrir caja
 
    public function open(Request $request)
    {
        $request->validate([
            'cash_register_id' => 'required|exists:cash_registers,id',
            'opening_balance' => 'required|numeric|min:0',
            'observations_opening' => 'nullable|string|max:500',
            'company_id' => 'required|exists:companies,id'
        ]);
    
        // Verificar permisos del usuario sobre la caja
        // if (!auth()->user()->can('open', CashRegister::find($request->cash_register_id))) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'No tiene permisos para abrir esta caja.'
        //     ], 403);
        // }
    
        // Verificar sesión existente
        if (CashRegisterSession::where('cash_register_id', $request->cash_register_id)
            ->where('status', 'Open')
            ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe una sesión abierta para esta caja.'
            ], 422);
        }
    
        try {
            $session = CashRegisterSession::create([
                'cash_register_id' => $request->cash_register_id,
                'user_id' => Auth::id(),
                'opening_balance' => $request->opening_balance,
                'current_balance' => $request->opening_balance,
                'opened_at' => now(),
                'status' => 'Open',
                'company_id' => $request->company_id,
                'created_by' => Auth::id(),
                'observations_opening' => $request->observations_opening,
            ]);
    
            // Buscar el tipo de movimiento para saldo inicial
            $movementType = \App\Models\TypeMovementCash::where('type', 'INGRESO')
                ->where('is_system_generated', true)
                ->where('name', 'Saldo Inicial')
                ->where('company_id', $request->company_id)
                ->where('is_delete', 0)
                ->first();
    
            if (!$movementType) {
                // Si no existe el tipo de movimiento, lo creamos
                $movementType = \App\Models\TypeMovementCash::create([
                    'name' => 'Saldo Inicial',
                    'type' => 'INGRESO',
                    'description' => 'Saldo inicial al abrir la caja',
                    'requires_third_party' => false,
                    'is_system_generated' => true,
                    'company_id' => $request->company_id,
                    'created_by' => Auth::id(),
                    'status' => 1,
                    'is_delete' => 0
                ]);
            }
    
            // Crear el movimiento de caja para el saldo inicial
            $cashMovement = new \App\Models\CashMovement([
                'cash_register_session_id' => $session->id,
                'cash_movement_type_id' => $movementType->id,
                'amount' => $request->opening_balance,
                'description' => 'Saldo inicial de apertura de caja',
                'transaction_time' => now(),
                'user_id' => Auth::id(),
                'company_id' => $request->company_id,
                'created_by' => Auth::id()
            ]);
            $cashMovement->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Caja abierta correctamente.',
                'session' => $session
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al abrir la caja: ' . $e->getMessage()
            ], 500);
        }
    }

public function close(Request $request, $id)
{
    $request->validate([
        'actual_closing_balance' => 'required|numeric|min:0',
        'observations_closing' => 'nullable|string|max:500'
    ]);

    try {
        $session = CashRegisterSession::findOrFail($id);

        if (!in_array(strtolower($session->status), ['open', 'Open'])) {
            return response()->json([
                'success' => false,
                'error' => 'Solo se pueden cerrar sesiones que estén abiertas.',
                'current_status' => $session->status
            ], 422);
        }

        // Calcular el saldo esperado basado en todos los movimientos
        $expected_closing_balance = $session->current_balance;

        // Buscar o crear el tipo de movimiento para cierre de caja
        $movementType = \App\Models\TypeMovementCash::firstOrCreate(
            [
                'name' => 'Cierre de Caja',
                'company_id' => $session->company_id,
                'is_system_generated' => true
            ],
            [
               // 'type' => 'SYSTEM',
                'description' => 'Movimiento de cierre de caja',
                'requires_third_party' => false,
                'created_by' => Auth::id(),
                'status' => 1,
                'is_delete' => 0
            ]
        );

        // Actualizar la sesión con todos los campos necesarios
        $session->update([
            'actual_closing_balance' => $request->actual_closing_balance,
            'expected_closing_balance' => $expected_closing_balance,
            'difference' => $request->actual_closing_balance - $expected_closing_balance,
            'closed_at' => now(),
            'status' => 'Closed',
            'observations_closing' => $request->observations_closing,
            'current_balance' => $request->actual_closing_balance // Actualizar el saldo actual
        ]);

        // Crear el movimiento de cierre
        $cashMovement = new \App\Models\CashMovement([
            'cash_register_session_id' => $session->id,
            'cash_movement_type_id' => $movementType->id,
            'amount' => $request->actual_closing_balance,
            'description' => 'Cierre de caja - Saldo final',
            'transaction_time' => now(),
            'user_id' => Auth::id(),
            'company_id' => $session->company_id,
            'created_by' => Auth::id()
        ]);
        $cashMovement->save();

        return response()->json([
            'success' => true,
            'message' => 'Caja cerrada correctamente.',
            'session' => $session
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Error al cerrar la caja: ' . $e->getMessage()
        ], 500);
    }
}
     // Ver detalles
    public function show($id)
    {
        $session = CashRegisterSession::with(['cashRegister', 'user', 'cashMovements' => function($query) {
            $query->orderBy('created_at', 'asc');
        }])->findOrFail($id);
        return view('admin.cash_register_sessions.show', compact('session'));
    }
}
