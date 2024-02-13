@extends('layouts.main')

@section('css')

<!-- Flatpickr css -->
<link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">

<!-- Select2 CSS -->
<link rel="stylesheet" href="/assets/css/select2.min.css">

@endsection

@section('container')

<div class="card mb-6">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data kontrak dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid xl:grid-cols-2 gap-6">
            <div>
                <form method="POST" action="{{ route('kontrak.update', $kontrak->slug) }}">
                    @method('put')
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Nama <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $kontrak->nama) }}" class="form-input" placeholder="Nama">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="humanfd-datepicker">Tanggal Mulai <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="humanfd-datepicker" name="tgl_mulai" value="{{ old('tgl_mulai', $kontrak->tgl_mulai) }}" class="form-input" placeholder="{{ Carbon\Carbon::parse($kontrak->tgl_mulai)->format('F j, Y') }}">
                            @error('tgl_mulai')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="lama">Lama Hari <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="number" id="lama" name="lama" value="{{ old('lama', $kontrak->lama) }}" class="form-input" placeholder="Lama hari">
                            @error('lama')
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
                                <option value="{{ $perusahaan->id }}" @selected(old('perusahaan_id', $kontrak->perusahaan_id) == $perusahaan->id)>
                                    {{ $perusahaan->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('perusahaan_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="tenaga_ahli_id">Tenaga Ahli <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="tenaga_ahli_id" name="tenaga_ahli_id[]" class="form-select select2" multiple="multiple">
                                @foreach ($tenaga_ahlis as $tenaga_ahli)
                                <option value="{{ $tenaga_ahli->id }}">
                                    {{ $tenaga_ahli->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('tenaga_ahli_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <div></div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('kontrak.index') }}" class="btn bg-secondary/90 text-white hover:bg-secondary text-end">Kembali</a>
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

<!-- Select2 js -->
<script src="/assets/js/select2.min.js"></script>

<script>
    flatpickr("#humanfd-datepicker", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    });

    $(document).ready(function() {
        $('.select2').select2();

        let selectedOptions = {{ Js::from(old('tenaga_ahli_id', $kontrak->tenaga_ahlis->pluck('id'))) }};
        $('.select2').val(selectedOptions).trigger('change');
    });
</script>

<!-- Init js -->
<script src="/assets/js/pages/form-advanced.init.js"></script>

@endsection