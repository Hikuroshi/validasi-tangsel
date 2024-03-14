@extends('layouts.main')

@section('css')

<!-- Flatpickr css -->
<link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">

@endsection

@section('container')

<div class="card mb-6">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }} {{ session('flash_badan_usaha_nama') }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data tenaga ahli dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid gap-6">
            <div>
                <form method="POST" action="{{ route('tenaga-ahli.store') }}">
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nik">No KTP <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}" class="form-input" placeholder="No KTP">
                            @error('nik')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="npwp">NPWP <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="npwp" name="npwp" value="{{ old('npwp') }}" class="form-input" placeholder="NPWP">
                            @error('npwp')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Nama <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="form-input" placeholder="Nama">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="badan_usaha_id">Badan Usaha <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="badan_usaha_id" name="badan_usaha_id" class="form-select" {{ session('flash_badan_usaha_id') ? 'disabled' : '' }}>
                                <option>Pilih Badan Usaha</option>
                                @foreach ($badan_usahas as $badan_usaha)
                                <option value="{{ $badan_usaha->id }}" @selected(old('badan_usaha_id', session('flash_badan_usaha_id')) == $badan_usaha->id)>
                                    {{ $badan_usaha->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('badan_usaha_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="jabatan">Jabatan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" class="form-input" placeholder="Jabatan">
                            @error('jabatan')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-input" placeholder="Tempat Lahir">
                            @error('tempat_lahir')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="humanfd-datepicker">Tanggal Lahir <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="humanfd-datepicker" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="form-input" placeholder="{{ now()->format('F j, Y') }}">
                            @error('tgl_lahir')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="alamat">Alamat <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="alamat" name="alamat" class="form-input" rows="5" placeholder="Alamat">{{ old('alamat') }}</textarea>
                            @error('alamat')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="kelamin" name="kelamin" class="form-select">
                                <option value="">Pilih Kelamin</option>
                                <option value="1" @selected(old('kelamin') == '1')>Laki-laki</option>
                                <option value="0" @selected(old('kelamin') == '0')>Perempuan</option>
                            </select>
                            @error('kelamin')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="email">Email <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="Email">
                            @error('email')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="telepon">No Telp <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}" class="form-input" placeholder="No Telp">
                            @error('telepon')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="keahlian">Keahlian <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="keahlian" name="keahlian" class="form-input" rows="5" placeholder="Keahlian">{{ old('keahlian') }}</textarea>
                            @error('keahlian')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="status">Status <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="status" name="status" class="form-select">
                                <option value="1" @selected(old('status') == '1')>Aktif</option>
                                <option value="0" @selected(old('status') == '0')>Tidak Aktif</option>
                            </select>
                            @error('status')
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

@section('js')

<!-- Flatpickr Plugin Js -->
<script src="/assets/libs/flatpickr/flatpickr.min.js"></script>

<script>
    flatpickr("#humanfd-datepicker", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    });
</script>

<!-- Init js -->
<script src="/assets/js/pages/form-advanced.init.js"></script>

@endsection