<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\jadwal_orasi;
use App\Models\jadwal_result_vote;
use App\Models\JadwalVotes;
use App\Models\Periode;
use App\Models\profile;
use App\Models\Students;
use App\Models\Votes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function customRounding($progress)
    {
        if ($progress >= 99 && $progress < 100) {
            return floor($progress); // Pembulatan ke bawah jika 99 atau lebih, tapi kurang dari 100
        } else {
            return ceil($progress); // Pembulatan ke atas untuk nilai lainnya
        }
    }
    public function indexlandingpage()
    {
        $periode_id = Periode::where('actif', 1)->value('id'); // Mengambil id dari periode yang aktif

        // Mengambil data dari masing-masing tabel berdasarkan periode_id
        $jadwalVotes = JadwalVotes::where('periode_id', $periode_id)->select("tanggal_awal_vote", "tanggal_akhir_vote", "tempat_vote")->first();
        $jadwalResultVote = jadwal_result_vote::where('periode_id', $periode_id)->select("tanggal_result_vote", "jam_result_vote", "tempat_result_vote")->first();
        $jadwalOrasi = jadwal_orasi::where('periode_id', $periode_id)->select("tanggal_orasi_vote", "jam_orasi_mulai", "tempat_orasi")->first();
        $candidate = Candidates::where('periode_id', $periode_id)->select("no_urut_kandidat", "nama_ketua", "slogan", "slug", "foto", "status")->get();
        $profile = profile::first();
        $datastudent = Students::count();
        $datavoter = Votes::with('student')->whereHas('candidate')->where('periode_id', $periode_id)->count();
        $progress = ($datavoter / $datastudent) * 100;
        $progress = $this->customRounding($progress);
        // dd($progress);
        return view('landingpage.index', compact('jadwalVotes', 'jadwalResultVote', 'jadwalOrasi', 'candidate', 'profile', 'progress', 'datavoter', 'datastudent'));
    }

    public function detaiCandidate($slug)
    {
        $candidate = Candidates::where('slug', $slug)->first();
        // Memproses konten HTML dari misi kandidat
        $htmlContent = $candidate->misi;
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Mengabaikan kesalahan untuk HTML yang tidak valid
        $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors(); // Membersihkan kesalahan setelah parsing

        $items = [];

        // Tag yang ingin diproses secara dinamis
        $tags = ['li', 'p', 'div'];

        // Loop melalui setiap tag dan kumpulkan elemen-elemen yang ditemukan
        foreach ($tags as $tag) {
            $elements = $dom->getElementsByTagName($tag);
            foreach ($elements as $element) {
                // Pastikan hanya menyimpan elemen jika belum ada di array untuk mencegah duplikasi
                $items[] = [
                    'tag' => $tag,
                    'content' => trim($element->textContent),
                ];
            }
        }

        // Menghapus elemen duplikat berdasarkan content
        $uniqueItems = array_unique($items, SORT_REGULAR);
        return view('landingpage.detail', compact('candidate', 'uniqueItems'));
    }
    public function index()
    {
        $profile = profile::first();
        return view('Auth.login', compact('profile'));
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
                $route = 'dashboard.admin';
            } elseif ($user->role === 'superadmin') {
                $route = 'dashboard.superadmin';
            } elseif ($user->role === 'voter') {
                $route = 'dashboard.voter';
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
