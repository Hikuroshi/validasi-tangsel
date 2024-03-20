@extends('layouts.main')

@section('css')

<!-- Flatpickr css -->
<link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">

<!-- Select2 CSS -->
<link rel="stylesheet" href="/assets/css/select2.min.css">

@endsection

@section('container')

@if(session()->has('perusahaan_full'))
    <div id="dismiss-secondary" class="bg-danger/10 text-danger border border-danger/20 text-sm rounded py-3 px-5 flex justify-between items-center mb-6">
        <p>
            <span class="font-bold">{{ session('perusahaan_full') }}</span>
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
            Inputkan data tenaga ahli dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid gap-6">
            <div>
                <form method="POST" action="{{ route('pekerjaan.store') }}">
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Nama Pekerjaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="form-input">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="perusahaan_id">Perusahaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="perusahaan_id" name="perusahaan_id" class="form-select">
                                <option></option>
                                @foreach ($perusahaans as $perusahaan)
                                <option value="{{ $perusahaan->id }}" @selected(old('perusahaan_id') == $perusahaan->id)>
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

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="no_kontrak">No Kontrak <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="no_kontrak" name="no_kontrak" value="{{ old('no_kontrak') }}" class="form-input">
                            @error('no_kontrak')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="tgl_kontrak">Tanggal Kontrak <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="tgl_kontrak" name="tgl_kontrak" value="{{ old('tgl_kontrak') }}" class="form-input">
                            @error('tgl_kontrak')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="tgl_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai') }}" class="form-input">
                            @error('tgl_mulai')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="tgl_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="tgl_selesai" name="tgl_selesai" value="{{ old('tgl_selesai') }}" class="form-input">
                            @error('tgl_selesai')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="ppk">PPK <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="ppk" name="ppk" value="{{ old('ppk') }}" class="form-input">
                            @error('ppk')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="pptk">PPTK <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="pptk" name="pptk" value="{{ old('pptk') }}" class="form-input">
                            @error('pptk')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="jenis_pekerjaan_id">Jenis Pekerjaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="jenis_pekerjaan_id" name="jenis_pekerjaan_id" class="form-select">
                                <option value=""></option>
                                @foreach ($jenis_pekerjaans as $jenis_pekerjaan)
                                <option value="{{ $jenis_pekerjaan->id }}" @selected(old('jenis_pekerjaan_id') == $jenis_pekerjaan->id)>
                                    {{ $jenis_pekerjaan->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_pekerjaan_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="deskripsi" name="deskripsi" class="form-input" rows="5">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nilai_pagu">Nilai Pagu <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nilai_pagu" name="nilai_pagu" value="{{ old('nilai_pagu') }}" class="form-input currency-input">
                            @error('nilai_pagu')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nilai_kontrak">Nilai Kontrak <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nilai_kontrak" name="nilai_kontrak" value="{{ old('nilai_kontrak') }}" class="form-input currency-input">
                            @error('nilai_kontrak')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="lokasi">Lokasi <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="lokasi" name="lokasi" class="form-input" rows="5">{{ old('lokasi') }}</textarea>
                            @error('lokasi')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="sumber_dana">Sumber Dana <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="sumber_dana" name="sumber_dana" class="form-select">
                                <option></option>
                                @foreach ($sumber_danas as $sumber_dana)
                                <option value="{{ $sumber_dana }}" @selected(old('sumber_dana') == $sumber_dana)>
                                    {{ $sumber_dana }}
                                </option>
                                @endforeach
                            </select>
                            @error('sumber_dana')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="thn_anggaran">Tahun Anggaran <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="number" id="thn_anggaran" name="thn_anggaran" value="{{ old('thn_anggaran') }}" class="form-input" min="1901" max="{{ now()->format('Y') }}" step="1">
                            @error('thn_anggaran')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="thn_anggaran">Tahun Anggaran <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="thn_anggaran" name="thn_anggaran" class="form-select">
                                <option></option>
                                <option value="2024" @selected(old('thn_anggaran') == 2024)>2024</option>
                            </select>
                            @error('thn_anggaran')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="metode_id">Metode Pengadaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="metode_id" name="metode_id" class="form-select">
                                <option value=""></option>
                                @foreach ($metodes as $metode)
                                <option value="{{ $metode->id }}" @selected(old('metode_id') == $metode->id)>
                                    {{ $metode->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('metode_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="jenis_kontruksi">Jenis Kontruksi <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="jenis_kontruksi" name="jenis_kontruksi" value="{{ old('jenis_kontruksi') }}" class="form-input">
                            @error('jenis_kontruksi')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="status_pekerjaan_id">Status Pekerjaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="status_pekerjaan_id" name="status_pekerjaan_id" class="form-select">
                                <option value=""></option>
                                @foreach ($status_pekerjaans as $status_pekerjaan)
                                <option value="{{ $status_pekerjaan->id }}" @selected(old('status_pekerjaan_id') == $status_pekerjaan->id)>
                                    {{ $status_pekerjaan->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('status_pekerjaan_id')
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

<script src="/assets/js/jquery-3.7.1.min.js"></script>

<!-- Flatpickr Plugin Js -->
<script src="/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="/assets/libs/flatpickr/id.js"></script>

<!-- Select2 js -->
<script src="/assets/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $('#perusahaan_id').on('change', function(){
            var perusahaanId = $(this).val();
            var url = perusahaanId ? '/get-tenaga-ahli/' + perusahaanId : '/get-tenaga-ahli';

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#tenaga_ahli_id').empty();
                    $.each(data, function(key, value) {
                        $('#tenaga_ahli_id').append('<option value="' + value.id + '">' + value.nama + '</option>');
                    });
                }
            });
        });
    });
</script>

<script>
    flatpickr("#tgl_kontrak", {
        locale: "id",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    });
    flatpickr("#tgl_mulai", {
        locale: "id",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    });
    flatpickr("#tgl_selesai", {
        locale: "id",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    $(document).ready(function() {
        $('.select2').select2();

        let selectedOptions = {{ Js::from(old('tenaga_ahli_id')) }};
        $('.select2').val(selectedOptions).trigger('change');
    });
</script>

<script>
    $(document).ready(function() {
        $('#jenis_jasa_id').on('change', function() {
            let jenisJasaId = $(this).val();
            if (jenisJasaId) {
                $.ajax({
                    url: '/get-jenis-pekerjaan/' + jenisJasaId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        $('#jenis_pekerjaan_id').empty();
                        $('#jenis_pekerjaan_id').append('<option value=""></option>');
                        $.each(data, function(key, value) {
                            $('#jenis_pekerjaan_id').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
                        });
                    }
                });
            } else {
                $('#jenis_pekerjaan_id').empty();
                $('#sub_pekerjaan_id').empty();
                $('#jenis_pekerjaan_id').append('<option value=""></option>');
                $('#sub_pekerjaan_id').append('<option value=""></option>');
            }
        });

        $('#jenis_pekerjaan_id').on('change', function(){
            let jenisPekerjaanId = $(this).val();
            if (jenisPekerjaanId) {
                $.ajax({
                    url: '/get-sub-pekerjaan/' + jenisPekerjaanId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#sub_pekerjaan_id').empty();
                        $('#sub_pekerjaan_id').append('<option value=""></option>');
                        $.each(data, function(key, value) {
                            $('#sub_pekerjaan_id').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
                        });
                    }
                });
            } else {
                $('#sub_pekerjaan_id').empty();
                $('#sub_pekerjaan_id').append('<option value=""></option>');
            }
        });

        $('.currency-input').on('input', function() {
            formatCurrencyInputs()
        });

        formatCurrencyInputs()

        function formatCurrencyInputs() {
            $('.currency-input').each(function() {
                let input = $(this).val();
                let sanitized = input.replace(/[^0-9]/g, '');
                let formatted = sanitized.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(formatted);
            });
        }

        $('form').submit(function() {
            $('.currency-input').each(function() {
                let input = $(this).val();
                let sanitized = input.replace(/[^0-9]/g, '');
                $(this).val(sanitized);
            });
        });
    });
</script>

<!-- Init js -->
<script src="/assets/js/pages/form-advanced.init.js"></script>

@endsection