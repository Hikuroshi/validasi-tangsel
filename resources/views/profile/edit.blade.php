@extends('layouts.main')

@section('container')

<div class="card mb-10">
    <div class="p-6">
        <h4 class="uppercase dark:text-gray-300">Informasi Profil</h4>
        <p class="mb-5">Perbarui informasi data akun kamu seperti nama, username dan email.</p>

        <div class="grid xl:grid-cols-2 gap-6">
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label class="block mb-2 font-semibold" for="name">Nama</label>
                    <div>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-input w-full placeholder:text-gray-400">
                    </div>
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="block mb-2 font-semibold" for="username">Username</label>
                    <div>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" class="form-input w-full placeholder:text-gray-400">
                    </div>
                    @error('username')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block mb-2 font-semibold" for="email">Email</label>
                    <div>
                        <input type="text" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-input w-full placeholder:text-gray-400">
                    </div>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn bg-primary/90 text-white hover:bg-primary">Simpan</button>
            </form>
        </div>
    </div>
</div> <!-- end card -->

<div class="card mb-10">
    <div class="p-6">
        <h4 class="uppercase dark:text-gray-300">Perbarui Password</h4>
        <p class="mb-5">Pastikan akun mu aman dengan password yang panjang dan unik.</p>

        <div class="grid xl:grid-cols-2 gap-6">
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label class="block mb-2 font-semibold" for="current_password">Password saat ini</label>
                    <div>
                        <input type="password" id="current_password" name="current_password" class="form-input w-full placeholder:text-gray-400">
                    </div>
                    @error('current_password', 'updatePassword')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="block mb-2 font-semibold" for="password">Password baru</label>
                    <div>
                        <input type="password" id="password" name="password" class="form-input w-full placeholder:text-gray-400">
                    </div>
                    @error('password', 'updatePassword')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block mb-2 font-semibold" for="password_confirmation">Passowrd konfirmasi</label>
                    <div>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input w-full placeholder:text-gray-400">
                    </div>
                    @error('password_confirmation', 'updatePassword')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn bg-primary/90 text-white hover:bg-primary">Simpan</button>
            </form>
        </div>
    </div>
</div> <!-- end card -->

<div class="card mb-10">
    <div class="p-6">
        <h4 class="uppercase dark:text-gray-300">Hapus akun</h4>
        <p class="mb-5">Ketika akun telah dihapus, semua data akan otomatis terhapus secara permanen. Sebelum menghapus pastikan untuk mencadangkan semua data akun.</p>

        <div class="grid xl:grid-cols-2 gap-6">
            <div>
                <button type="button" data-hs-overlay="#deleteData" class="btn bg-danger text-white hover:bg-danger">
                    Hapus Akun
                </button>
                @error('password', 'userDeletion')
                <small class="text-danger ps-3">{{ $message }}</small>
                @enderror

                <div id="deleteData" class="hs-overlay hidden w-full h-full fixed top-1/3 left-0 z-[60] overflow-x-hidden overflow-y-auto">
                    <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                        <div class="flex flex-col bg-white border shadow-sm rounded dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                            <div class="flex justify-between items-center pt-3 px-4">
                                <h3 class="font-bold text-gray-800 dark:text-white">
                                    Apakah kamu yakin ingin menghapus akun?
                                </h3>
                                <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-hs-overlay="#deleteData">
                                    <span class="sr-only">Tutup</span>
                                    <i class="uil uil-times text-2xl"></i>
                                </button>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                <p class="dark:text-gray-400 mb-3">
                                    Ketika akun telah dihapus, semua data akan otomatis terhapus secara permanen. Sebelum menghapus pastikan untuk mencadangkan semua data akun.
                                </p>
                                <div class="text-center">
                                    <h3 class="text-gray-800 dark:text-white font-bold mb-3">
                                        Masukan Password untuk melanjutkan
                                    </h3>

                                    <form method="post" action="{{ route('profile.destroy') }}">
                                        @csrf
                                        @method('delete')

                                        <input type="password" id="password" name="password" class="form-input w-full placeholder:text-gray-400 mb-3">

                                        <button type="submit" class="btn bg-danger text-white hover:bg-danger">
                                            Hapus Akun
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

<!-- Sweet-alert js  -->
<script src="/assets/js/sweetalert2.all.min.js"></script>

@if(session()->has('success'))
<script>
    $(document).ready(function() {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    });
</script>
@endif

@endsection