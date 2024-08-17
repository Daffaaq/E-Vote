<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\jadwal_orasi;
use App\Models\jadwal_result_vote;
use App\Models\JadwalVotes;
use App\Models\Votes;
use App\Models\Periode;
use App\Models\profile;
use App\Models\SettingVote;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexSuperadmin()
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        $statusvote = SettingVote::select("id", "set_vote")->get();

        $statusvote1 = SettingVote::value('set_vote');

        $datavoter = Votes::with('student')->where('periode_id', $periode_id)->count();
        $datastudent = Students::count();
        $candidate = Candidates::where('periode_id', $periode_id)->select("id", "no_urut_kandidat", "nama_ketua", "slogan", "slug", "foto", "status")->get();
        $candidateIds = $candidate->pluck('id');

        // Menghitung jumlah votes untuk kandidat yang terdaftar pada periode aktif
        $datavotecandidate = Votes::where('periode_id', $periode_id)
            ->whereIn('candidate_id', $candidateIds)
            ->count();

        $nameCandidate = [];
        $candidates = Candidates::withCount([
            'votes' => function ($query) {
                $query->activePeriod();
            }
        ])->get();
        // dd($candidates);

        // Siapkan array untuk menyimpan hasil
        $nameCandidate = [];

        // Iterasi melalui kandidat dan simpan nama serta jumlah suara mereka dalam array
        foreach ($candidates as $candidate) {
            $nameCandidate[] = [
                'nama_ketua' => $candidate->nama_ketua,
                'votes_count' => $candidate->votes_count
            ];
        }
        // dd($nameCandidate);
        $candidateNames = array_column($nameCandidate, 'nama_ketua');
        $candidateVotes = array_column($nameCandidate, 'votes_count');
        // dd($candidateNames, $candidateVotes);
        // dd($candidates);
        // dd($datavotecandidate);
        // dd($candidate);
        // dd($datastudent);
        // dd($datavoter);
        // dd($statusvote1);
        return view('superadmin.Dashboard.index', compact('statusvote', 'datavoter', 'datastudent', 'candidateNames', 'candidateVotes', 'candidates'));
    }
    public function indexAdmin()
    {
        $statusvote = SettingVote::select("id", "set_vote")->get();

        $statusvote1 = SettingVote::value('set_vote');
        // dd($statusvote1);
        return view('Admin.Dashboard.index', compact('statusvote'));
    }
    public function indexVoter()
    {
        $user = Auth::user();
        $periode_id = Periode::where('actif', 1)->value('id'); // Mengambil id dari periode yang aktif

        // Mengambil data dari masing-masing tabel berdasarkan periode_id
        $jadwalVotes = JadwalVotes::where('periode_id', $periode_id)->select("tanggal_awal_vote", "tanggal_akhir_vote", "tempat_vote")->first();
        // dd($jadwalVotes);
        $jadwalResultVote = jadwal_result_vote::where('periode_id', $periode_id)->select("tanggal_result_vote", "jam_result_vote", "tempat_result_vote")->first();
        $jadwalOrasi = jadwal_orasi::where('periode_id', $periode_id)->select("tanggal_orasi_vote", "jam_orasi_mulai", "tempat_orasi")->first();
        $candidate = Candidates::where('periode_id', $periode_id)->select("id", "no_urut_kandidat", "nama_ketua", "slogan", "slug", "foto", "status")->get();
        $statusSetVote = SettingVote::first();
        $cekstatusvote = Votes::where('created_by', $user->id)->where('periode_id', $periode_id)->first();
        $profile = profile::first();

        // dd($statusSetVote);
        // dd($candidate);
        return view('Siswa.index', compact('jadwalVotes', 'jadwalResultVote', 'jadwalOrasi', 'candidate', 'statusSetVote', 'cekstatusvote', 'profile'));
    }

    public function detaiCandidate($slug)
    {
        $user = Auth::user();
        $periode_id = Periode::where('actif', 1)->value('id');
        // Ambil data kandidat berdasarkan slug
        $candidate = Candidates::where('periode_id', $periode_id)->where('slug', $slug)->first();

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

        $cekstatusvote = Votes::where('created_by', $user->id)->where('periode_id', $periode_id)->first();
        // Menghapus elemen duplikat berdasarkan content
        $uniqueItems = array_unique($items, SORT_REGULAR);

        $statusSetVote = SettingVote::first();
        $jadwalVotes = JadwalVotes::where('periode_id', $periode_id)->select("tanggal_awal_vote", "tanggal_akhir_vote", "tempat_vote")->first();

        // Mengirimkan data kandidat dan items ke view
        return view('Siswa.detail', compact('candidate', 'uniqueItems', 'statusSetVote', 'jadwalVotes', 'cekstatusvote'));
    }


    public function Settingvote(Request $request)
    {
        // Ambil nilai baru dari request
        $newStatus = $request->input('set_vote');

        // Update nilai di database menggunakan instance model
        $settingVote = SettingVote::first(); // Asumsikan hanya ada satu baris data
        if ($settingVote) {
            $settingVote->set_vote = $newStatus;
            $settingVote->save();

            // Berikan respons JSON
            $message = $newStatus ? 'setting berhasil di buka.' : 'setting berhasil di tutup.';
            return response()->json(['success' => true, 'message' => $message]);
        } else {
            return response()->json(['success' => false, 'message' => 'setting gagal.']);
        }
    }
}
