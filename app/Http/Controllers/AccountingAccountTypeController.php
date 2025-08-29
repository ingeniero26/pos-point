<?php

namespace App\Http\Controllers;

use App\Models\AccountingAccountType;
use App\Models\AccountTypesModel;
use Illuminate\Http\Request;

class AccountingAccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        return view('admin.account_type.list');
    }
    function getAccountingAccountTypes() {
        // retornar un json 
        $accountingAccountType = AccountingAccountType::where('is_delete', 0)->get();
        return response()->json($accountingAccountType);

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
    public function show(AccountingAccountType $accountingAccountType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountingAccountType $accountingAccountType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountingAccountType $accountingAccountType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountingAccountType $accountingAccountType)
    {
        //
    }
}
