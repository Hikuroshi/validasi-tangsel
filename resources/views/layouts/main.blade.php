<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>DATIN-PPK | {{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc., Tailwind, TailwindCSS, Tailwind CSS 3" name="description">
    <meta content="coderthemes" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/logo-tangsel.png">

    @yield('css')

    <!-- App css -->
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/libs/%40iconscout/unicons/css/line.css" type="text/css" rel="stylesheet">

    <!-- Theme Config Js -->
    <script src="/assets/js/config.js"></script>
</head>

<body>

    <div class="flex wrapper">

        <!-- Sidenav Menu -->
        <div class="app-menu">

            <!-- App Logo -->
            <a href="#" class="logo-box">
                <!-- Light Logo -->
                <div class="logo-light">
                    <img src="/assets/images/logo-tangsel.png" class="logo-lg h-10" alt="Light logo">
                    <img src="/assets/images/logo-tangsel.png" class="logo-sm h-10" alt="Small logo">
                </div>

                <!-- Dark Logo -->
                <div class="logo-dark">
                    <img src="/assets/images/logo-tangsel.png" class="logo-lg h-10" alt="Dark logo">
                    <img src="/assets/images/logo-tangsel.png" class="logo-sm h-10" alt="Small logo">
                </div>
            </a>

            <!--- Menu -->
            <div class="scrollbar" data-simplebar>
                <ul class="menu" data-hs-collapse="accordion">

                    <li class="menu-item">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <span class="menu-icon">
                                <i data-lucide="home"></i>
                            </span>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                    </li>

                    <li class="menu-title">Menu</li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-hs-collapse="#menuMaster" class="menu-link">
                            <span class="menu-icon">
                                <i data-lucide="align-start-vertical"></i>
                            </span>
                            <span class="menu-text"> Master Data </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul id="menuMaster" class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="{{ route('perusahaan.index') }}" class="menu-link">
                                    <span class="menu-text"> Perusahaan </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('tenaga-ahli.index') }}" class="menu-link">
                                    <span class="menu-text"> Tenaga Ahli </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('jenis-pekerjaan.index') }}" class="menu-link">
                                    <span class="menu-text"> Jenis Pekerjaan </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('status-pekerjaan.index') }}" class="menu-link">
                                    <span class="menu-text"> Status Pekerjaan </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('metode.index') }}" class="menu-link">
                                    <span class="menu-text"> Metode </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('dinasan.index') }}" class="menu-link">
                                    <span class="menu-text"> Dinas </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('bidang.index') }}" class="menu-link">
                                    <span class="menu-text"> Bidang </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('user.index') }}" class="menu-link">
                                    <span class="menu-text"> User </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0)" data-hs-collapse="#menuPekerjaan" class="menu-link">
                            <span class="menu-icon">
                                <i data-lucide="briefcase"></i>
                            </span>
                            <span class="menu-text"> Pekerjaan </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul id="menuPekerjaan" class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="{{ route('pekerjaan.create') }}" class="menu-link">
                                    <span class="menu-text"> Input Pekerjaan </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('pekerjaan.index') }}" class="menu-link">
                                    <span class="menu-text"> List Pekerjaan </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0)" data-hs-collapse="#menuProses" class="menu-link">
                            <span class="menu-icon">
                                <i data-lucide="construction"></i>
                            </span>
                            <span class="menu-text"> Proses Pekerjaan </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul id="menuProses" class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="{{ route('proses.perusahaan') }}" class="menu-link">
                                    <span class="menu-text"> Perusahaan </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('proses.tenagaAhli') }}" class="menu-link">
                                    <span class="menu-text"> Tenaga Ahli </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('laporan.index') }}" class="menu-link">
                            <span class="menu-icon">
                                <i data-lucide="file-text"></i>
                            </span>
                            <span class="menu-text"> Laporan </span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <!-- Sidenav Menu End  -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">

            <!-- Topbar Start -->
            <header class="app-header flex items-center px-4 gap-4">

                <!-- App Logo -->
                <a href="#" class="logo-box">
                    <!-- Light Logo -->
                    <div class="logo-light">
                        <img src="/assets/images/logo-tangsel.png" class="logo-lg h-10" alt="Light logo">
                        <img src="/assets/images/logo-tangsel.png" class="logo-sm h-10" alt="Small logo">
                    </div>

                    <!-- Dark Logo -->
                    <div class="logo-dark">
                        <img src="/assets/images/logo-tangsel.png" class="logo-lg h-10" alt="Dark logo">
                        <img src="/assets/images/logo-tangsel.png" class="logo-sm h-10" alt="Small logo">
                    </div>
                </a>

                <!-- Sidenav Menu Toggle Button -->
                <button id="button-toggle-menu" class="nav-link p-2">
                    <span class="sr-only">Menu Toggle Button</span>
                    <span class="flex items-center justify-center">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </span>
                </button>

                <div class="me-auto"></div>

                <!-- Fullscreen Toggle Button -->
                <div class="md:flex hidden">
                    <button data-toggle="fullscreen" type="button" class="nav-link p-2">
                        <span class="sr-only">Fullscreen Mode</span>
                        <span class="flex items-center justify-center">
                            <i data-lucide="maximize" class="w-5 h-5"></i>
                        </span>
                    </button>
                </div>

                <!-- Light/Dark Toggle Button -->
                <div class="lg:flex hidden">
                    <button id="light-dark-mode" type="button" class="nav-link p-2">
                        <span class="sr-only">Light/Dark Mode</span>
                        <span class="flex items-center justify-center">
                            <i class="uil uil-moon text-2xl block dark:hidden"></i>
                            <i class="uil uil-sun text-2xl hidden dark:block"></i>
                        </span>
                    </button>
                </div>

                <!-- Profile Dropdown Button -->
                <div class="relative">
                    <div class="hs-dropdown relative">
                        <button type="button" class="hs-dropdown-toggle nav-link flex items-center gap-2">
                            <img src="/assets/images/avatar-user.png" alt="user-image" class="rounded-full h-8">
                            <span class="md:flex gap-0.5 text-start hidden">
                                <h5 class="text-sm">{{ request()->user()->name }}</h5>
                                <i class="uil uil-angle-down"></i>
                            </span>
                        </button>

                        <div class="hs-dropdown-menu transition-[opacity,margin] !mt-4 py-2 duration hs-dropdown-open:opacity-100 opacity-0 bg-white shadow rounded dark:bg-gray-800 dark:border dark:border-gray-700 hidden">
                            <!-- item-->
                            <h6 class="flex items-center py-2 px-3  text-gray-800 dark:text-gray-400">Halo {{ auth()->user()->name }}</h6>

                            <!-- item-->
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 py-1.5 px-4 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                <i data-lucide="user-2" class="w-4 h-4 fill-secondary/20"></i>
                                <span>My Account</span>
                            </a>

                            <hr class="dark:border-gray-600 my-1">
                            <!-- item-->
                            <form action="{{ route('logout') }}" method="post" id="form1">
                                @csrf

                                <a href="javascript:;" onclick="document.getElementById('form1').submit();" class="flex items-center gap-2 py-1.5 px-4 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 cursor-pointer">
                                    <i data-lucide="log-out" class="w-4 h-4 fill-secondary/20"></i>
                                    <span>Logout</span>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Topbar End -->

            <main class="p-6">

                <!-- Page Title Start -->
                {{-- <div class="flex justify-between items-center mb-5">
                    <h4 class="text-gray-900 dark:text-gray-200 text-lg font-medium">{{ $title }}</h4>
                </div> --}}
                <!-- Page Title End -->

                @yield('container')

            </main>

            <!-- Footer Start -->
            <footer class="footer h-16 flex items-center px-6 border-t border-gray-200 dark:border-gray-600 mt-auto">
                <div class="flex md:justify-center justify-center w-full gap-4">
                    <div>
                        <script>document.write(new Date().getFullYear())</script> © DATIN-PPK
                    </div>
                </div>
            </footer>
            <!-- Footer End -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    <!-- Plugin Js -->
    <script src="/assets/libs/jquery/jquery.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/lucide/umd/lucide.min.js"></script>
    <script src="/assets/libs/preline/preline.js"></script>

    <!-- App Js -->
    <script src="/assets/js/app.js"></script>

    @yield('js')
</body>
</html>