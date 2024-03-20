@extends('layouts.main')

@section('container')

<div class="card mb-6">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data badan usaha dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid gap-6">
            <div>
                <form method="POST" action="{{ route('perusahaan.update', $perusahaan->slug) }}">
                    @method('put')
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="npwp">NPWP <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="npwp" name="npwp" value="{{ old('npwp', $perusahaan->npwp) }}" class="form-input">
                            @error('npwp')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Nama <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $perusahaan->nama) }}" class="form-input">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="direktur">Direktur <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="direktur" name="direktur" value="{{ old('direktur', $perusahaan->direktur) }}" class="form-input">
                            @error('direktur')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="alamat">Alamat <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="alamat" name="alamat" class="form-input" rows="5">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                            @error('alamat')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="email">Email </label>
                        <div class=" w-full sm:w-5/6">
                            <input type="email" id="email" name="email" value="{{ old('email', $perusahaan->email) }}" class="form-input">
                            @error('email')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="telepon">Telepon </label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $perusahaan->telepon) }}" class="form-input">
                            @error('telepon')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="status">Status <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <select id="status" name="status" class="form-select">
                                <option value="1" @selected(old('status', $perusahaan->status) == '1')>Aktif</option>
                                <option value="0" @selected(old('status', $perusahaan->status) == '0')>Tidak Aktif</option>
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

<script src="/assets/js/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {
        $("#npwp").on("input", function(e) {
            formatInput(e, "00.000.000.0-000.000");
            // formatInput(e, "0000 0000 0000 0000");
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

@endsection