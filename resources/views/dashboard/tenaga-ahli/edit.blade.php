@extends('layouts.main')

@section('container')

<div class="card mb-6">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data tenaga ahli dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid xl:grid-cols-2 gap-6">
            <div>
                <form method="POST" action="{{ route('tenaga-ahli.update', $tenaga_ahli->slug) }}">
                    @method('put')
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Nama <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $tenaga_ahli->nama) }}" class="form-input" placeholder="Nama">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nik">NIK <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nik" name="nik" value="{{ old('nik', $tenaga_ahli->nik) }}" class="form-input" placeholder="NIK">
                            @error('nik')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="telepon">Telepon <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $tenaga_ahli->telepon) }}" class="form-input" placeholder="Telepon">
                            @error('telepon')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="email">Email <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="email" id="email" name="email" value="{{ old('email', $tenaga_ahli->email) }}" class="form-input" placeholder="Email">
                            @error('email')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="alamat">Alamat <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="alamat" name="alamat" class="form-input" rows="5" placeholder="Alamat">{{ old('alamat', $tenaga_ahli->alamat) }}</textarea>
                            @error('alamat')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="perusahaan_id">Perusahaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="perusahaan_id" name="perusahaan_id" class="form-select">
                                <option>Pilih Perusahaan</option>
                                @foreach ($perusahaans as $perusahaan)
                                <option value="{{ $perusahaan->id }}" @selected(old('perusahaan_id', $tenaga_ahli->perusahaan_id) == $perusahaan->id)>
                                    {{ $perusahaan->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('perusahaan_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <div></div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('tenaga-ahli.index') }}" class="btn bg-secondary/90 text-white hover:bg-secondary text-end">Kembali</a>
                            <button type="submit" class="btn bg-primary/90 text-white hover:bg-primary text-end">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection