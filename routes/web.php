<?php

use App\Http\Controllers\JenisJasaController;
use App\Http\Controllers\JenisPekerjaanController;
use App\Http\Controllers\KeahlianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MetodeController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\RiwayatPendidikanController;
use App\Http\Controllers\StatusPekerjaanController;
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
    Route::resource('/status-pekerjaan', StatusPekerjaanController::class)->except('show');
    Route::resource('/metode', MetodeController::class)->except('show');
    Route::resource('/user', UserController::class)->except('show');

    Route::resource('/pekerjaan', PekerjaanController::class);
    Route::controller(PekerjaanController::class)->group(function () {
        Route::post('/pekerjaan-tenaga-ahli/{pekerjaan}/{tenaga_ahli}', 'deleteTenagaAhli')->name('pekerjaan.delete-tenaga-ahli');
        Route::put('/pekerjaan-tenaga-ahli/{pekerjaan}', 'addTenagaAhli')->name('pekerjaan.add-tenaga-ahli');
    });

    Route::resource('/riwayat-pendidikan', RiwayatPendidikanController::class)->except('index', 'create', 'show');
    Route::get('/riwayat-pendidikan/create/{tenaga_ahli_id}/{tenaga_ahli_nama}', [RiwayatPendidikanController::class, 'create'])->name('riwayat-pendidikan.create');

    Route::resource('/keahlian', KeahlianController::class)->except('index', 'create', 'show');
    Route::controller(KeahlianController::class)->group(function () {
        Route::get('/keahlian/create/{tenaga_ahli_id}/{tenaga_ahli_nama}', 'create')->name('keahlian.create');
        Route::get('/keahlian/view-sertifikat/{slug}', 'viewSertifikat')->name('keahlian.view-sertifikat');
    });

    Route::controller(LaporanController::class)->group(function () {
        Route::get('/laporan', 'index')->name('laporan.index');
        Route::get('/laporan/{pekerjaan}', 'search')->name('laporan.search');
    });

    Route::controller(ProsesController::class)->group(function () {
        Route::get('/proses/perusahaan', 'perusahaan')->name('proses.perusahaan');
        Route::get('/proses/tenaga-ahli', 'tenagaAhli')->name('proses.tenagaAhli');
    });
});

require __DIR__.'/auth.php';
