<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LaporanController;

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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/absensi', function () {
        return view('absensi.absensi');
    })->name('absensi');

    Route::get('/laporan', function () {
        return view('laporan.laporan');
    })->name('laporan');

    Route::resource('pegawai', PegawaiController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('laporan', LaporanController::class);
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
