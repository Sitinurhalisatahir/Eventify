{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
    <div class="min-h-screen flex flex-col lg:flex-row bg-white">
        <!-- Left Column - Brand Section (Kosong untuk background image) -->
        <div class="lg:w-1/2 bg-cover bg-center bg-no-repeat flex items-center justify-center p-8 lg:p-12">
            <img src="{{ asset('images/login.jpg') }}" 
                alt="Event Experience">
        </div>

        <!-- Right Column - Register Form -->
        <div class="lg:w-1/2 flex items-center justify-center p-8 lg:p-12">
            <div class="w-full max-w-md">
                <!-- Form Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
                    <p class="text-gray-600 mt-2">Daftar untuk mulai menjelajahi acara</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" class="text-gray-700 font-medium mb-2" />
                        <x-text-input 
                            id="name" 
                            class="block w-full border-gray-300 focus:border-[#e6527b] focus:ring-[#e6527b] rounded-lg py-3 px-4" 
                            type="text" 
                            name="name" 
                            :value="old('name')" 
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap Anda"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" value="Email" class="text-gray-700 font-medium mb-2" />
                        <x-text-input 
                            id="email" 
                            class="block w-full border-gray-300 focus:border-[#e6527b] focus:ring-[#e6527b] rounded-lg py-3 px-4" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autocomplete="email"
                            placeholder="Masukkan email Anda"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone (Optional) -->
                    <div>
                        <x-input-label for="phone" value="Nomor Telepon (Opsional)" class="text-gray-700 font-medium mb-2" />
                        <x-text-input 
                            id="phone" 
                            class="block w-full border-gray-300 focus:border-[#e6527b] focus:ring-[#e6527b] rounded-lg py-3 px-4" 
                            type="text" 
                            name="phone" 
                            :value="old('phone')" 
                            autocomplete="tel"
                            placeholder="Masukkan nomor telepon"
                        />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" value="Password" class="text-gray-700 font-medium mb-2" />
                        <x-text-input 
                            id="password" 
                            class="block w-full border-gray-300 focus:border-[#e6527b] focus:ring-[#e6527b] rounded-lg py-3 px-4"
                            type="password"
                            name="password"
                            required 
                            autocomplete="new-password"
                            placeholder="Buat password Anda"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-gray-700 font-medium mb-2" />
                        <x-text-input 
                            id="password_confirmation" 
                            class="block w-full border-gray-300 focus:border-[#e6527b] focus:ring-[#e6527b] rounded-lg py-3 px-4"
                            type="password"
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Ulangi password Anda"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Register Button -->
                    <button type="submit" class="w-full bg-[#e692b7] text-white py-3 px-4 rounded-lg font-semibold hover:bg-[#e692b7]' transition-colors focus:outline-none focus:ring-2 focus:ring-[#262363] focus:ring-offset-2 text-lg">
                        Daftar
                    </button>

                    <!-- Login Link -->
                    <div class="text-center pt-4">
                        <p class="text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-[#262363] hover:text-[#00183c] font-medium">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>