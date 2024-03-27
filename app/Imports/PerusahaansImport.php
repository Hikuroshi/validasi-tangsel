<?php

namespace App\Imports;

use App\Models\Perusahaan;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PerusahaansImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $slug = SlugService::createSlug(Perusahaan::class, 'slug', $row['nama']);
        $author_id = auth()->user()->id;
        $status = str_contains($row['status_aktif'], 'Ya') ? 1 : 0;

        $npwp = str_replace(['.', '-', ' '], '', $row['npwp']);
        $npwp = substr($npwp, 0, 2) . '.' . substr($npwp, 2, 3) . '.' . substr($npwp, 5, 3) . '.' . substr($npwp, 8, 1) . '-' . substr($npwp, 9, 3) . '.' . substr($npwp, 12);

        $telepon = $row['telepon'] ?? null;
        if ($row['telepon']) {
            $telepon = str_replace([' ', '-'], '', $telepon);
            $telepon = substr($telepon, 0, 4) . ' ' . substr($telepon, 4, 4) . ' ' . substr($telepon, 8, 5); // Format telepon: 0000 0000 00000
        }

        $perusahaan = [
            'nama' => $row['nama'],
            'slug' => $slug,
            'npwp' => $npwp,
            'direktur' => $row['direktur'],
            'alamat' => $row['alamat'],
            'email' => $row['email'] ?? null,
            'telepon' => $telepon,
            'status' => $status,
            'author_id' => $author_id,
            'created_at' => now(),
        ];

        return new Perusahaan($perusahaan);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'npwp' => 'required|max:21|unique:perusahaans',
            'direktur' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'nullable|string|email|max:255|unique:perusahaans',
            'telepon' => 'nullable|max:15|unique:perusahaans',
            'status_aktif' => 'required|in:Ya,Tidak',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Nama tidak boleh kosong.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'npwp.required' => 'NPWP tidak boleh kosong.',
            'npwp.max' => 'NPWP tidak boleh lebih dari 255 karakter.',
            'npwp.unique' => 'NPWP sudah digunakan.',
            'direktur.required' => 'Direktur tidak boleh kosong.',
            'direktur.string' => 'Direktur harus berupa teks.',
            'direktur.max' => 'Direktur tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'telepon.max' => 'Nomor telepon tidak boleh lebih dari 255 karakter.',
            'telepon.unique' => 'Nomor telepon sudah digunakan.',
            'status.required' => 'Status tidak boleh kosong.',
            'status.in' => 'Status harus berupa string "Ya" atau "Tidak".',
        ];
    }
}
