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
            'nama' => 'Nama Badan Usaha',
            'slug' => Str::slug('Nama Badan Usaha'),
            'npwp' => '1234567890',
            'sertifikat' => 'Nomor Sertifikat',
            'registrasi' => 'Nomor Registrasi',
            'direktur' => 'Nama Direktur',
            'alamat' => 'Alamat Badan Usaha',
            'email' => 'badanusaha@example.com',
            'telepon' => '08123456789',
            'no_akta' => 'Nomor Akta',
            'tgl_akta' => now(),
            'klasifikasi' => 'Klasifikasi Badan Usaha',
            'status' => true,
            'jumlah_pekerjaan' => 0,
            'author_id' => 1,
        ]);

        TenagaAhli::create([
            'nama' => 'Nama Tenaga Ahli',
            'slug' => Str::slug('Nama Tenaga Ahli'),
            'nik' => '1234567890123456',
            'npwp' => '1234567890',
            'badan_usaha_id' => 1,
            'jabatan' => 'Jabatan Tenaga Ahli',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => now()->subYears(30),
            'alamat' => 'Alamat Tenaga Ahli',
            'kelamin' => true,
            'email' => 'tenagaahli@example.com',
            'telepon' => '08123456789',
            'keahlian' => 'Keahlian Tenaga Ahli',
            'status' => true,
            'status_pekerjaan' => true,
            'author_id' => 1,
        ]);

        RiwayatPendidikan::create([
            'nama' => 'Nama Riwayat Pendidikan',
            'slug' => Str::slug('Nama Riwayat Pendidikan'),
            'jurusan' => 'Jurusan Pendidikan',
            'gelar' => 'Gelar Akademik',
            'thn_masuk' => '2010',
            'thn_lulus' => '2014',
            'ijazah' => 'Nomor Ijazah',
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
