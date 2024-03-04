<?php

namespace App\Console\Commands;

use App\Models\Kontrak;
use App\Models\BadanUsaha;
use App\Models\Pekerjaan;
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
    protected $description = 'Perbarui Ketersediaan Badan Usaha dan Tenaga Ahli';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pekerjaan = Pekerjaan::all();

        $pekerjaanBebas = $pekerjaan->filter(function ($pekerjaan) {
            return in_array($pekerjaan->status_pekerjaan, ['Direncanakan', 'Selesai', 'Selesai, Melewati batas waktu', 'Tidak Selesai, Melewati batas waktu']);
        });

        $pekerjaanProses = $pekerjaan->filter(function ($pekerjaan) {
            return $pekerjaan->status_pekerjaan == 'Proses';
        });

        $pekerjaanProses->groupBy('badan_usaha_id')->each(function ($groupedKontrak) {
            $badan_usaha_id = $groupedKontrak->first()->badan_usaha_id;
            $jumlahKontrak = $groupedKontrak->count();
            BadanUsaha::where('id', $badan_usaha_id)->update(['jumlah_pekerjaan' => $jumlahKontrak]);
        });

        $pekerjaanBebas->flatMap->tenaga_ahlis->pluck('id')->each(function ($id) {
            TenagaAhli::where('id', $id)->update(['status_pekerjaan' => 1]);
        });

        $pekerjaanProses->flatMap->tenaga_ahlis->pluck('id')->each(function ($id) {
            TenagaAhli::where('id', $id)->update(['status_pekerjaan' => 0]);
        });
    }
}
