{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <div class="min-h-screen flex flex-col lg:flex-row bg-white">
        <!-- Left Column - Brand Section -->
        <div class="lg:w-1/2 flex items-center justify-center p-10 lg:p-15">
           <img src="{{ asset('images/login.jpg') }}" 
                alt="Event Experience"
                class="w-full h-full object-cover">
        </div>

        <!-- Right Column - Login Form -->
        <div class="lg:w-1/2 flex items-center justify-center p-8 lg:p-12">
            <div class="w-full max-w-md">
                <!-- Form Header -->
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Selamat Datang</h2>
                    <p class="text-gray-600 text-lg">Masuk ke akun Eventify Anda</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" value="Email" class="text-gray-700 font-medium mb-2 text-lg" />
                        <x-text-input 
                            id="email" 
                            class="block w-full border-gray-300 focus:border-[#e6527b] focus:ring-[#e6527b] rounded-lg py-4 px-4 text-lg" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="email"
                            placeholder="js@gmail.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" value="Password" class="text-gray-700 font-medium mb-2 text-lg" />
                        <x-text-input 
                            id="password" 
                            class="block w-full border-gray-300 focus:border-[#e6527b] focus:ring-[#e6527b] rounded-lg py-4 px-4 text-lg"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="Masukkan password Anda"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#e6527b] focus:ring-[#e6527b] w-5 h-5" name="remember">
                            <span class="ms-2 text-lg text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-lg text-[#262363] hover:text-[#00183c] font-medium" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="w-full bg-[#262363] text-white py-4 px-4 rounded-lg font-semibold hover:bg-[#00183c] transition-colors focus:outline-none focus:ring-2 focus:ring-[#262363] focus:ring-offset-2 text-xl">
                        Masuk
                    </button>

                    <!-- Register Link -->
                    <div class="text-center pt-4">
                        <p class="text-gray-600 text-lg">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-[#262363] hover:text-[#00183c] font-medium">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>