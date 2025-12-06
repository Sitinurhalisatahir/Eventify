<form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('put')

    <div>
        <h3 class="text-lg font-medium text-gray-900">Perbarui Password</h3>
        <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.</p>
    </div>

    <!-- Password Saat Ini -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
        <input type="password" name="current_password" 
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#262363] focus:ring-[#262363]">
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
    </div>

    <!-- Password Baru -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Password Baru</label>
        <input type="password" name="password" 
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#262363] focus:ring-[#262363]">
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
    </div>

    <!-- Konfirmasi Password -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" 
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#262363] focus:ring-[#262363]">
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="bg-[#262363] text-white px-4 py-2 rounded-md hover:bg-[#1e1a4f] transition-colors">
            Perbarui Password
        </button>

        @if (session('status') === 'password-updated')
            <p class="text-sm text-green-600">Password berhasil diperbarui.</p>
        @endif
    </div>
</form>