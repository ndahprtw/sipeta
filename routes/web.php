<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LokasiBidangController;
use App\Http\Controllers\DetailLokasiBidangController;
use App\Http\Controllers\FotoLahanController;
use App\Http\Controllers\KategoriLahanController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\PemilikController;

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

Route::get('/', function () {
    return view('login');
});

Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

// Hak akses semua user
Route::group(['middleware' => 'cekrole:Super Admin,Admin,User'], function() {
    Route::get('/dashboard', 
        function () {return view('pages/dashboard');
    });
    // Route::resource('/data-lahan', LokasiBidangController::class)->names('data-lahan');
    Route::resource('/data-lahan', LahanController::class)->names('data-lahan');
    Route::resource('/foto-lahan', FotoLahanController::class)->names('foto-lahan');
    Route::resource('/data-pemilik', PemilikController::class)->names('data-pemilik');
    Route::resource('/kategori-lahan', KategoriLahanController::class)->names('kategori-lahan');
    Route::resource('/detail-lahan', DetailLokasiBidangController::class)->names('detail-lahan');
   
// });

// // Hak akses milik super admin dan admin
// Route::group(['middleware' => 'cekrole:Super Admin,Admin,User'], function() {
    Route::get('/maps', [LokasiBidangController::class, 'titik_lokasi']);
    Route::get('/data-titik', [LokasiBidangController::class, 'json']);
    // Route::get('/data-titik/{id}', [LokasiBidangController::class, 'json']);

// });

// // Hak akses milik superadmin
// Route::group(['middleware' => 'cekrole:Super Admin'], function() {
    Route::resource('/data-staff', StaffController::class)->names('data-staff');
});
