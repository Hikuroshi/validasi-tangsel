<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Validasi Tangsel</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/logo-tangsel.png">

    <!-- App css -->
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/libs/%40iconscout/unicons/css/line.css" type="text/css" rel="stylesheet">

    <!-- Theme Config Js -->
    <script src="/assets/js/config.js"></script>
</head>

<body class="relative flex flex-col">

    <div class="container">
        <div class="flex items-center justify-center pt-20 sm:px-0 px-5">
            <div class="xl:max-w-6xl">
                {{ $slot }}
            </div> <!-- end col -->
        </div>
    </div>

    <!-- Plugin Js -->
    <script src="/assets/libs/jquery/jquery.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/lucide/umd/lucide.min.js"></script>
    <script src="/assets/libs/preline/preline.js"></script>

    <!-- App Js -->
    <script src="/assets/js/app.js"></script>

    <!-- Sweet-alert js  -->
    <script src="/assets/js/sweetalert2.all.min.js"></script>

    @error('username')
    <script>
        $(document).ready(function() {
            var Toast = Swal.mixin({
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
                icon: 'error',
                title: '{{ session('loginError') }}',
                text: 'Username atau Password salah'
            });
        });
    </script>
    @enderror

    <script>
        $(document).on('click', '#deleteData', function() {
            let title = $(this).data('title');

            Swal.fire({
                title: 'Hapus ' + title + '?',
                html: "Apakah kamu yakin ingin menghapus <b>" + title + "</b>? Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
</body>
</html>