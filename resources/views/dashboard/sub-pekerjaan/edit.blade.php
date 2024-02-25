@extends('layouts.main')

@section('container')

<div class="card mb-6">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data jenis pekerjaan dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid xl:grid-cols-2 gap-6">
            <div>
                <form method="POST" action="{{ route('sub-pekerjaan.update', $sub_pekerjaan->slug) }}">
                    @method('put')
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="jenis_pekerjaan_id">Jenis Pekerjaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="jenis_pekerjaan_id" name="jenis_pekerjaan_id" class="form-select">
                                <option>Pilih Jenis Pekerjaan</option>
                                @foreach ($jenis_pekerjaans as $jenis_pekerjaan)
                                <option value="{{ $jenis_pekerjaan->id }}" @selected(old('jenis_pekerjaan_id', $sub_pekerjaan->jenis_pekerjaan_id) == $jenis_pekerjaan->id)>
                                    {{ $jenis_pekerjaan->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_pekerjaan_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Jenis Pekerjaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $jenis_pekerjaan->nama) }}" class="form-input" placeholder="Jenis Pekerjaan">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <div></div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('sub-pekerjaan.index') }}" class="btn bg-secondary/90 text-white hover:bg-secondary text-end">Kembali</a>
                            <button type="submit" class="btn bg-primary/90 text-white hover:bg-primary text-end">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection