<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Metode;
use App\Models\Perusahaan;
use App\Models\JenisJasa;
use App\Models\JenisPekerjaan;
use App\Models\RiwayatPendidikan;
use App\Models\StatusPekerjaan;
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
            'direktur' => 'Jane Doe',
            'alamat' => 'Jl. Harmoni No. 456',
            'email' => 'ptcahayaabadi@example.com',
            'telepon' => '081234567890',
            'status' => true,
            'jumlah_pekerjaan' => 0,
            'author_id' => 1,
        ]);

        TenagaAhli::create([
            'nama' => 'Rudi Hartono',
            'slug' => Str::slug('Rudi Hartono'),
            'nik' => '1234567890123456',
            'npwp' => '0987653244321',
            'perusahaan_id' => 1,
            'jabatan' => 'Programmer',
            'tempat_lahir' => 'Bandung',
            'tgl_lahir' => now()->subYears(30),
            'alamat' => 'Jl. Programmer No. 789',
            'kelamin' => false,
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
            'direktur' => 'Ahmad Yani',
            'alamat' => 'Jl. Maju No. 789',
            'email' => 'ptmajusejahtera@example.com',
            'telepon' => '089876543210',
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
            'direktur' => 'Rina Indah',
            'alamat' => 'Jl. Makmur No. 345',
            'email' => 'ptbersamamakmur@example.com',
            'telepon' => '0987675432109',
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
            'kelamin' => false,
            'email' => 'andiwijaya@example.com',
            'telepon' => '0987365432109',
            'keahlian' => 'Manajemen Bisnis',
            'status' => true,
            'status_pekerjaan' => true,
            'author_id' => 1,
        ]);

        Perusahaan::create([
            'nama' => 'PT Berkah Sentosa',
            'slug' => Str::slug('PT Berkah Sentosa'),
            'npwp' => '6789012345',
            'direktur' => 'Dewi Lestari',
            'alamat' => 'Jl. Sentosa No. 123',
            'email' => 'ptberkahsentosa@example.com',
            'telepon' => '076543210987',
            'status' => true,
            'jumlah_pekerjaan' => 0,
            'author_id' => 1,
        ]);

        TenagaAhli::create([
            'nama' => 'Siti Nurhayati',
            'slug' => Str::slug('Siti Nurhayati'),
            'nik' => '9012345678901234',
            'npwp' => '2109876543',
            'perusahaan_id' => 4,
            'jabatan' => 'Manajer Hotel',
            'tempat_lahir' => 'Bali',
            'tgl_lahir' => now()->subYears(38),
            'alamat' => 'Jl. Manajer No. 456',
            'kelamin' => false,
            'email' => 'sitinurhayati@example.com',
            'telepon' => '076543210987',
            'keahlian' => 'Manajemen Hotel',
            'status' => true,
            'status_pekerjaan' => true,
            'author_id' => 1,
        ]);

        Perusahaan::create([
            'nama' => 'PT Cahaya Cemerlang',
            'slug' => Str::slug('PT Cahaya Cemerlang'),
            'npwp' => '5432109876',
            'direktur' => 'Siti Rahayu',
            'alamat' => 'Jl. Cemerlang No. 789',
            'email' => 'ptcahayacemerlang@example.com',
            'telepon' => '087654321098',
            'status' => true,
            'jumlah_pekerjaan' => 0,
            'author_id' => 1,
        ]);

        TenagaAhli::create([
            'nama' => 'Ani Suryani',
            'slug' => Str::slug('Ani Suryani'),
            'nik' => '7654321098765432',
            'npwp' => '0987654375621',
            'perusahaan_id' => 5,
            'jabatan' => 'Akuntan',
            'tempat_lahir' => 'Yogyakarta',
            'tgl_lahir' => now()->subYears(28),
            'alamat' => 'Jl. Akuntan No. 123',
            'kelamin' => true,
            'email' => 'anisuryani@example.com',
            'telepon' => '087654321098',
            'keahlian' => 'Keuangan',
            'status' => true,
            'status_pekerjaan' => true,
            'author_id' => 1,
        ]);

        Perusahaan::create([
            'nama' => 'PT Mandiri Sejahtera',
            'slug' => Str::slug('PT Mandiri Sejahtera'),
            'npwp' => '012987654321',
            'direktur' => 'Agus Salim',
            'alamat' => 'Jl. Mandiri No. 345',
            'email' => 'ptmandirisejahtera@example.com',
            'telepon' => '02398765432109',
            'status' => true,
            'jumlah_pekerjaan' => 0,
            'author_id' => 1,
        ]);

        TenagaAhli::create([
            'nama' => 'Dewi Kartika',
            'slug' => Str::slug('Dewi Kartika'),
            'nik' => '8765432109876543',
            'npwp' => '7654321098',
            'perusahaan_id' => 6,
            'jabatan' => 'Guru',
            'tempat_lahir' => 'Malang',
            'tgl_lahir' => now()->subYears(25),
            'alamat' => 'Jl. Guru No. 678',
            'kelamin' => true,
            'email' => 'dewikartika@example.com',
            'telepon' => '0987654432109',
            'keahlian' => 'Pendidikan',
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

        JenisPekerjaan::create([
            'nama' => 'Arsitektur',
            'slug' => Str::slug('Arsitektur'),
            'author_id' => 1,
        ]);
        JenisPekerjaan::create([
            'nama' => 'Teknik Sipil',
            'slug' => Str::slug('Teknik Sipil'),
            'author_id' => 1,
        ]);
        JenisPekerjaan::create([
            'nama' => 'Manajemen Proyek Konstruksi',
            'slug' => Str::slug('Manajemen Proyek Konstruksi'),
            'author_id' => 1,
        ]);
        JenisPekerjaan::create([
            'nama' => 'Konstruksi Bangunan',
            'slug' => Str::slug('Konstruksi Bangunan'),
            'author_id' => 1,
        ]);
        JenisPekerjaan::create([
            'nama' => 'Pengawasan Konstruksi',
            'slug' => Str::slug('Pengawasan Konstruksi'),
            'author_id' => 1,
        ]);

        // StatusPekerjaan::create([
        //     'nama' => 'Request',
        //     'slug' => Str::slug('Request'),
        //     'author_id' => 1,
        // ]);
        // StatusPekerjaan::create([
        //     'nama' => 'On Progress',
        //     'slug' => Str::slug('On Progress'),
        //     'author_id' => 1,
        // ]);
        // StatusPekerjaan::create([
        //     'nama' => 'Reporting',
        //     'slug' => Str::slug('Reporting'),
        //     'author_id' => 1,
        // ]);
        // StatusPekerjaan::create([
        //     'nama' => 'Done',
        //     'slug' => Str::slug('Done'),
        //     'author_id' => 1,
        // ]);
        // StatusPekerjaan::create([
        //     'nama' => 'Pending',
        //     'slug' => Str::slug('Pending'),
        //     'author_id' => 1,
        // ]);
        // StatusPekerjaan::create([
        //     'nama' => 'Cancelled',
        //     'slug' => Str::slug('Cancelled'),
        //     'author_id' => 1,
        // ]);

        Metode::create([
            'nama' => 'Tender',
            'slug' => Str::slug('Tender'),
            'author_id' => 1,
        ]);
        Metode::create([
            'nama' => 'Penunjukan Langsung',
            'slug' => Str::slug('Penunjukan Langsung'),
            'author_id' => 1,
        ]);
    }
}
