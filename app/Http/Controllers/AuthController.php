<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // view login 
    public function index() {

        return view('modules.auth.index');
    }


    // proses login
    public function proses( Request $request ) {

        $request->validate([

            'email'     => 'required|email',
            'password'  => 'required'
        ],[
            'email.required'    => "Email wajib diisi",
            'email.email'       => "Masukkan email yang valid",

            'password.required' => "Kata sandi wajib diisi"
        ]);


        // cek 
        $credentials = request(['email', 'password']);
        if ( Auth::attempt($credentials) ) {

            $request->session()->regenerate();
            return redirect()->intended('dashboard');

        } else {

            $html = '<div class="alert alert-danger mt-10 text-left">Pemberitahuan<br><small>Login tidak berhasil, harap periksa email dan kata sandi anda</small></div>';
            Session::flash('message', $html);
            return redirect('login');
        }
    }


    // logout
    public function logout( Request $request ) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
