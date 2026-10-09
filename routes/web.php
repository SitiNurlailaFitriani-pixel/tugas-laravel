<?php

use Illuminate\Support\Facades\Route;

// CONTROLLER NASABAH
use App\Http\Controllers\Nasabah\RegisterController;
use App\Http\Controllers\Nasabah\LoginController;
use App\Http\Controllers\Nasabah\HomeController;
use App\Http\Controllers\Nasabah\ProfilController;
use App\Http\Controllers\Nasabah\SetorTunaiController as NasabahSetorTunaiController;
use App\Http\Controllers\Nasabah\TarikTunaiController as NasabahTarikTunaiController;
use App\Http\Controllers\Nasabah\RiwayatNasabahController;

// CONTROLLER PETUGAS
use App\Http\Controllers\Petugas\PetugasDashboardController;
use App\Http\Controllers\Petugas\NasabahController as PetugasNasabahController;
use App\Http\Controllers\Petugas\SetorTunaiController as PetugasSetorTunaiController;
use App\Http\Controllers\Petugas\TarikTunaiController as PetugasTarikTunaiController;
use App\Http\Controllers\Petugas\RiwayatController;

// CONTROLLER ADMIN
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\DataRekeningController;
use App\Http\Controllers\Admin\DataNasabahController;
use App\Http\Controllers\Admin\SetorTunaiController as AdminSetorTunaiController;
use App\Http\Controllers\Admin\TarikTunaiController as AdminTarikTunaiController;
use App\Http\Controllers\Admin\RiwayatTransaksiController as AdminRiwayatTransaksiController;
use App\Http\Controllers\Admin\LaporanTransaksiController;

// HALAMAN UTAMA & AUTHENTICATION
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ROUTE ADMIN
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/homeadmin', [HomeAdminController::class, 'index'])->name('homeadmin');
    Route::get('/dashboard', [HomeAdminController::class, 'index'])->name('dashboard');

    Route::get('/nasabah', [DataNasabahController::class, 'index'])->name('nasabah.index');
    Route::post('/nasabah', [DataNasabahController::class, 'store'])->name('nasabah.store'); // <-- RUTE STORE NASABAH ADMIN
    Route::delete('/nasabah/{id}', [DataNasabahController::class, 'destroy'])->name('nasabah.destroy');

    // ROUTE REKENING ADMIN
    Route::get('/rekening', [DataRekeningController::class, 'index'])->name('rekening.index');
    Route::get('/rekening/create', [DataRekeningController::class, 'create'])->name('rekening.create');
    Route::post('/rekening', [DataRekeningController::class, 'store'])->name('rekening.store');
    Route::delete('/rekening/{no_rekening}', [DataRekeningController::class, 'destroy'])->name('rekening.destroy');

    Route::get('/setor_tunai', [AdminSetorTunaiController::class, 'index'])->name('setor_tunai.index');
    Route::post('/setor_tunai', [AdminSetorTunaiController::class, 'store'])->name('setor_tunai.store');

    Route::get('/tarik_tunai', [AdminTarikTunaiController::class, 'index'])->name('tarik_tunai.index');
    Route::post('/tarik_tunai', [AdminTarikTunaiController::class, 'store'])->name('tarik_tunai.store');
    Route::post('/tarik_tunai/{id}/setujui', [AdminTarikTunaiController::class, 'setujui'])->name('tarik_tunai.setujui');
    Route::post('/tarik_tunai/{id}/tolak', [AdminTarikTunaiController::class, 'tolak'])->name('tarik_tunai.tolak');

    Route::get('/riwayat_transaksi', [AdminRiwayatTransaksiController::class, 'index'])->name('riwayat_transaksi.index');
    
    // LAPORAN TRANSAKSI & CETAK
    Route::get('/laporan_transaksi', [LaporanTransaksiController::class, 'index'])->name('laporan_transaksi.index');
    Route::get('/laporan_transaksi/cetak', [LaporanTransaksiController::class, 'cetak'])->name('laporan_transaksi.cetak');
});

// ROUTE PETUGAS
Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');

    Route::get('/data-nasabah', [PetugasNasabahController::class, 'index'])->name('nasabah');
    Route::delete('/data-nasabah/{id}', [PetugasNasabahController::class, 'destroy'])->name('nasabah.destroy');

    Route::get('/setor-tunai', [PetugasSetorTunaiController::class, 'index'])->name('setortunai');
    Route::post('/setor-tunai', [PetugasSetorTunaiController::class, 'store'])->name('setortunai.store');

    Route::get('/tarik-tunai', [PetugasTarikTunaiController::class, 'index'])->name('tariktunai');
    Route::post('/tarik-tunai', [PetugasTarikTunaiController::class, 'store'])->name('tariktunai.store');
    Route::post('/tarik-tunai/{id}/setujui', [PetugasTarikTunaiController::class, 'setujui'])->name('tariktunai.setujui');
    Route::post('/tarik-tunai/{id}/tolak', [PetugasTarikTunaiController::class, 'tolak'])->name('tariktunai.tolak');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
});

// ROUTE NASABAH
Route::get('/homenasabah', [HomeController::class, 'index'])->name('homenasabah');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

Route::get('/setortunai', [NasabahSetorTunaiController::class, 'index'])->name('setortunai');
Route::post('/setortunai', [NasabahSetorTunaiController::class, 'store'])->name('setortunai.store');

Route::get('/tariktunai', [NasabahTarikTunaiController::class, 'index'])->name('tariktunai');
Route::post('/tariktunai', [NasabahTarikTunaiController::class, 'store'])->name('tariktunai.store');

Route::get('/riwayat-transaksi', [RiwayatNasabahController::class, 'index'])->name('nasabah.riwayat');