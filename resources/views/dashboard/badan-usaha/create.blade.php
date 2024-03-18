@extends('layouts.main')

@section('css')

<!-- Flatpickr css -->
<link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">

@endsection

@section('container')

<div class="card mb-6">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data badan usaha dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid gap-6">
            <div>
                <form method="POST" action="{{ route('badan-usaha.store') }}">
                    @csrf

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
                        <label class="mb-2" for="sertifikat">No Sertifikat <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="sertifikat" name="sertifikat" value="{{ old('sertifikat') }}" class="form-input" placeholder="Sertifikat">
                            @error('sertifikat')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="registrasi">No Registrasi <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="registrasi" name="registrasi" value="{{ old('registrasi') }}" class="form-input" placeholder="Registrasi">
                            @error('registrasi')
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
                        <label class="mb-2" for="direktur">Direktur <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="direktur" name="direktur" value="{{ old('direktur') }}" class="form-input" placeholder="Direktur">
                            @error('direktur')
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
                        <label class="mb-2" for="email">Email <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="Email">
                            @error('email')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="telepon">Telepon <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}" class="form-input" placeholder="Telepon">
                            @error('telepon')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="no_akta">No Akta <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="no_akta" name="no_akta" value="{{ old('no_akta') }}" class="form-input" placeholder="No Akta">
                            @error('no_akta')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="humanfd-datepicker">Tanggal Akta <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="humanfd-datepicker" name="tgl_akta" value="{{ old('tgl_akta') }}" class="form-input" placeholder="{{ now()->format('F j, Y') }}">
                            @error('tgl_akta')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="klasifikasi">Klasifikasi <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="klasifikasi" name="klasifikasi" class="form-input" rows="5" placeholder="Klasifikasi">{{ old('klasifikasi') }}</textarea>
                            @error('klasifikasi')
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

    $(document).ready(function() {
        $("#npwp").on("input", function(e) {
            // formatInput(e, "00.000.000.0-000.000");
            formatInput(e, "0000 0000 0000 0000");
        });

        $("#registrasi").on("input", function(e) {
            formatInput(e, "0-0000-00-000-0-0-000000");
        });

        $("#telepon").on("input", function(e) {
            formatTelepon(e, "0800 0000 00000");
        });
    });

    function formatInput(e, template) {
        let cursorPos = e.target.selectionStart;
        let currentValue = e.target.value;
        let cleanValue = currentValue.replace(/\D/g, "");
        let formatInput = patternMatch({
            input: cleanValue,
            template: template
        });

        $(e.target).val(formatInput);

        let isBackspace = (e?.data == null) ? true : false;
        let nextCusPos = nextDigit(formatInput, cursorPos, isBackspace);

        $(e.target).prop("selectionStart", nextCusPos);
        $(e.target).prop("selectionEnd", nextCusPos);
    }

    function formatTelepon(e, template) {
        let cursorPos = e.target.selectionStart;
        let currentValue = e.target.value;
        let cleanValue = currentValue.replace(/\D/g, "");

        if (cleanValue.length >= 2 && cleanValue.substring(0, 2) !== "08") {
            cleanValue = "08" + cleanValue;
        }

        let formatInput = patternMatch({
            input: cleanValue,
            template: template
        });

        $(e.target).val(formatInput);

        let isBackspace = (e?.data == null) ? true : false;
        let nextCusPos = nextDigit(formatInput, cursorPos, isBackspace);

        $(e.target).prop("selectionStart", nextCusPos);
        $(e.target).prop("selectionEnd", nextCusPos);
    }

    function patternMatch({ input, template }) {
        try {
            let j = 0;
            let plaintext = "";
            let countj = 0;
            while (j < template.length) {
                if (countj > input.length - 1) {
                    template = template.substring(0, j);
                    break;
                }

                if (template[j] == input[j]) {
                    j++;
                    countj++;
                    continue;
                }

                if (template[j] == "0") {
                    template =
                    template.substring(0, j) + input[countj] + template.substring(j + 1);
                    plaintext = plaintext + input[countj];
                    countj++;
                }
                j++;
            }

            return template;
        } catch {
            return "";
        }
    }
</script>

<!-- Init js -->
<script src="/assets/js/pages/form-advanced.init.js"></script>

@endsection