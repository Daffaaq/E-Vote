<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\StudentsController;
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
    Route::get('/', [LoginController::class, 'indexlandingpage'])->name('landing-page');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/loginProcess', [LoginController::class, 'login'])->name('loginProcess');
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'check.role:superadmin'])->group(function () {
    Route::get('/dashboardSuperadmin', [DashboardController::class, 'indexSuperadmin'])->name('dashboard.superadmin');
    Route::post('/dashboardSuperadmin/status', [DashboardController::class, 'Settingvote'])->name('dashboard.superadmin.setting-vote');
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/Siswa', [StudentsController::class, 'index'])->name('students.index');
        Route::get('/Siswa/create', [StudentsController::class, 'create']);
        Route::post('/Siswa/store', [StudentsController::class, 'store']);
        Route::get('/Siswa/edit/{id}', [StudentsController::class, 'edit']);
        Route::put('/Siswa/update/{id}', [StudentsController::class, 'update']);
        Route::delete('/Siswa/destroy/{id}', [StudentsController::class, 'destroy']);
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/Periode', [PeriodeController::class, 'index'])->name('periode.index');
        Route::get('/Periode/create', [PeriodeController::class, 'create'])->name('periode.create');
        Route::post('/Periode/store', [PeriodeController::class, 'store'])->name('periode.store');
        Route::get('/Periode/edit/{id}', [PeriodeController::class, 'edit'])->name('periode.edit');
        Route::put('/Periode/update/{id}', [PeriodeController::class, 'update'])->name('periode.update');
        Route::delete('/Periode/destroy/{id}', [PeriodeController::class, 'destroy'])->name('periode.destroy');
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/Jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/Jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/Jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/Jadwal/edit/orasi/{id}', [JadwalController::class, 'editOrasi'])->name('jadwal-orasi.edit');
        Route::get('/Jadwal/edit/votes/{id}', [JadwalController::class, 'editVotes'])->name('jadwal-votes.edit');
        Route::get('/Jadwal/edit/result/{id}', [JadwalController::class, 'editResult'])->name('jadwal-result.edit');
        Route::put('/Jadwal/update/orasi/{id}', [JadwalController::class, 'updateOrasi'])->name('jadwal-orasi.update');
        Route::put('/Jadwal/update/votes/{id}', [JadwalController::class, 'updateVote'])->name('jadwal-votes.update');
        Route::put('/Jadwal/update/result/{id}', [JadwalController::class, 'updateResult'])->name('jadwal-result.update');
        Route::delete('/Jadwal/destroy/orasi/{id}', [JadwalController::class, 'destroyOrasi'])->name('jadwal-orasi.destroy');
        Route::delete('/Jadwal/destroy/votes/{id}', [JadwalController::class, 'destroyVotes'])->name('jadwal-votes.destroy');
        Route::delete('/Jadwal/destroy/result/{id}', [JadwalController::class, 'destroyResult'])->name('jadwal-result.destroy');
    });
    Route::prefix('/dashboardSuperadmin')->group(function () {
        Route::get('/Candidate', [CandidateController::class, 'index'])->name('Candidate.index');
        Route::get('/Candidate/create', [CandidateController::class, 'create'])->name('Candidate.create');
        Route::post('/Candidate/store', [CandidateController::class, 'store'])->name('Candidate.store');
        Route::get('/Candidate/edit/{slug}', [CandidateController::class, 'edit'])->name('Candidate.edit');
        Route::put('/Candidate/update/{slug}', [CandidateController::class, 'update'])->name('Candidate.update');
        Route::delete('/Candidate/destroy/{slug}', [CandidateController::class, 'destroy'])->name('Candidate.destroy');
    });
});
Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('/dashboardAdmin', [DashboardController::class, 'indexAdmin'])->name('dashboard.admin');
    Route::prefix('/dashboardAdmin')->group(function () {

    });
});
Route::middleware(['auth', 'checkStatus', 'check.role:voter'])->group(function () {
    Route::get('/dashboardVoter', [DashboardController::class, 'indexVoter'])->name('dashboard.voter');
});
