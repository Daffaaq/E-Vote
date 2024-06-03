<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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
        Route::get('/Siswa/data', [StudentsController::class, 'list']);
    });
});
Route::middleware(['auth', 'check.role:admin'])->group(function () {
});
Route::middleware(['auth', 'checkVoterStatus', 'check.role:voter'])->group(function () {
});
