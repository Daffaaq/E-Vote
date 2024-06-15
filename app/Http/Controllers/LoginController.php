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
