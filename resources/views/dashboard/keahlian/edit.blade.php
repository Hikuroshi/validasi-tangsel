@extends('layouts.main')

@section('container')

<div class="card mb-6">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }} {{ $tenaga_ahli_nama }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data riwayat pendidikan dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid gap-6">
            <div>
                <form method="POST" action="{{ route('keahlian.update', $keahlian->slug) }}" enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Keahlian <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $keahlian->nama) }}" class="form-input" placeholder="Keahlian">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="no_sertifikat">No Sertifikat <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="no_sertifikat" name="no_sertifikat" value="{{ old('no_sertifikat', $keahlian->no_sertifikat) }}" class="form-input" placeholder="No Sertifikat">
                            @error('no_sertifikat')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="thn_sertifikat">Tahun Sertifikat <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="number" id="thn_sertifikat" name="thn_sertifikat" value="{{ old('thn_sertifikat', $keahlian->thn_sertifikat) }}" class="form-input" placeholder="Tahun Sertifikat" min="1901" max="{{ now()->format('Y') }}" step="1">
                            @error('thn_sertifikat')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="file_sertifikat">Sertifikat <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="file" id="file_sertifikat" name="file_sertifikat" accept="application/pdf" class="form-input border" placeholder="Sertifikat">
                            <input type="hidden" name="old_file_sertifikat" value="{{ $keahlian->file_sertifikat }}">
                            @error('file_sertifikat')
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