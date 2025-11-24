<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone (Optional) -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone (Optional)')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- ✅ TAMBAH: Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Register as')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">-- Select Role --</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Event Organizer</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- ✅ TAMBAH: Organizer Description (hanya muncul jika pilih organizer) -->
        <div class="mt-4" id="organizer-description-field" style="display: none;">
            <x-input-label for="organizer_description" :value="__('Tell us about your organization')" />
            <textarea id="organizer_description" name="organizer_description" rows="4" 
                      class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      placeholder="Describe your organization and event experience...">{{ old('organizer_description') }}</textarea>
            <x-input-error :messages="$errors->get('organizer_description')" class="mt-2" />
            <p class="text-sm text-gray-600 mt-1">* Your account will be reviewed by admin before you can create events.</p>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- ✅ TAMBAH: JavaScript untuk show/hide organizer description -->
    <script>
        document.getElementById('role').addEventListener('change', function() {
            const organizerField = document.getElementById('organizer-description-field');
            const organizerDescription = document.getElementById('organizer_description');
            
            if (this.value === 'organizer') {
                organizerField.style.display = 'block';
                organizerDescription.required = true;
            } else {
                organizerField.style.display = 'none';
                organizerDescription.required = false;
                organizerDescription.value = '';
            }
        });

        // Check on page load (untuk old value)
        window.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            if (roleSelect.value === 'organizer') {
                document.getElementById('organizer-description-field').style.display = 'block';
            }
        });
    </script>
</x-guest-layout>