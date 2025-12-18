<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /*
    |----------------------------------------------------------
    | LOGIN FORM
    |----------------------------------------------------------
    */
    public function login()
    {
        return view('auth.login');
    }

    /*
    |----------------------------------------------------------
    | LOGIN VERIFY
    |----------------------------------------------------------
    */
    public function verify(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // redirect ke dashboard admin
            return redirect()->route('admin.beranda');
        }

        return back()->with('pesan', 'Email atau password salah');
    }

    /*
    |----------------------------------------------------------
    | REGISTER FORM
    |----------------------------------------------------------
    */
    public function register()
    {
        return view('auth.register');
    }

    /*
    |----------------------------------------------------------
    | REGISTER SAVE
    |----------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('auth.login')
            ->with('pesan', 'Registrasi berhasil, silakan login');
    }

    /*
    |----------------------------------------------------------
    | LOGOUT
    |----------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
