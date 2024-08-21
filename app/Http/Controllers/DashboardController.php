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
use App\Http\Requests\UpdateAuthRequest;
use App\Services\AuthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\VotesExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardController extends Controller
{
    public function indexSuperadmin()
    {
        // Ambil periode aktif dan setting vote dalam satu kali query masing-masing
        $periode_id = DB::table('periode')->where('actif', 1)->value('id');
        $statusvote = SettingVote::select('id', 'set_vote')->get();

        // Ambil jumlah suara per kandidat yang terdaftar pada periode aktif
        $candidates = Candidates::where('periode_id', $periode_id)
            ->select('id', 'no_urut_kandidat', 'nama_ketua', 'nama_wakil_ketua', 'slogan', 'slug', 'foto', 'status')
            ->withCount(['votes' => function ($query) use ($periode_id) {
                $query->where('periode_id', $periode_id);
            }])
            ->get();

        $countCandidate = $candidates->count();
        // dd($countCandidate);
        // dd($candidates);
        // Hitung jumlah voter dan jumlah student
        $datavoter = Votes::where('periode_id', $periode_id)->count();
        $datastudent = Students::count();

        // Siapkan array untuk menyimpan nama kandidat dan jumlah suara mereka
        $candidateNames = $candidates->map(function ($candidate) {
            if ($candidate->status == 'ganda') {
                return $candidate->nama_ketua . ' & ' . $candidate->nama_wakil_ketua;
            }
            return $candidate->nama_ketua;
        })->toArray();
        // dd($candidateNames);
        $candidateVotes = $candidates->pluck('votes_count')->toArray();

        // Hitung apakah total votes sudah melebihi 15% dari total siswa
        $percentageVotes = ($datavoter / $datastudent) * 100;
        $isAboveThreshold = ceil($percentageVotes) > 5;

        // dd(floor($percentageVotes));
        // dd($percentageVotes);
        // dd($isAboveThreshold);

        // Render view dengan data yang telah disiapkan
        return view('superadmin.Dashboard.index', compact('statusvote', 'countCandidate', 'datavoter', 'datastudent', 'candidateNames', 'candidateVotes', 'candidates', 'isAboveThreshold'));
    }

    public function export_excel(): BinaryFileResponse
    {
        $periode_id = DB::table('periode')->where('actif', 1)->value('periode_nama');
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = 'persentase_hasil_pemilihan_' . $periode_id . '_' . $timestamp . '.xlsx';
        return Excel::download(new VotesExport, $filename);
    }


    public function indexAdmin()
    {
        $statusvote = SettingVote::select("id", "set_vote")->get();

        $statusvote1 = SettingVote::value('set_vote');
        // dd($statusvote1);
        return view('Admin.Dashboard.index', compact('statusvote'));
    }
    // public function indexVoter()
    // {
    //     $user = Auth::user();
    //     $periode_id = Periode::where('actif', 1)->value('id'); // Mengambil id dari periode yang aktif

    //     // Mengambil data dari masing-masing tabel berdasarkan periode_id
    //     $jadwalVotes = JadwalVotes::where('periode_id', $periode_id)->select("tanggal_awal_vote", "tanggal_akhir_vote", "tempat_vote")->first();
    //     // dd($jadwalVotes);
    //     $jadwalResultVote = jadwal_result_vote::where('periode_id', $periode_id)->select("tanggal_result_vote", "jam_result_vote", "tempat_result_vote")->first();
    //     $jadwalOrasi = jadwal_orasi::where('periode_id', $periode_id)->select("tanggal_orasi_vote", "jam_orasi_mulai", "tempat_orasi")->first();
    //     $candidate = Candidates::where('periode_id', $periode_id)->select("id", "no_urut_kandidat", "nama_ketua", "slogan", "slug", "foto", "status")->get();
    //     $statusSetVote = SettingVote::first();
    //     $cekstatusvote = Votes::where('created_by', $user->id)->where('periode_id', $periode_id)->first();
    //     $profile = profile::first();

    //     // dd($statusSetVote);
    //     // dd($candidate);
    //     return view('Siswa.index', compact('jadwalVotes', 'jadwalResultVote', 'jadwalOrasi', 'candidate', 'statusSetVote', 'cekstatusvote', 'profile'));
    // }

    public function indexVoter()
    {
        $user = Auth::user();

        // Menggunakan Query Builder untuk query sederhana dan pengambilan nilai tunggal
        $periode_id = DB::table('periode')->where('actif', 1)->value('id'); // Mengambil id dari periode yang aktif

        // Menggunakan Query Builder untuk pengambilan data sederhana
        $jadwalVotes = DB::table('jadwal_votes')
            ->where('periode_id', $periode_id)
            ->select("tanggal_awal_vote", "tanggal_akhir_vote", "tempat_vote")
            ->first();

        $jadwalResultVote = DB::table('jadwal_result_votes')
            ->where('periode_id', $periode_id)
            ->select("tanggal_result_vote", "jam_result_vote", "tempat_result_vote")
            ->first();

        $jadwalOrasi = DB::table('jadwal_orasis')
            ->where(
                'periode_id',
                $periode_id
            )
            ->select("tanggal_orasi_vote", "jam_orasi_mulai", "tempat_orasi")
            ->first();

        // Menggunakan Eloquent untuk data yang membutuhkan relasi dan manipulasi model
        $candidate = Candidates::where('periode_id', $periode_id)
            ->select("id", "no_urut_kandidat", "nama_ketua", "nama_wakil_ketua", "slogan", "slug", "foto", "foto_wakil", "status")
            ->get();

        // Menggunakan Eloquent karena SettingVote mungkin membutuhkan manipulasi model
        $statusSetVote = SettingVote::first();

        // Menggunakan Eloquent untuk Votes karena melibatkan data user dan mungkin ada relasi
        $cekstatusvote = Votes::where('created_by', $user->id)
            ->where('periode_id', $periode_id)
            ->first();

        // Menggunakan Eloquent untuk Profile
        $profile = Profile::first();

        return view('Siswa.index', compact('jadwalVotes', 'jadwalResultVote', 'jadwalOrasi', 'candidate', 'statusSetVote', 'cekstatusvote', 'profile'));
    }



    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function updateProfile(UpdateAuthRequest $request)
    {
        // Ambil pengguna yang sedang diautentikasi
        $user = Auth::user();

        // Ambil data yang telah tervalidasi dari request
        $validatedData = $request->validated();

        // Panggil service untuk memperbarui profil
        $profile = $this->authService->updateProfile($user, $validatedData);

        if ($profile) {
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'profile' => $profile
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Profil tidak ditemukan'
            ], 404);
        }
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
