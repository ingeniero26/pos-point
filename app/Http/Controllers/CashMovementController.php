<?php

namespace App\Http\Controllers;

use App\Models\CashMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CashMovementController extends Controller
{
    public function list()
    {
        $movements = CashMovement::with([
            'cashRegisterSession:id,cash_register_id,user_id,opening_balance,status',
            'cashRegisterSession.cashRegister:id,name,location_description',
            'user:id,name,email'])
            ->select('id', 'cash_register_session_id', 
            'cash_movement_type_id', 
            'amount', 'description',
             'transaction_time', 'user_id', 'company_id')
            ->where('company_id', Auth::user()->company_id)
            ->orderByDesc('transaction_time')
            ->paginate(20);

        // Calcular totales globales (no solo de la página)
        $companyId = Auth::user()->company_id;

        $total_ingresos = (float) CashMovement::where('company_id', $companyId)
            ->where('amount', '>', 0)
            ->sum('amount');

        // Sumar los montos negativos como positivos para totales de egreso
        $total_egresos = (float) CashMovement::where('company_id', $companyId)
            ->where('amount', '<', 0)
            ->select(DB::raw('COALESCE(SUM(ABS(amount)),0) as total'))
            ->value('total');

        $balance = $total_ingresos - $total_egresos;

        return view('admin.cash_movements.list', compact('movements', 'total_ingresos', 'total_egresos', 'balance'));
    }
}