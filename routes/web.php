<?php

use App\Http\Controllers\LoginController;
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
//     return view('welcome');
// });

Route::middleware(['guest'])->group(function () {
    Route::get('/', [
        LoginController::class, 'index'
    ])->name('login');
    Route::post('/', [LoginController::class, 'login']);
});

Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth', 'checkStatus:aktif', 'check.role:superadmin'])->group(function () {

});
Route::middleware(['auth', 'checkStatus:aktif', 'check.role:admin'])->group(function () {

});
Route::middleware(['auth', 'checkStatus:aktif', 'check.role:voter'])->group(function () {
    
});
