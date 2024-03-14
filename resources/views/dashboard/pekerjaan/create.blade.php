@extends('layouts.main')

@section('container')

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
                        <label class="mb-2" for="jenis_jasa_id">Jenis Jasa <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="jenis_jasa_id" name="jenis_jasa_id" class="form-select">
                                <option value="">Pilih Jenis Jasa</option>
                                @foreach ($jenis_jasas as $jenis_jasa)
                                <option value="{{ $jenis_jasa->id }}" @selected(old('jenis_jasa_id') == $jenis_jasa->id)>
                                    {{ $jenis_jasa->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_jasa_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="jenis_pekerjaan_id">Jenis Pekerjaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="jenis_pekerjaan_id" name="jenis_pekerjaan_id" class="form-select">
                                <option>Pilih Jenis Pekerjaan</option>
                            </select>
                            @error('jenis_pekerjaan_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="sub_pekerjaan_id">Sub Pekerjaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="sub_pekerjaan_id" name="sub_pekerjaan_id" class="form-select">
                                <option>Pilih Sub Pekerjaan</option>
                            </select>
                            @error('sub_pekerjaan_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Nama Pekerjaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="form-input" placeholder="Nama Pekerjaan">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="deskripsi" name="deskripsi" class="form-input" rows="5" placeholder="Deskripsi">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nilai_pagu">Nilai Pagu <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nilai_pagu" name="nilai_pagu" value="{{ old('nilai_pagu') }}" class="form-input currency-input" placeholder="Nilai Pagu">
                            @error('nilai_pagu')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nilai_kontrak">Nilai Kontrak <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nilai_kontrak" name="nilai_kontrak" value="{{ old('nilai_kontrak') }}" class="form-input currency-input" placeholder="Nilai Kontrak">
                            @error('nilai_kontrak')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="kecamatan_id">Kecamatan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="kecamatan_id" name="kecamatan_id" class="form-select">
                                <option>Pilih Kecamatan</option>
                                @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}" @selected(old('kecamatan_id') == $kecamatan->id)>
                                    {{ $kecamatan->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('kecamatan_id')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="lokasi">Lokasi <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="lokasi" name="lokasi" class="form-input" rows="5" placeholder="Lokasi">{{ old('lokasi') }}</textarea>
                            @error('lokasi')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="sumber_dana">Sumber Dana <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="sumber_dana" name="sumber_dana" value="{{ old('sumber_dana') }}" class="form-input" placeholder="Sumber Dana">
                            @error('sumber_dana')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="thn_anggaran">Tahun Anggaran <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="number" id="thn_anggaran" name="thn_anggaran" value="{{ old('thn_anggaran') }}" class="form-input" placeholder="Tahun Anggaran" min="1901" max="{{ now()->format('Y') }}" step="1">
                            @error('thn_anggaran')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="metode_id">Metode Pengadaan <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="metode_id" name="metode_id" class="form-select">
                                <option>Pilih Metode Pengadaan</option>
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
                            <input type="text" id="jenis_kontruksi" name="jenis_kontruksi" value="{{ old('jenis_kontruksi') }}" class="form-input" placeholder="Jenis Kontruksi">
                            @error('jenis_kontruksi')
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
                            $('#jenis_pekerjaan_id').append('<option value="">Pilih Jenis Pekerjaan</option>');
                            $.each(data, function(key, value) {
                                $('#jenis_pekerjaan_id').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
                            });
                        }
                    });
                } else {
                    $('#jenis_pekerjaan_id').empty();
                    $('#sub_pekerjaan_id').empty();
                    $('#jenis_pekerjaan_id').append('<option value="">Pilih Jenis Pekerjaan</option>');
                    $('#sub_pekerjaan_id').append('<option value="">Pilih Sub Pekerjaan</option>');
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
                            $('#sub_pekerjaan_id').append('<option value="">Pilih Sub Pekerjaan</option>');
                            $.each(data, function(key, value) {
                                $('#sub_pekerjaan_id').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_pekerjaan_id').empty();
                    $('#sub_pekerjaan_id').append('<option value="">Pilih Sub Pekerjaan</option>');
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
@endsection