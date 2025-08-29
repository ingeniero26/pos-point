<?php

namespace App\Http\Controllers;

use App\Models\CashMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashMovementController extends Controller
{
    public function list()
    {
        $movements = CashMovement::with(['cashRegisterSession.cashRegister', 'user'])
            ->where('company_id', Auth::user()->company_id)
            ->orderBy('transaction_time', 'desc')
            ->get();

        return view('admin.cash_movements.list', compact('movements'));
    }
}