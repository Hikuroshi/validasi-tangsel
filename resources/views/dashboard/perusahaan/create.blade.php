@extends('layouts.main')

@section('container')

@if(session()->has('failedSave'))
    <div id="dismiss-secondary" class="bg-danger/10 text-danger border border-danger/20 text-sm rounded py-3 px-5 flex justify-between items-center mb-6">
        <p>
            <span class="font-bold">{{ session('failedSave') }}</span>
        </p>
        <button class="text-xl/[0]" data-hs-remove-element="#dismiss-secondary" type="button">
            <i class="uil uil-multiply text-xl"></i>
        </button>
    </div>
@endif

<div class="card">
    <div class="p-6">
        <h4 class="uppercase mb-2 dark:text-gray-300">{{ $title }}</h4>
        <p class="text-gray-500 mb-6 dark:text-gray-400">
            Inputkan data badan usaha dengan benar, kolom yang bertanda <span class="text-danger">*</span> harus di isi.
        </p>

        <div class="grid gap-6">
            <div>
                <form method="POST" action="{{ route('perusahaan.store') }}">
                    @csrf

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="npwp">NPWP <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="npwp" name="npwp" value="{{ old('npwp') }}" class="form-input">
                            @error('npwp')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="nama">Nama <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="form-input">
                            @error('nama')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="direktur">Direktur <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="direktur" name="direktur" value="{{ old('direktur') }}" class="form-input">
                            @error('direktur')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-start justify-between">
                        <label class="mb-2" for="alamat">Alamat <span class="text-danger">*</span></label>
                        <div class=" w-full sm:w-5/6">
                            <textarea id="alamat" name="alamat" class="form-input" rows="5">{{ old('alamat') }}</textarea>
                            @error('alamat')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="email">Email </label>
                        <div class=" w-full sm:w-5/6">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input">
                            @error('email')
                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap sm:flex-nowrap items-center justify-between">
                        <label class="mb-2" for="telepon">Telepon </label>
                        <div class=" w-full sm:w-5/6">
                            <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}" class="form-input">
                            @error('telepon')
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

<div class="card mt-6 mb-6">
    <div class="p-6">
        <h4 class="uppercase dark:text-gray-300 mb-3">Import Perusahaan</h4>
        <table class="mb-3">
            <tr>
                <td style="vertical-align: top">1.</td>
                <td>
                    Download Format Import: Klik tombol "Format" di bawah ini untuk mengunduh file contoh format yang harus Anda ikuti saat mengimpor data perusahaan.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top">2.</td>
                <td>
                    Persiapkan Data Perusahaan: Buka file contoh format yang telah diunduh dan isi informasi perusahaan sesuai dengan kolom-kolom yang telah disediakan. Pastikan untuk mengisi setiap kolom dengan data yang akurat dan sesuai.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top">3.</td>
                <td>
                    Simpan File yang Sudah Diisi: Setelah mengisi data perusahaan dalam format yang benar, simpan file tersebut dalam format Excel (.xlsx) agar siap untuk diimpor.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top">4.</td>
                <td>
                    Impor Data: Klik tombol "Import" di bawah ini untuk memulai proses impor data perusahaan. Pilih file yang sudah Anda isi dengan data perusahaan, lalu ikuti instruksi untuk menyelesaikan proses impor.
                </td>
            </tr>
        </table>

        <p class="mb-3">
            Fitur import perusahaan memungkinkan Anda untuk dengan mudah mengimpor data perusahaan secara massal ke dalam sistem. Hal ini sangat berguna untuk mempercepat proses pengisian data dan meminimalkan kesalahan input manual. Dengan mengikuti langkah-langkah di atas, Anda dapat mengimpor data perusahaan dengan cepat dan efisien. Pastikan untuk memeriksa kembali data yang diimpor untuk memastikan keakuratannya setelah proses impor selesai.
        </p>

        <div class="grid xl:grid-cols-2 gap-6">
            <div>
                <a href="/assets/perusahaan-import-format.xlsx" download="Contoh Format Import Pegawai" class="btn bg-info text-white hover:bg-info me-2">
                    <i class="uil uil-file-download me-1"></i>
					Format
                </a>
                <button type="button" data-hs-overlay="#perusahaanImport" class="btn bg-primary text-white hover:bg-primary">
                    <i class="uil uil-import me-1"></i>
					Import
                </button>

                <div id="perusahaanImport" class="hs-overlay hidden w-full h-full fixed top-1/3 left-0 z-[60] overflow-x-hidden overflow-y-auto">
                    <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                        <div class="flex flex-col bg-white border shadow-sm rounded dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                            <div class="flex justify-between items-center pt-3 px-4">
                                <h3 class="font-bold text-gray-800 dark:text-white">
                                    Import data perusahaan dari excel
                                </h3>
                                <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-hs-overlay="#perusahaanImport">
                                    <span class="sr-only">Tutup</span>
                                    <i class="uil uil-times text-2xl"></i>
                                </button>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                <div class="text-center">
                                    <form method="post" action="{{ route('perusahaan.import') }}" enctype="multipart/form-data">
                                        @csrf

                                        <input name="perusahaan_import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-input mb-3" type="file" id="perusahaan_import_file" required>

                                        <button type="submit" class="btn bg-primary text-white hover:bg-primary">
                                            Simpan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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