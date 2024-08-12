<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\jadwal_orasi;
use App\Models\jadwal_result_vote;
use App\Models\JadwalVotes;
use App\Models\Periode;
use App\Models\SettingVote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexSuperadmin()
    {
        $statusvote = SettingVote::select("id", "set_vote")->get();

        $statusvote1 = SettingVote::value('set_vote');
        // dd($statusvote1);
        return view('superadmin.Dashboard.index', compact('statusvote'));
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
        $periode_id = Periode::where('actif', 1)->value('id'); // Mengambil id dari periode yang aktif

        // Mengambil data dari masing-masing tabel berdasarkan periode_id
        $jadwalVotes = JadwalVotes::where('periode_id', $periode_id)->select("tanggal_awal_vote", "tanggal_akhir_vote", "tempat_vote")->first();
        $jadwalResultVote = jadwal_result_vote::where('periode_id', $periode_id)->select("tanggal_result_vote", "jam_result_vote", "tempat_result_vote")->first();
        $jadwalOrasi = jadwal_orasi::where('periode_id', $periode_id)->select("tanggal_orasi_vote", "jam_orasi_mulai", "tempat_orasi")->first();
        $candidate = Candidates::where('periode_id', $periode_id)->select("no_urut_kandidat", "nama_ketua", "slogan", "slug", "foto", "status")->get();
        // dd($candidate);
        return view('Siswa.index', compact('jadwalVotes', 'jadwalResultVote', 'jadwalOrasi', 'candidate'));
    }

    public function detaiCandidate($slug)
    {
        // Ambil data kandidat berdasarkan slug
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

        // Mengirimkan data kandidat dan items ke view
        return view('Siswa.detail', compact('candidate', 'uniqueItems'));
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
