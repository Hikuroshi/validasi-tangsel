<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Perusahaan;
use App\Models\JenisJasa;
use App\Models\JenisPekerjaan;
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

        Perusahaan::create([
            'nama' => 'PT Cahaya Abadi',
            'slug' => Str::slug('PT Cahaya Abadi'),
            'npwp' => '0123456789',
            'sertifikat' => '9876543210',
            'registrasi' => '1234567890',
            'direktur' => 'Jane Doe',
            'alamat' => 'Jl. Harmoni No. 456',
            'email' => 'ptcahayaabadi@example.com',
            'telepon' => '081234567890',
            'no_akta' => '1357924680',
            'tgl_akta' => now(),
            'klasifikasi' => 'Teknologi Informasi',
            'status' => true,
            'jumlah_pekerjaan' => 0,
            'author_id' => 1,
        ]);

        TenagaAhli::create([
            'nama' => 'Rudi Hartono',
            'slug' => Str::slug('Rudi Hartono'),
            'nik' => '1234567890123456',
            'npwp' => '0987654321',
            'perusahaan_id' => 1,
            'jabatan' => 'Programmer',
            'tempat_lahir' => 'Bandung',
            'tgl_lahir' => now()->subYears(30),
            'alamat' => 'Jl. Programmer No. 789',
            'kelamin' => true,
            'email' => 'rudihartono@example.com',
            'telepon' => '081234567890',
            'keahlian' => 'Pemrograman',
            'status' => true,
            'status_pekerjaan' => true,
            'author_id' => 1,
        ]);

        Perusahaan::create([
            'nama' => 'PT Maju Sejahtera',
            'slug' => Str::slug('PT Maju Sejahtera'),
            'npwp' => '1357924680',
            'sertifikat' => '5678901234',
            'registrasi' => '6789012345',
            'direktur' => 'Ahmad Yani',
            'alamat' => 'Jl. Maju No. 789',
            'email' => 'ptmajusejahtera@example.com',
            'telepon' => '089876543210',
            'no_akta' => '9876543210',
            'tgl_akta' => now(),
            'klasifikasi' => 'Perdagangan',
            'status' => true,
            'jumlah_pekerjaan' => 0,
            'author_id' => 1,
        ]);

        TenagaAhli::create([
            'nama' => 'Budi Santoso',
            'slug' => Str::slug('Budi Santoso'),
            'nik' => '6789012345678901',
            'npwp' => '5432109876',
            'perusahaan_id' => 2,
            'jabatan' => 'Marketing',
            'tempat_lahir' => 'Surabaya',
            'tgl_lahir' => now()->subYears(32),
            'alamat' => 'Jl. Marketer No. 123',
            'kelamin' => true,
            'email' => 'budisantoso@example.com',
            'telepon' => '089876543210',
            'keahlian' => 'Pemasaran',
            'status' => true,
            'status_pekerjaan' => true,
            'author_id' => 1,
        ]);

        Perusahaan::create([
            'nama' => 'PT Bersama Makmur',
            'slug' => Str::slug('PT Bersama Makmur'),
            'npwp' => '5678901234',
            'sertifikat' => '0987654321',
            'registrasi' => '3456789012',
            'direktur' => 'Rina Indah',
            'alamat' => 'Jl. Makmur No. 345',
            'email' => 'ptbersamamakmur@example.com',
            'telepon' => '098765432109',
            'no_akta' => '5432109876',
            'tgl_akta' => now(),
            'klasifikasi' => 'Konsultan',
            'status' => true,
            'jumlah_pekerjaan' => 0,
            'author_id' => 1,
        ]);

        TenagaAhli::create([
            'nama' => 'Andi Wijaya',
            'slug' => Str::slug('Andi Wijaya'),
            'nik' => '3456789012345678',
            'npwp' => '4321098765',
            'perusahaan_id' => 3,
            'jabatan' => 'Konsultan Bisnis',
            'tempat_lahir' => 'Semarang',
            'tgl_lahir' => now()->subYears(40),
            'alamat' => 'Jl. Konsultan No. 678',
            'kelamin' => true,
            'email' => 'andiwijaya@example.com',
            'telepon' => '098765432109',
            'keahlian' => 'Manajemen Bisnis',
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
