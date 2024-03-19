<?php

namespace App\Console\Commands;

use App\Models\Perusahaan;
use App\Models\Pelaksana;
use App\Models\TenagaAhli;
use Illuminate\Console\Command;

class UpdateAvailability extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'availability:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perbarui Ketersediaan Perusahaan dan Tenaga Ahli';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pelaksana = Pelaksana::all();

        $pekerjaanBebas = $pelaksana->filter(function ($pelaksana) {
            return in_array($pelaksana->status_pekerjaan, ['Direncanakan', 'Selesai', 'Selesai, Melewati batas waktu', 'Tidak Selesai, Melewati batas waktu']);
        });

        $pekerjaanProses = $pelaksana->filter(function ($pelaksana) {
            return $pelaksana->status_pekerjaan == 'Proses';
        });

        $pekerjaanProses->groupBy('perusahaan_id')->each(function ($groupedKontrak) {
            $perusahaan_id = $groupedKontrak->first()->perusahaan_id;
            $jumlahKontrak = $groupedKontrak->count();
            Perusahaan::where('id', $perusahaan_id)->update(['jumlah_pekerjaan' => $jumlahKontrak]);
        });

        $pekerjaanBebas->flatMap->tenaga_ahlis->pluck('id')->each(function ($id) {
            TenagaAhli::where('id', $id)->update(['status_pekerjaan' => 1]);
        });

        $pekerjaanProses->flatMap->tenaga_ahlis->pluck('id')->each(function ($id) {
            TenagaAhli::where('id', $id)->update(['status_pekerjaan' => 0]);
        });
    }
}
