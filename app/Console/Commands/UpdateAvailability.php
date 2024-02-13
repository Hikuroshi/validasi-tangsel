<?php

namespace App\Console\Commands;

use App\Models\Kontrak;
use App\Models\Perusahaan;
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
        $kontrak = Kontrak::all();

        $kontrakBebas = $kontrak->filter(function ($kontrak) {
            return in_array($kontrak->status_kontrak, ['Direncanakan', 'Selesai', 'Selesai, Melewati batas waktu', 'Tidak Selesai, Melewati batas waktu']);
        });

        $kontrakProses = $kontrak->filter(function ($kontrak) {
            return $kontrak->status_kontrak == 'Proses';
        });

        $kontrakProses->groupBy('perusahaan_id')->each(function ($groupedKontrak) {
            $perusahaanId = $groupedKontrak->first()->perusahaan_id;
            $jumlahKontrak = $groupedKontrak->count();
            Perusahaan::where('id', $perusahaanId)->update(['jumlah_kontrak' => $jumlahKontrak]);
        });

        $kontrakBebas->flatMap->tenaga_ahlis->pluck('id')->each(function ($id) {
            TenagaAhli::where('id', $id)->update(['status_kontrak' => 1]);
        });

        $kontrakProses->flatMap->tenaga_ahlis->pluck('id')->each(function ($id) {
            TenagaAhli::where('id', $id)->update(['status_kontrak' => 0]);
        });
    }
}
