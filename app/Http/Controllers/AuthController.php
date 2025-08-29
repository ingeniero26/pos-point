<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Mail\ForgotPaswwordMail;
use Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        return view('auth.login');
    }
    public function login_post(Request $request)
    {
       if(Auth::attempt(['email'=> $request->email, 'password' => $request->password],true))
       {
         if(Auth::User()->is_role == '1')
         {
            return redirect()->intended('admin/dashboard');
         }
         else if(Auth::user()->is_role == '2')
         {
            return redirect()->intended('user/dashboard');
         } 
         else if(Auth::user()->is_role == '3')
         {
            return redirect()->intended('super/dashboard');
         }
         
         else {
            return redirect('/')->with('error', 'Email no valido');
         }
       } else {
        return redirect()->back()->with('error', 'Usuario o clave incorrectos');
       }
    }
    // registro
public function register(Request $request)
{
    return view('auth.register');
}

public function register_post(Request $request)
{
    request()->validate([
        'name'=> 'required',
        'email'=> 'required|email|unique:users',
        'password'=> 'required|min:6',
        'confirm_passord'=> 'required_with:password|same:password|min:6',
    ]);

    $user = new User;
    $user->name = trim($request->name);
    $user->email = trim($request->email);
    $user->password = Hash::make($request->password);
    $user->is_role = 1;
    $user->company_id = 1;
     if (!empty($request->file('profile_pic'))) {

        $ext = $request->file('profile_pic')->getClientOriginalExtension();
        $file = $request->file('profile_pic');
        $randomStr = date('Ymdhis') . Str::random(20);
        $filename = strtolower($randomStr) . '.' . $ext;
        $file->move('upload/profile/', $filename);
        $user->profile_pic = $filename;
    }
    $user->save();
    return redirect('/')->with('success','Usuario registrado con exito');
}
    public function logout(Request $request)
    {
        Auth::logout();
        return request(url('/'));
    }
}
