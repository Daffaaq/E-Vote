<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/dashboardSuperadmin', [DashboardController::class, 'indexSuperadmin']);
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
        Route::get('/Banner', [BannerController::class, 'index'])->name('banner.index');
        Route::get('/Banner/create', [BannerController::class, 'create'])->name('banner.create');
        Route::post('/Banner/store', [BannerController::class, 'store'])->name('banner.store');
        Route::get('/Banner/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
        Route::put('/Banner/update/{id}', [BannerController::class, 'update'])->name('banner.update');
        Route::delete('/Banner/destroy/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');
    });
});
Route::middleware(['auth', 'check.role:admin'])->group(function () {
});
Route::middleware(['auth', 'checkVoterStatus', 'check.role:voter'])->group(function () {
});
