<x-guest-layout>
    <div class="card">
        <div class="grid lg:grid-cols-2 gap-5">
            <div class="py-8 lg:px-8 sm:px-20 p-5 text-start">
                <div class="mx-auto mb-3">
                    <a href="index.html">
                        <img src="assets/images/logo-dark.png" alt="" class="h-6 block dark:hidden">
                        <img src="assets/images/logo-light.png" alt="" class="h-6 hidden dark:block">
                    </a>
                    <h4 class="text-base mt-5 dark:text-gray-300">Welcome back!</h4>
                    <p class="text-gray-500 mt-1 mb-10 dark:text-gray-400">Enter your email address and password to access admin panel.</p>
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
                <div class="px-20 relative h-full bg-no-repeat  bg-cover bg-[url('../images/auth-bg.jpg')]">
                    <div class="absolute inset-0 bg-dark/50"></div>
                    <div class="pt-96 text-center relative">
                        <p class="text-xl font-semibold text-white mb-1">I simply love it!</p>
                        <p class="text-white text-base">"It's a elegent templete. I love it very much!"</p>
                        <p class="text-white text-base mt-3">- Admin User</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end card -->

    <div class="row mt-3">
        <div class="col-12 text-center">
            <p class="text-gray-500">Don't have an account? <a href="{{ route('register') }}" class="text-primary font-semibold ms-1">Sign Up</a></p>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
</x-guest-layout>