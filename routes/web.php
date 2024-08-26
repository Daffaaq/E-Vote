<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('superadmin.layouts.content');
// });

Route::middleware(['guest'])->group(function () {
    // Route::get('/', function () {
    //     return view('Siswa.success');
    // });

    Route::get('/', [LoginController::class, 'indexlandingpage'])->name('landing-page');
    Route::prefix('/')->group(function () {
        Route::get('/Detail/{slug}', [LoginController::class, 'detaiCandidate'])->name('detail.candidate.landing-page');
    });
    Route::prefix('/')->group(function () {
        Route::post('/aspiration', [AspirasiController::class, 'store'])->name('aspiration.store');
    });
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/loginProcess', [LoginController::class, 'login'])->name('loginProcess');
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'check.role:superadmin'])->group(function () {
    Route::get('/dashboardSuperadmin', [DashboardController::class, 'indexSuperadmin'])->name('dashboard.superadmin');
    Route::post('/dashboardSuperadmin/status', [DashboardController::class, 'Settingvote'])->name('dashboard.superadmin.setting-vote');
    Route::get('/dashboardSuperadmin/export', [DashboardController::class, 'export_excel'])->name('dashboard.superadmin.export-vote');
    Route::get('/dashboardSuperadmin/export-pdf', [DashboardController::class, 'export_vote_pdf'])->name('dashboard.superadmin.export-vote-pdf');
    Route::post('/dashboardSuperadmin/save-chart', function (Request $request) {
        if ($request->hasFile('chart')) {
            $path = $request->file('chart')->store('public/charts');
            // Simpan nama file di session
            Session::put('chart_filename', basename($path));
            Log::info("Chart saved at: " . storage_path('app/' . $path));
            return response()->json(['path' => $path], 200);
        }
        Log::error("No chart uploaded");
        return response()->json(['error' => 'No chart uploaded'], 400);
    });

    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/Users', [UserController::class, 'index'])->name('users.index');
        Route::get('/Users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/Users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/Users/edit/{uuid}', [UserController::class, 'edit'])->name('users.edit');
        Route::get('/Users/show/{uuid}', [UserController::class, 'show'])->name('users.show');
        Route::put('/Users/update/{uuid}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/Users/destroy/{uuid}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/Users/list', [UserController::class, 'list'])->name('users-list-superadmin');
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/Siswa', [StudentsController::class, 'index'])->name('students.index');
        Route::get('/Siswa/create', [StudentsController::class, 'create'])->name('students.create');
        Route::post('/Siswa/store', [StudentsController::class, 'store'])->name('students.store');
        Route::get('/Siswa/edit/{uuid}', [StudentsController::class, 'edit'])->name('students.edit');
        Route::get('/Siswa/show/{uuid}', [StudentsController::class, 'show'])->name('students.show');
        Route::put('/Siswa/update/{uuid}', [StudentsController::class, 'update'])->name('students.update');
        Route::delete('/Siswa/destroy/{uuid}', [StudentsController::class, 'destroy'])->name('students.destroy');
        Route::post('/Siswa/list', [StudentsController::class, 'list'])->name('siswa-list-superadmin');
        Route::get('/Siswa/cetak', [StudentsController::class, 'reportPemilih'])->name('siswa-pdf-superadmin');
        Route::post('/Siswa/import', [StudentsController::class, 'importDataStudent'])->name('siswa.import');
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/Periode', [PeriodeController::class, 'index'])->name('periode.index');
        Route::get('/Periode/create', [PeriodeController::class, 'create'])->name('periode.create');
        Route::post('/Periode/store', [PeriodeController::class, 'store'])->name('periode.store');
        Route::get('/Periode/edit/{uuid}', [PeriodeController::class, 'edit'])->name('periode.edit');
        Route::put('/Periode/update/{uuid}', [PeriodeController::class, 'update'])->name('periode.update');
        Route::delete('/Periode/destroy/{uuid}', [PeriodeController::class, 'destroy'])->name('periode.destroy');
        Route::post('/Periode/list', [PeriodeController::class, 'list'])->name('periode-list-superadmin');
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/Jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/Jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/Jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/Jadwal/edit/orasi/{uuid}', [JadwalController::class, 'editOrasi'])->name('jadwal-orasi.edit');
        Route::get('/Jadwal/edit/votes/{uuid}', [JadwalController::class, 'editVotes'])->name('jadwal-votes.edit');
        Route::get('/Jadwal/edit/result/{uuid}', [JadwalController::class, 'editResult'])->name('jadwal-result.edit');
        Route::put('/Jadwal/update/orasi/{uuid}', [JadwalController::class, 'updateOrasi'])->name('jadwal-orasi.update');
        Route::put('/Jadwal/update/votes/{uuid}', [JadwalController::class, 'updateVote'])->name('jadwal-votes.update');
        Route::put('/Jadwal/update/result/{uuid}', [JadwalController::class, 'updateResult'])->name('jadwal-result.update');
        Route::delete('/Jadwal/destroy/orasi/{uuid}', [JadwalController::class, 'destroyOrasi'])->name('jadwal-orasi.destroy');
        Route::delete('/Jadwal/destroy/votes/{uuid}', [JadwalController::class, 'destroyVotes'])->name('jadwal-votes.destroy');
        Route::delete('/Jadwal/destroy/result/{uuid}', [JadwalController::class, 'destroyResult'])->name('jadwal-result.destroy');
        Route::delete('/jadwal/delete-all/{uuidOrasi}/{uuidVotes}/{uuidResult}', [JadwalController::class, 'destroyAll'])->name('jadwal.destroyAll');
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/Candidate', [CandidateController::class, 'index'])->name('Candidate.index');
        Route::get('/Candidate/create', [CandidateController::class, 'create'])->name('Candidate.create');
        Route::post('/Candidate/store', [CandidateController::class, 'store'])->name('Candidate.store');
        Route::get('/Candidate/edit/{uuic}', [CandidateController::class, 'edit'])->name('Candidate.edit');
        Route::put('/Candidate/update/{uuic}', [CandidateController::class, 'update'])->name('Candidate.update');
        Route::delete('/Candidate/destroy/{uuic}', [CandidateController::class, 'destroy'])->name('Candidate.destroy');
        Route::post('/Candidate/list', [CandidateController::class, 'list'])->name('candidate-list-superadmin');
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('profiles', [ProfileController::class, 'index'])->name('profiles.index');
        Route::get('profiles/{uuid}', [ProfileController::class, 'show'])->name('profiles.show');
        Route::get('profiles/edit-logo/{uuid}', [ProfileController::class, 'editLogo'])->name('profiles.edit-logo');
        Route::put('profiles/update-logo/{uuid}', [ProfileController::class, 'updateLogo'])->name('profiles.update-logo');
        Route::get('profiles/edit-personal/{uuid}', [ProfileController::class, 'editPersonal'])->name('profiles.edit-personal');
        Route::put('profiles/update-personal/{uuid}', [ProfileController::class, 'updatePersonal'])->name('profiles.update-personal');
        Route::get('profiles/edit-sosial-media/{uuid}', [ProfileController::class, 'editSocialMedia'])->name('profiles.edit-sosial-media');
        Route::put('profiles/update-sosial-media/{uuid}', [ProfileController::class, 'updateSocialMedia'])->name('profiles.update-sosial-media');
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/aspiration', [AspirasiController::class, 'index'])->name('aspiration.index');
        Route::get('/aspiration/show/{uuid}', [AspirasiController::class, 'show'])->name('aspiration.show');
        Route::post('/aspiration/list', [AspirasiController::class, 'list'])->name('aspiration.list');
        Route::delete('/aspiration/{uuid}', [AspirasiController::class, 'destroy'])->name('aspiration.destroy');
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/my-profiles', [DashboardController::class, 'profileSuperadmin'])->name('my-profile.index');
        Route::post('update-profile', [DashboardController::class, 'updateProfile'])->name('superadmin.updateProfile');
        Route::post('change-password', [DashboardController::class, 'changePassword'])->name('superadmin.changePassword');
        Route::post('delete-profile-photo', [DashboardController::class, 'deleteProfilePhoto'])->name('superadmin.deleteProfilePhoto');
    });
});
Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('/dashboardAdmin', [DashboardController::class, 'indexAdmin'])->name('dashboard.admin');
    Route::get('/dashboardAdmin/export', [DashboardController::class, 'export_excel'])->name('dashboard.admin.export-vote');
    Route::get('/dashboardAdmin/export-pdf', [DashboardController::class, 'export_vote_pdf'])->name('dashboard.admin.export-vote-pdf');
    Route::post('/dashboardAdmin/save-chart', function (Request $request) {
        if ($request->hasFile('chart')) {
            $path = $request->file('chart')->store('public/charts');
            // Simpan nama file di session
            Session::put('chart_filename', basename($path));
            Log::info("Chart saved at: " . storage_path('app/' . $path));
            return response()->json(['path' => $path], 200);
        }
        Log::error("No chart uploaded");
        return response()->json(['error' => 'No chart uploaded'], 400);
    });
    Route::prefix('/dashboardAdmin')->group(function () {
        Route::get('/Siswa', [StudentsController::class, 'index'])->name('students.admin.index');
        Route::get('/Siswa/create', [StudentsController::class, 'create'])->name('students.admin.create');
        Route::post('/Siswa/store', [StudentsController::class, 'store'])->name('students.admin.store');
        Route::get('/Siswa/edit/{uuid}', [StudentsController::class, 'edit'])->name('students.admin.edit');
        Route::get('/Siswa/show/{uuid}', [StudentsController::class, 'show'])->name('students.admin.show');
        Route::put('/Siswa/update/{uuid}', [StudentsController::class, 'update'])->name('students.admin.update');
        Route::delete('/Siswa/destroy/{uuid}', [StudentsController::class, 'destroy'])->name('students.admin.destroy');
        Route::post('/Siswa/list', [StudentsController::class, 'list'])->name('siswa-list-admin');
        Route::get('/Siswa/cetak', [StudentsController::class, 'reportPemilih'])->name('siswa-pdf-admin');
        Route::post('/Siswa/import', [StudentsController::class, 'importDataStudent'])->name('siswa.admin.import');
    });
});
Route::middleware(['auth', 'checkStatus', 'check.role:voter'])->group(function () {
    Route::get('/dashboardVoter', [DashboardController::class, 'indexVoter'])->name('dashboard.voter');
    Route::prefix('/dashboardVoter')->group(function () {
        Route::get('/Detail/{slug}', [DashboardController::class, 'detaiCandidate'])->name('detail.candidate.voter');
    });
    Route::prefix('/dashboardVoter')->group(function () {
        Route::post('/Profile/Update', [DashboardController::class, 'UpdateProfile'])->name('update.candidate.voter');
    });
    Route::prefix('/dashboardVoter')->group(function () {
        Route::post('/vote', [VotingController::class, 'vote'])->name('vote.cast');
        Route::post('/detail/vote', [VotingController::class, 'voteInDetail'])->name('vote.detail.cast');
        Route::get('/vote/success', function () {
            return view('Siswa.success');
        })->name('vote.success');
    });
});
