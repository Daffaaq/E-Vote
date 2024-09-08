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
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\VotesExport;
use App\Models\Log as ModelsLog;
use App\Services\UserService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardController extends Controller
{
    public function indexSuperadmin()
    {
        $user = Auth::user();
        if ($user->role !== 'superadmin') {
            // Redirect or abort if the user is not a superadmin
            abort(403, 'Unauthorized action.');
        }
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

    public function export_vote_pdf()
    {
        $periode_nama = DB::table('periode')->where('actif', 1)->value('periode_nama');
        $periode_id = DB::table('periode')->where('actif', 1)->value('id');
        $totalVotes = Votes::where('periode_id', $periode_id)->count();

        // Ambil status kandidat yang pertama ditemukan
        $statusCandidate = DB::table('candidates')
            ->where('periode_id', $periode_id)
            ->pluck('status')
            ->first();
        // dd($statusCandidate);

        // Modifikasi query berdasarkan status
        if ($statusCandidate === 'perseorangan') {
            $candidate = DB::table("candidates")
                ->leftJoin("votes", "votes.candidate_id", "=", "candidates.id")
                ->where('candidates.periode_id', $periode_id)
                ->select(array(
                    "candidates.nama_ketua AS nama",
                    DB::raw("COUNT(votes.candidate_id) as jumlah_suara"),
                    DB::raw("ROUND((COUNT(votes.candidate_id) * 100 / $totalVotes), 2) as persentase")
                ))
                ->groupBy("candidates.id", "candidates.nama_ketua")
                ->get()
                ->map(function ($item) {
                    // Set jumlah_suara dan persentase ke 0 jika null
                    $item->jumlah_suara = $item->jumlah_suara ?? 0;
                    $item->persentase = $item->persentase ?? 0;
                    return $item;
                });
        } else if ($statusCandidate === 'ganda') {
            $candidate = DB::table("candidates")
                ->leftJoin("votes", "votes.candidate_id", "=", "candidates.id")
                ->where('candidates.periode_id', $periode_id)
                ->select(array(
                    "candidates.nama_ketua AS nama_ketua",
                    "candidates.nama_wakil_ketua AS nama_wakil",
                    DB::raw("COUNT(votes.candidate_id) as jumlah_suara"),
                    DB::raw("ROUND((COUNT(votes.candidate_id) * 100 / $totalVotes), 2) as persentase")
                ))
                ->groupBy("candidates.id", "candidates.nama_ketua", "candidates.nama_wakil_ketua")
                ->get()
                ->map(function ($item) {
                    // Set jumlah_suara dan persentase ke 0 jika null
                    $item->jumlah_suara = $item->jumlah_suara ?? 0;
                    $item->persentase = $item->persentase ?? 0;
                    return $item;
                });
        } else {
            // Tangani kondisi lain jika ada
            $candidate = collect(); // Atau bisa ditangani sesuai kebutuhan
        }
        $timestamp = Carbon::now()->format('Y-m-d H-i-s');
        // dd($timestamp);

        $filename = Session::get('chart_filename', '');
        // dd($filename);
        $logoPath = storage_path('app/public/charts/' . $filename);

        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        } else {
            Log::error('Image file not found: ' . $logoPath);
        }
        // dd($logoBase64);
        $pdf = Pdf::loadView('exports.votes_pdf', [
            'candidate' => $candidate,
            'counting' => $totalVotes,
            'timestamp' => $timestamp,
            'periode_nama' => $periode_nama,
            'logoBase64' => $logoBase64,
            'title' => 'Laporan Hasil Perhitungan Suara',
            'statusCandidate' => $statusCandidate
        ]);
        return $pdf->stream();
    }

    public function indexAdmin()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            // Redirect or abort if the user is not a superadmin
            abort(403, 'Unauthorized action.');
        }
        $statusvote = SettingVote::select("id", "set_vote")->get();

        $statusvote1 = SettingVote::value('set_vote');

        $user = Auth::user();
        if ($user->role !== 'admin') {
            // Redirect or abort if the user is not a superadmin
            abort(403, 'Unauthorized action.');
        }
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
        // dd($statusvote1);
        return view('Admin.Dashboard.index', compact('statusvote', 'countCandidate', 'datavoter', 'datastudent', 'candidateNames', 'candidateVotes', 'candidates', 'isAboveThreshold'));
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

    public function profileSuperadmin()
    {
        $user = Auth::user();
        // dd($user);
        // Check if the user has the 'superadmin' role
        if ($user->role !== 'superadmin') {
            // Redirect or abort if the user is not a superadmin
            abort(403, 'Unauthorized action.');
        }

        return view('superadmin.Dashboard.profile', compact('user'));
    }
    public function profileAdmin()
    {
        $user = Auth::user();
        // dd($user);
        // Check if the user has the 'superadmin' role
        if ($user->role !== 'admin') {
            // Redirect or abort if the user is not a superadmin
            abort(403, 'Unauthorized action.');
        }

        return view('admin.Dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Validasi file gambar
        $request->validate([
            'foto_profile' => 'required|image',
        ]);

        $user = Auth::user();

        // Hapus gambar lama jika ada
        if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
            Storage::disk('public')->delete($user->foto_profile);
        }

        // Simpan gambar baru
        $path = $request->file('foto_profile')->store('profile_photos', 'public');

        // Perbarui gambar profil pengguna dengan path lengkap
        $user->foto_profile = $path;
        // dd($user->foto_profile);
        $user->save();

        $currentUrl = url()->current();
        $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);

        $log = new ModelsLog();
        $log->action = 'update';
        $log->url = $cleanedUrl;
        $log->tanggal = now()->format('Y-m-d');
        $log->waktu = now()->format('H:i:s');
        $log->data = 'User Name: ' . $user->name . ' | Profile picture updated.';
        $log->periode_id = Periode::where('actif', 1)->value('id'); // Ambil periode yang aktif
        $log->user_id = $user->id;
        $log->save();
        // dd($user);
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Profile picture updated successfully');
    }

    public function deleteProfilePhoto(Request $request)
    {
        $user = Auth::user();

        // Periksa apakah pengguna memiliki foto profil
        if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
            // Hapus foto dari storage
            Storage::disk('public')->delete($user->foto_profile);

            // Set kolom foto_profile ke null
            $user->foto_profile = null;
            $user->save();

            $currentUrl = url()->current();
            $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);

            $log = new ModelsLog();
            $log->action = 'delete';
            $log->url = $cleanedUrl;
            $log->tanggal = now()->format('Y-m-d');
            $log->waktu = now()->format('H:i:s');
            $log->data = 'User Name: ' . $user->name . ' | Profile picture deleted.';
            $log->periode_id = Periode::where('actif', 1)->value('id'); // Ambil periode yang aktif
            $log->user_id = $user->id;
            $log->save();

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil yang ditemukan.');
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();
        if ($user->role !== 'superadmin' && 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Your current password does not match our records.',
            ]);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        $currentUrl = url()->current();
        $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);

        $log = new ModelsLog();
        $log->action = 'update';
        $log->url = $cleanedUrl;
        $log->tanggal = now()->format('Y-m-d');
        $log->waktu = now()->format('H:i:s');
        $log->data = 'User Name: ' . $user->name . ' | Password changed.'; // Mengganti ID dengan Name
        $log->periode_id = Periode::where('actif', 1)->value('id'); // Ambil periode yang aktif
        $log->user_id = $user->id;
        $log->save();

        return redirect()->back()->with('success', 'Password changed successfully');
    }

    protected $userService;
    protected $authService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function updateProfileSuperadmin(Request $request)
    {
        $user = $this->userService->updateUsernouuid($request->validated());
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }


    public function indexVoter()
    {
        $user = Auth::user();
        // dd($user);
        if ($user->role !== 'voter') {
            // Redirect or abort if the user is not a superadmin
            abort(403, 'Unauthorized action.');
        }

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

        // Ambil semua siswa dengan voting terkait
        $periods = Periode::all();

        // Ambil data voting untuk siswa yang sedang login
        $studentVotes = Votes::where('created_by', Auth::id())
            ->with('student', 'periode')
            ->get();

        // Ambil ID siswa yang sedang login
        $studentId = Auth::id();
        $student_id = Students::where('users_id', $studentId)->value('id');
        $student = Students::find($student_id);

        // Siapkan array untuk menyimpan hasil
        $votingHistory = [];

        // Loop melalui semua periode
        foreach ($periods as $period) {
            // Cari voting yang relevan untuk periode ini
            $vote = $studentVotes->firstWhere('periode_id', $period->id);

            $votingHistory[] = [
                'student' => $student,
                'tanggal_vote' => $vote ? $vote->tanggal_vote : null,
                'periode' => $period->periode_nama
            ];
        }
        return view('Siswa.index', compact('jadwalVotes', 'jadwalResultVote', 'jadwalOrasi', 'candidate', 'statusSetVote', 'cekstatusvote', 'profile', 'votingHistory'));
    }






    public function updateProfile1(UpdateAuthRequest $request)
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
