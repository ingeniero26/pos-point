<?php

namespace App\Http\Controllers;

use App\Models\AccountingMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountingMovementController extends Controller
{
    // obtener los movimientos contables con su detalle
    public function list()
    {
        return view('admin.account_movements.list');
    }

    // obtener los movimientos contables con su detalle
    public function getAccountMovements(Request $request)
    {
        
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountingMovement $accountingMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountingMovement $accountingMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountingMovement $accountingMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountingMovement $accountingMovement)
    {
        //
    }
}
