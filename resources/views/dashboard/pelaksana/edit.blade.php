@extends('layouts.main')

@section('css')

<!-- Flatpickr css -->
<link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">

<!-- Select2 CSS -->
<link rel="stylesheet" href="/assets/css/select2.min.css">

@endsection

@section('container')

@if(session()->has('badan_usaha_full'))
    <div id="dismiss-secondary" class="bg-danger/10 text-danger border border-danger/20 text-sm rounded py-3 px-5 flex justify-between items-center mb-6">
        <p>
            <span class="font-bold">{{ session('badan_usaha_full') }}</span>
        </p>
        <button class="text-xl/[0]" data-hs-remove-element="#dismiss-secondary" type="button">
            <i class="uil uil-multiply text-xl"></i>
        </button>
    </div>
@endif
@if(session()->has('tenaga_ahli_full'))
    <div id="dismiss-secondary" class="bg-danger/10 text-danger border border-danger/20 text-sm rounded py-3 px-5 flex justify-between items-center mb-6">
        <p>
            <span class="font-bold">{{ session('tenaga_ahli_full') }}</span>
        </p>
        <button class="text-xl/[0]" data-hs-remove-element="#dismiss-secondary" type="button">
            <i class="uil uil-multiply text-xl"></i>
        </button>
    </div>
@endif

<div class="card mb-6">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data pelaksana dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid gap-6">
            <div>
                <form method="POST" action="{{ route('pelaksana.update', $pelaksana->slug) }}">
                    @method('put')
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="badan_usaha_id">Badan Usaha <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="badan_usaha_id" name="badan_usaha_id" class="form-select">
                                <option>Pilih Badan Usaha</option>
                                @foreach ($badan_usahas as $badan_usaha)
                                <option value="{{ $badan_usaha->id }}" @selected(old('badan_usaha_id', $pelaksana->badan_usaha_id) == $badan_usaha->id)>
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

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="pekerjaan_id">Pekerjaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="pekerjaan_id" name="pekerjaan_id" class="form-select">
                                <option>Pilih Pekerjaan</option>
                                @foreach ($pekerjaans as $pekerjaan)
                                <option value="{{ $pekerjaan->id }}" @selected(old('pekerjaan_id', $pelaksana->pekerjaan_id) == $pekerjaan->id)>
                                    {{ $pekerjaan->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('pekerjaan_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="no_kontrak">No Kontrak <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="no_kontrak" name="no_kontrak" value="{{ old('no_kontrak', $pelaksana->no_kontrak) }}" class="form-input" placeholder="No Kontrak">
                            @error('no_kontrak')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="tgl_kontrak">Tanggal Kontrak <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="tgl_kontrak" name="tgl_kontrak" value="{{ old('tgl_kontrak', $pelaksana->tgl_kontrak) }}" class="form-input" placeholder="Tanggal Kontrak">
                            @error('tgl_kontrak')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="tgl_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai', $pelaksana->tgl_mulai) }}" class="form-input" placeholder="Tanggal Mulai">
                            @error('tgl_mulai')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="tgl_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="tgl_selesai" name="tgl_selesai" value="{{ old('tgl_selesai', $pelaksana->tgl_selesai) }}" class="form-input" placeholder="Tanggal Selesai">
                            @error('tgl_selesai')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="ppk">PPK <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="ppk" name="ppk" value="{{ old('ppk', $pelaksana->ppk) }}" class="form-input" placeholder="PPK">
                            @error('ppk')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="pptk">PPTK <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="pptk" name="pptk" value="{{ old('pptk', $pelaksana->pptk) }}" class="form-input" placeholder="PPTK">
                            @error('pptk')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="pho">PHO <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="pho" name="pho" value="{{ old('pho', $pelaksana->pho) }}" class="form-input" placeholder="PHO">
                            @error('pho')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="status_pelaksana">Status <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="status_pelaksana" name="status_pelaksana" class="form-select">
                                <option>Pilih Status</option>
                                @foreach ($status_pelaksanas as $key => $value)
                                    <option value="{{ $key }}" @selected(old('status_pelaksana', $pelaksana->status_pelaksana_f['slug']) == $key)>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_pelaksana')
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

<!-- Select2 js -->
<script src="/assets/js/select2.min.js"></script>

<script>
    flatpickr("#tgl_kontrak", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    });
    flatpickr("#tgl_mulai", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    });
    flatpickr("#tgl_selesai", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    });


    $(document).ready(function() {
        $('.select2').select2();

        let selectedOptions = {{ Js::from(old('tenaga_ahli_id', $selected_tenaga_ahlis)) }};
        $('.select2').val(selectedOptions).trigger('change');
    });
</script>

<!-- Init js -->
<script src="/assets/js/pages/form-advanced.init.js"></script>

@endsection