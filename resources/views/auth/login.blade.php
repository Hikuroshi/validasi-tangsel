<x-guest-layout>
    <div class="card">
        <div class="grid lg:grid-cols-2 gap-5">
            <div class="py-8 lg:px-8 sm:px-20 p-5 text-start">
                <div class="mx-auto mb-3">
                    <a href="#">
                        <img src="/assets/images/logo-tangsel.png" alt="" class="h-20 block dark:hidden">
                        <img src="/assets/images/logo-tangsel.png" alt="" class="h-20 hidden dark:block">
                    </a>
                    <h4 class="text-base mt-5 dark:text-gray-300">DASI-PPK</h4>
                    <p class="text-gray-500 mt-1 dark:text-gray-400">Data Informasi Penyelenggaraan Pekerjaan Kontruksi</p>
                    <p class="text-gray-500 mt-1 mb-10 dark:text-gray-400">Dinas Sumber Daya Air, Bina Marga Dan Bina Kontruksi</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="mb-3 flex flex-col">
                        <label class="font-semibold text-start dark:text-gray-300">Username</label>
                        <div class="flex items-center border rounded mt-2 dark:border-gray-600">
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-600">
                                <span class="">
                                    <i data-lucide="fingerprint"></i></span>
                                </span>
                            </div>
                            <input class="form-input border-none dark:bg-transparent" type="text" id="username" name="username" value="{{ old('username') }}" required autofocus autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-3 flex flex-col">
                        <label class="font-semibold text-start dark:text-gray-300">Password</label>
                        <div class="flex items-center border rounded mt-2 dark:border-gray-600">
                            <div class="px-3 py-2 bg-gray-100 dark:bg-gray-600">
                                <span class="">
                                    <i data-lucide="lock"></i></span>
                                </span>
                            </div>
                            <input class="form-input border-none dark:bg-transparent" type="password" id="password" name="password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-checkbox rounded" checked="">
                        <label class="form-check-label font-semibold" for="remember">Remember me</label>
                    </div>

                    <div class="text-center">
                        <button class="btn bg-primary text-white w-full" type="submit">Log In</button>
                    </div>
                </form>

            </div>

            <div class="hidden lg:block">
                <div class="px-20 relative h-full bg-no-repeat  bg-cover bg-[url('/assets/images/login.jpg')]" style="background: url('/assets/images/login.jpg')">
                    {{-- <div class="absolute inset-0 bg-dark/50"></div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- end card -->
</x-guest-layout>