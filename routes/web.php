<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DetailLokasiBidangController;
use App\Http\Controllers\FotoLahanController;
use App\Http\Controllers\KategoriLahanController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\RiwayatPemilikController;
use App\Http\Controllers\TitikLahanController;

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

Route::get('/', [MapsController::class, 'index']);
Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/data-titik', [MapsController::class, 'json']);

Route::group(['middleware' => 'cekrole:Admin'], function() {
    Route::get('/log-aktivitas', [ActivityController::class, 'index']);
    Route::resource('/data-staff', StaffController::class)->names('data-staff');
    Route::resource('/kategori-lahan', KategoriLahanController::class)->names('kategori-lahan');
});

Route::group(['middleware' => 'cekrole:Admin,Petugas'], function() {
    Route::get('/dashboard', [LoginController::class, 'dashboard']);
    Route::resource('/data-lahan', LahanController::class)->names('data-lahan');
    Route::resource('/foto-lahan', FotoLahanController::class)->names('foto-lahan');
    Route::resource('/data-pemilik', PemilikController::class)->names('data-pemilik');
    Route::resource('/detail-lahan', DetailLokasiBidangController::class)->names('detail-lahan');
    Route::resource('/titik-lahan', TitikLahanController::class)->names('titik-lahan');
    Route::resource('/riwayat-pemilik', RiwayatPemilikController::class)->names('riwayat-pemilik');
    Route::get('/unduh-data/{id}', [LahanController::class, 'unduh']);
    Route::get('/update-status/{id}', [LahanController::class, 'update_status']);
    Route::get('/maps', [MapsController::class, 'view_maps']);
    Route::get('/titik-lahan-pemilik/{id}', [MapsController::class, 'json_pemilik_lahan']);
});
