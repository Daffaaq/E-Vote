<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function indexlandingpage()
    {
        return view('landingpage.index');
    }
    public function index()
    {
        return view('Auth.login');
    }

    function login(Request $request)
    {
        $request->validate([
            'username' => 'required', // Mengganti 'username' dengan 'username' dan menambahkan validasi username
            'password' => 'required'
        ], [
            'username.required' => 'username wajib diisi', // Mengganti pesan validasi
            'password.required' => 'Password wajib diisi',
        ]);

        $infologin = [
            'username' => $request->username, // Menggunakan 'email' dari form input
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect('dashboardAdmin');
            } elseif ($user->role === 'superadmin') {
                return redirect('dashboardSuperadmin');
            } elseif ($user->role === 'voter') {
                return redirect('dashboardVoter');
            } else {
                return redirect()->route('login')->withErrors('Role pengguna tidak valid')->withInput();
            }
        } else {
            return redirect()->route('login')->withErrors('Email dan password tidak sesuai')->withInput();
        }
    }


    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
