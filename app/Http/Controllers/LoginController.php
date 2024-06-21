<?php

namespace App\Http\Controllers;

use App\Models\jadwal_orasi;
use App\Models\jadwal_result_vote;
use App\Models\JadwalVotes;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function indexlandingpage()
    {
        $periode_id = Periode::where('actif', 1)->value('id'); // Mengambil id dari periode yang aktif

        // Mengambil data dari masing-masing tabel berdasarkan periode_id
        $jadwalVotes = JadwalVotes::where('periode_id', $periode_id)->select("id", "tanggal_awal_vote", "tanggal_akhir_vote", "tempat_vote")->first();
        $jadwalResultVote = jadwal_result_vote::where('periode_id', $periode_id)->select("id", "tanggal_result_vote", "jam_result_vote", "tempat_result_vote")->first();
        $jadwalOrasi = jadwal_orasi::where('periode_id', $periode_id)->select("id", "tanggal_orasi_vote", "jam_orasi_mulai", "tempat_orasi")->first();
        return view('landingpage.index', compact('jadwalVotes', 'jadwalResultVote', 'jadwalOrasi'));
    }
    public function index()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $route = '';

            if ($user->role === 'admin') {
                $route = 'dashboardAdmin';
            } elseif ($user->role === 'superadmin') {
                $route = 'dashboard.superadmin';
            } elseif ($user->role === 'voter') {
                $route = 'dashboardVoter';
            } else {
                return redirect()->route('login')->with('error', 'Role pengguna tidak valid')->withInput();
            }

            return redirect()->route($route)->with('success', 'Login berhasil!');
        } else {
            return redirect()->route('login')->with('error', 'Username dan password tidak sesuai')->withInput();
        }
    }





    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
