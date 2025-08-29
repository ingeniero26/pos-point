<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunicateController extends Controller
{
    //
    public function SendEmail()
    {
        return view('admin.communicate.sendEmail');
    }
    public function SendEmailStore(Request $request)
    {
        // Validate the request data
    dd($request->all());
    }
}
