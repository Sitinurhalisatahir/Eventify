<form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')
    

    <div>
        <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
        <p class="mt-1 text-sm text-gray-600">Update your account's profile information and email address.</p>
    </div>

    <!-- Profile Image -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
        <div class="mt-2 flex items-center space-x-4">
            @if(auth()->user()->profile_image)
                <img src="{{ asset('storage/' . auth()->user()->profile_image)  }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="w-16 h-16 rounded-full object-cover">
            @else
                <div class="w-16 h-16 bg-gradient-to-r from-[#00A3FF] to-[#8A2BE2] rounded-full flex items-center justify-center text-white font-semibold text-xl">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            <input type="file" name="profile_image" accept="image/*" 
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
    </div>

      <!-- File upload -->
    <div class="col-span-full">
        <label for="profile_image" class="block text-sm font-medium leading-6 text-gray-900">Profile Image</label>
        <input type="file" name="profile_image" id="profile_image" class="...">
    </div>
    
    <!-- Name -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Email -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <!-- Phone -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Save Changes
        </button>

        @if (session('status') === 'profile-updated')
            <p class="text-sm text-green-600">Saved.</p>
        @endif
    </div>
</form>