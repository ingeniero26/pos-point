<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    //
    public function list()
    {
        return view('admin.purchase_returns.list');
    }
}
