<?php

use App\Http\Controllers\JenisJasaController;
use App\Http\Controllers\JenisPekerjaanController;
use App\Http\Controllers\KeahlianController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MetodeController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\BadanUsahaController;
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

Route::get('/dashboard', function () {
    return view('dashboard.index', ['title' => 'Dashboard']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('/dashboard/user', UserController::class)->except('show');
    Route::put('/dashboard/user-password', [UserController::class, 'passwordUpdate'])->name('user-password.update');

    Route::resource('/dashboard/tenaga-ahli', TenagaAhliController::class);
    Route::resource('/dashboard/badan-usaha', BadanUsahaController::class);
    Route::resource('/dashboard/jenis-pekerjaan', JenisPekerjaanController::class)->except('show');
    Route::resource('/dashboard/sub-pekerjaan', SubPekerjaanController::class)->except('show');
    Route::resource('/dashboard/kecamatan', KecamatanController::class)->except('show');
    Route::resource('/dashboard/metode', MetodeController::class)->except('show');
    Route::resource('/dashboard/jenis-jasa', JenisJasaController::class)->except('show');
    Route::resource('/dashboard/user', UserController::class)->except('show');

    Route::resource('/dashboard/pelaksana', PelaksanaController::class);
    Route::post('/dashboard/pelaksana-tenaga-ahli/{pelaksana}/{tenaga_ahli}', [PelaksanaController::class,'deleteTenagaAhli'])->name('pelaksana.delete-tenaga-ahli');
    Route::put('/dashboard/pelaksana-tenaga-ahli/{pelaksana}', [PelaksanaController::class,'addTenagaAhli'])->name('pelaksana.add-tenaga-ahli');
    Route::put('/dashboard/pelaksana-tenaga-ahli/{pelaksana}', [PelaksanaController::class,'addTenagaAhli'])->name('pelaksana.add-tenaga-ahli');
    Route::put('/dashboard/status-pelaksana/{pelaksana}', [StatusPelaksanaController::class,'store'])->name('status-pelaksana.store');

    Route::resource('/dashboard/pekerjaan', PekerjaanController::class);
    Route::get('/get-jenis-pekerjaan/{id}', [PekerjaanController::class,'getJenisPekerjaan'])->name('pekerjaan.jenis-pekerjaan');
    Route::get('/get-sub-pekerjaan/{id}', [PekerjaanController::class, 'getSubPekerjaan'])->name('pekerjaan.sub-pekerjaan');

    Route::resource('/dashboard/riwayat-pendidikan', RiwayatPendidikanController::class)->except('index', 'create', 'show');
    Route::get('/dashboard/riwayat-pendidikan/create/{tenaga_ahli_id}/{tenaga_ahli_nama}', [RiwayatPendidikanController::class, 'create'])->name('riwayat-pendidikan.create');

    Route::resource('/dashboard/keahlian', KeahlianController::class)->except('index', 'create', 'show');
    Route::get('/dashboard/keahlian/create/{tenaga_ahli_id}/{tenaga_ahli_nama}', [KeahlianController::class, 'create'])->name('keahlian.create');
    Route::get('/dashboard/keahlian/view-sertifikat/{slug}', [KeahlianController::class, 'viewSertifikat'])->name('keahlian.view-sertifikat');

    Route::put('/dashboard/pekerjaan/{pekerjaan}/selesai', [PekerjaanController::class, 'pekerjaanSelesai'])->name('pekerjaan.selesai');

    Route::get('/dashboard/laporan', [LaporanController::class,'index'])->name('laporan.index');
    Route::post('/dashboard/laporan', [LaporanController::class,'search'])->name('laporan.search');
});

Route::redirect('/', '/dashboard');

require __DIR__.'/auth.php';
