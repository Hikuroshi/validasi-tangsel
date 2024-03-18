<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BadanUsaha;
use App\Models\JenisJasa;
use App\Models\JenisPekerjaan;
use App\Models\Kecamatan;
use App\Models\Metode;
use App\Models\RiwayatPendidikan;
use App\Models\SubPekerjaan;
use App\Models\TenagaAhli;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('test'),
        ]);

        BadanUsaha::create([
            'nama' => 'PT ABCD',
            'slug' => Str::slug('PT ABCD'),
            'npwp' => '0987654321',
            'sertifikat' => '0123456789',
            'registrasi' => '9876543210',
            'direktur' => 'John Doe',
            'alamat' => 'Jl. Contoh No. 123',
            'email' => 'ptabcd@example.com',
            'telepon' => '087654321098',
            'no_akta' => '2468101214',
            'tgl_akta' => now(),
            'klasifikasi' => 'Konstruksi Bangunan',
            'status' => true,
            'jumlah_pekerjaan' => 0,
            'author_id' => 1,
        ]);

        TenagaAhli::create([
            'nama' => 'Jane Doe',
            'slug' => Str::slug('Jane Doe'),
            'nik' => '0987654321098765',
            'npwp' => '1234567890',
            'badan_usaha_id' => 1,
            'jabatan' => 'Arsitek',
            'tempat_lahir' => 'Jakarta',
            'tgl_lahir' => now()->subYears(35),
            'alamat' => 'Jl. Ahli No. 456',
            'kelamin' => true,
            'email' => 'janedoe@example.com',
            'telepon' => '087654321098',
            'keahlian' => 'Arsitektur',
            'status' => true,
            'status_pekerjaan' => true,
            'author_id' => 1,
        ]);

        RiwayatPendidikan::create([
            'nama' => 'Universitas Contoh',
            'slug' => Str::slug('Universitas Contoh'),
            'jurusan' => 'Teknik Sipil',
            'gelar' => 'Sarjana Teknik',
            'thn_masuk' => '2005',
            'thn_lulus' => '2009',
            'ijazah' => '123456789',
            'tenaga_ahli_id' => 1,
            'author_id' => 1,
        ]);

        $kecamatan_tangerang_selatan = ['Ciputat', 'Ciputat Timur', 'Pamulang', 'Pondok Aren', 'Serpong', 'Serpong Utara', 'Setu'];

        foreach ($kecamatan_tangerang_selatan as $kecamatan) {
            Kecamatan::create([
                'nama' => $kecamatan,
                'slug' => Str::slug($kecamatan),
                'author_id' => 1,
            ]);
        }

        $metodes = ['Tender', 'Penunjukan Langsung'];

        foreach ($metodes as $metode) {
            Metode::create([
                'nama' => $metode,
                'slug' => Str::slug($metode),
                'author_id' => 1,
            ]);
        }

        $jenis_jasas = ['Jasa Kontruksi', 'Jasa Konsultasi'];

        foreach ($jenis_jasas as $jenis_jasa) {
            JenisJasa::create([
                'nama' => $jenis_jasa,
                'slug' => Str::slug($jenis_jasa),
                'author_id' => 1,
            ]);
        }

        JenisPekerjaan::create([
            'nama' => 'Test jenis pekerjaan',
            'slug' => Str::slug('Test jenis pekerjaan'),
            'jenis_jasa_id' => 1,
            'author_id' => 1,
        ]);

        SubPekerjaan::create([
            'nama' => 'Test sub pekerjaan',
            'slug' => Str::slug('Test sub pekerjaan'),
            'jenis_pekerjaan_id' => 1,
            'author_id' => 1,
        ]);
    }
}
