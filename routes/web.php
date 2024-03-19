<?php

use App\Http\Controllers\JenisJasaController;
use App\Http\Controllers\JenisPekerjaanController;
use App\Http\Controllers\KeahlianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PelaksanaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatPendidikanController;
use App\Http\Controllers\StatusPelaksanaController;
use App\Http\Controllers\SubPekerjaanController;
use App\Http\Controllers\TenagaAhliController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('dashboard.index', ['title' => 'Dashboard']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('/user', UserController::class)->except('show');
    Route::put('/user-password', [UserController::class, 'passwordUpdate'])->name('user-password.update');

    Route::resource('/tenaga-ahli', TenagaAhliController::class);
    Route::resource('/perusahaan', PerusahaanController::class);
    Route::resource('/jenis-pekerjaan', JenisPekerjaanController::class)->except('show');
    Route::resource('/sub-pekerjaan', SubPekerjaanController::class)->except('show');
    Route::resource('/jenis-jasa', JenisJasaController::class)->except('show');
    Route::resource('/user', UserController::class)->except('show');

    Route::resource('/pelaksana', PelaksanaController::class);
    Route::post('/pelaksana-tenaga-ahli/{pelaksana}/{tenaga_ahli}', [PelaksanaController::class,'deleteTenagaAhli'])->name('pelaksana.delete-tenaga-ahli');
    Route::put('/pelaksana-tenaga-ahli/{pelaksana}', [PelaksanaController::class,'addTenagaAhli'])->name('pelaksana.add-tenaga-ahli');
    Route::put('/status-pelaksana/{pelaksana}', [StatusPelaksanaController::class,'store'])->name('status-pelaksana.store');
    Route::get('/get-jenis-pekerjaan/{id}', [PelaksanaController::class,'getJenisPekerjaan'])->name('pelaksana.jenis-pekerjaan');
    Route::get('/get-sub-pekerjaan/{id}', [PelaksanaController::class, 'getSubPekerjaan'])->name('pelaksana.sub-pekerjaan');

    Route::resource('/riwayat-pendidikan', RiwayatPendidikanController::class)->except('index', 'create', 'show');
    Route::get('/riwayat-pendidikan/create/{tenaga_ahli_id}/{tenaga_ahli_nama}', [RiwayatPendidikanController::class, 'create'])->name('riwayat-pendidikan.create');

    Route::resource('/keahlian', KeahlianController::class)->except('index', 'create', 'show');
    Route::get('/keahlian/create/{tenaga_ahli_id}/{tenaga_ahli_nama}', [KeahlianController::class, 'create'])->name('keahlian.create');
    Route::get('/keahlian/view-sertifikat/{slug}', [KeahlianController::class, 'viewSertifikat'])->name('keahlian.view-sertifikat');

    Route::get('/laporan', [LaporanController::class,'index'])->name('laporan.index');
    Route::get('/laporan/{pelaksana}', [LaporanController::class,'search'])->name('laporan.search');
});

require __DIR__.'/auth.php';
