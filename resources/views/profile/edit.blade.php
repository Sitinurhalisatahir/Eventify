<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    @include('components.layout.navbar')
    
    <div class="min-h-screen pt-20">
        <div class="max-w-4xl mx-auto py-8 px-4">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Profil</h1>
                <p class="text-gray-600 mb-8">Perbarui informasi akun Anda</p>
                
                <!-- Profile Update Form -->
                <div class="space-y-8">
                    <!-- Informasi Dasar -->
                    <div class="border-b border-gray-200 pb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Dasar</h2>
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363]">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363]">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Telepon -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363]">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Foto Profil -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                                    <div class="flex items-center space-x-6">
                                        <div class="flex-shrink-0">
                                            @if(auth()->user()->profile_image)
                                                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                                                     alt="{{ auth()->user()->name }}" 
                                                     class="w-20 h-20 rounded-full object-cover border-2 border-gray-300"
                                                     id="preview-image">
                                            @else
                                                <div class="w-20 h-20 bg-gradient-to-r from-[#262363] to-[#00183c] rounded-full flex items-center justify-center text-white font-semibold text-2xl"
                                                     id="preview-placeholder">
                                                    {{ substr(auth()->user()->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" 
                                                   name="profile_image" 
                                                   id="profile_image"
                                                   accept="image/*" 
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#262363] file:text-white hover:file:bg-[#1e1a4f]"
                                                   onchange="previewProfileImage(event)">
                                            <p class="text-sm text-gray-500 mt-1">JPG, PNG maksimal 2MB</p>
                                            @error('profile_image')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end mt-6">
                                <button type="submit" 
                                        class="bg-[#262363] text-white px-8 py-3 rounded-xl hover:bg-[#1e1a4f] font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Update Password -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Ubah Password</h2>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Password Saat Ini -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                    <input type="password" name="current_password" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363]">
                                    @error('current_password', 'updatePassword')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Password Baru -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                    <input type="password" name="password" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363]">
                                    @error('password', 'updatePassword')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Konfirmasi Password -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363]">
                                </div>
                            </div>
                            
                            <div class="flex justify-end mt-6">
                                <button type="submit" 
                                        class="bg-gray-800 text-white px-8 py-3 rounded-xl hover:bg-gray-900 font-semibold transition-all duration-300">
                                    <i class="fas fa-key mr-2"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function previewProfileImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('preview-image');
                const placeholder = document.getElementById('preview-placeholder');
                
                if (previewImg) {
                    previewImg.src = e.target.result;
                } else if (placeholder) {
                    placeholder.outerHTML = '<img src="' + e.target.result + '" alt="Preview" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300" id="preview-image">';
                }
            }
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>
</html>