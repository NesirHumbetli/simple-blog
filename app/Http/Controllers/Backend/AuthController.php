<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        //Sade yol v1 eger giris olunubsa login etmek blok edilsin.
        /* if(Auth::check()){
            return back();
        } */
        return view('backend.auth.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials))
        {
            toastr()->success('Tekrar Xos Geldiniz '.Auth::user()->name);
            return redirect()->route('manage.dashboard');
        }
        return redirect()->route('manage.login')->withErrors('Email veya Sifre Yanlisdir');
    }

    public function logout()
    {
        
        Auth::logout();
        return redirect()->route('manage.login');
    }
}
