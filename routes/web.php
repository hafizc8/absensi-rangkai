<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/absensi', function () {
        return view('absensi.absensi');
    })->name('absensi');

    Route::resource('pegawai', PegawaiController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('laporan', LaporanController::class);

    Route::get('print-laporan/{date1}/{date2}', [LaporanController::class, 'printLaporan']);
    Route::get('print-laporan-per-pegawai/{date1}/{date2}/{karyawan}', [LaporanController::class, 'printLaporanPerPegawai']);
    Route::get('/laporan-per-pegawai', [LaporanController::class, 'perPegawai'])->name('laporan-per-pegawai');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
