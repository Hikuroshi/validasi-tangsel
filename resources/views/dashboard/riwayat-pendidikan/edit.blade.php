@extends('layouts.main')

@section('container')

<div class="card mb-6">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }} {{ $tenaga_ahli_nama }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data riwayat pendidikan dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid xl:grid-cols-2 gap-6">
            <div>
                <form method="POST" action="{{ route('riwayat-pendidikan.update', $riwayat_pendidikan->slug) }}">
                    @method('put')
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Nama Lembaga <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $riwayat_pendidikan->nama) }}" class="form-input" placeholder="Nama Lembaga">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="jurusan">Jurusan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan', $riwayat_pendidikan->jurusan) }}" class="form-input" placeholder="Jurusan">
                            @error('jurusan')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="gelar">Gelar <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="gelar" name="gelar" value="{{ old('gelar', $riwayat_pendidikan->gelar) }}" class="form-input" placeholder="Gelar">
                            @error('gelar')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="thn_masuk">Tahun Masuk <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="number" id="thn_masuk" name="thn_masuk" value="{{ old('thn_masuk', $riwayat_pendidikan->thn_masuk) }}" class="form-input" placeholder="Tahun Masuk" min="1901" max="{{ now()->format('Y') }}" step="1">
                            @error('thn_masuk')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="thn_lulus">Tahun Lulus <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="number" id="thn_lulus" name="thn_lulus" value="{{ old('thn_lulus', $riwayat_pendidikan->thn_lulus) }}" class="form-input" placeholder="Tahun Lulus" min="1901" max="{{ now()->format('Y') }}" step="1">
                            @error('thn_lulus')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="ijazah">Ijazah <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="ijazah" name="ijazah" value="{{ old('ijazah', $riwayat_pendidikan->ijazah) }}" class="form-input" placeholder="Ijazah">
                            @error('ijazah')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <div></div>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" onclick="history.back()" class="btn bg-secondary/90 text-white hover:bg-secondary text-end">Kembali</button>
                            <button type="submit" class="btn bg-primary/90 text-white hover:bg-primary text-end">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection