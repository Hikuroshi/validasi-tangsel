<?php

namespace App\Console\Commands;

use App\Models\Kontrak;
use App\Models\BadanUsaha;
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
        $kontrak = Kontrak::all();

        $kontrakBebas = $kontrak->filter(function ($kontrak) {
            return in_array($kontrak->status_kontrak, ['Direncanakan', 'Selesai', 'Selesai, Melewati batas waktu', 'Tidak Selesai, Melewati batas waktu']);
        });

        $kontrakProses = $kontrak->filter(function ($kontrak) {
            return $kontrak->status_kontrak == 'Proses';
        });

        $kontrakProses->groupBy('badan_usaha_id')->each(function ($groupedKontrak) {
            $badan_usaha_id = $groupedKontrak->first()->badan_usaha_id;
            $jumlahKontrak = $groupedKontrak->count();
            BadanUsaha::where('id', $badan_usaha_id)->update(['jumlah_kontrak' => $jumlahKontrak]);
        });

        $kontrakBebas->flatMap->tenaga_ahlis->pluck('id')->each(function ($id) {
            TenagaAhli::where('id', $id)->update(['status_kontrak' => 1]);
        });

        $kontrakProses->flatMap->tenaga_ahlis->pluck('id')->each(function ($id) {
            TenagaAhli::where('id', $id)->update(['status_kontrak' => 0]);
        });
    }
}
