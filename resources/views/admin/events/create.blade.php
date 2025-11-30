{{-- resources/views/admin/events/create.blade.php --}}
@extends('layouts.admin')

@section('header', 'Buat Acara')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-[#262363] transition-colors">
                    Dashboard
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-gray-500 hover:text-[#262363] transition-colors">
                    Acara
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                <span class="text-sm font-medium text-[#262363]">Buat Acara Baru</span>
            </li>
        </ol>
    </nav>

    <!-- Form Container -->
    <div class="max-w-full">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-[#262363] to-[#00183c]">
                <h2 class="text-2xl font-bold text-white">Buat Acara Baru</h2>
                <p class="text-blue-200 mt-2">Tambahkan acara baru ke sistem</p>
            </div>

            <!-- Form Content -->
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf

                <!-- Basic Information -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-3">Informasi Dasar</h3>
                    
                    <!-- Event Name -->
                    <div class="space-y-3">
                        <label class="block text-lg font-semibold text-gray-700">
                            Nama Acara
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="e.g., Summer Music Festival 2024"
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                            required
                        >
                        @if($errors->first('name'))
                            <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>

                    <!-- Category & Organizer -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Category -->
                        <div class="space-y-3">
                            <label class="block text-lg font-semibold text-gray-700">
                                Kategori
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" required
                                    class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none bg-white">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->first('category_id'))
                                <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                    <i class="fas fa-exclamation-circle mr-3"></i>
                                    {{ $errors->first('category_id') }}
                                </p>
                            @endif
                        </div>

                        <!-- Organizer -->
                        <div class="space-y-3">
                            <label class="block text-lg font-semibold text-gray-700">
                                Organizer
                            </label>
                            <select name="organizer_id"
                                    class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none bg-white">
                                <option value="">Pilih Organizer (Opsional)</option>
                                @foreach($organizers as $organizer)
                                    <option value="{{ $organizer->id }}" {{ old('organizer_id') == $organizer->id ? 'selected' : '' }}>
                                        {{ $organizer->name }} ({{ $organizer->email }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-gray-600 text-sm mt-2">Kosongkan untuk ditugaskan ke diri sendiri (Admin)</p>
                        </div>
                    </div>
                </div>

                <!-- Event Details -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-3">Detail Acara</h3>
                    
                    <!-- Description -->
                    <div class="space-y-3">
                        <label class="block text-lg font-semibold text-gray-700">
                            Deskripsi
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="description"
                            rows="6"
                            placeholder="Describe your event in detail..."
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none resize-vertical"
                            required
                        >{{ old('description') }}</textarea>
                        @if($errors->first('description'))
                            <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                {{ $errors->first('description') }}
                            </p>
                        @endif
                    </div>

                    <!-- Date & Location -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Event Date -->
                        <div class="space-y-3">
                            <label class="block text-lg font-semibold text-gray-700">
                                Tanggal & Waktu Acara
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="datetime-local"
                                name="event_date"
                                value="{{ old('event_date') }}"
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                                required
                            >
                            @if($errors->first('event_date'))
                                <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                    <i class="fas fa-exclamation-circle mr-3"></i>
                                    {{ $errors->first('event_date') }}
                                </p>
                            @endif
                        </div>

                        <!-- Location -->
                        <div class="space-y-3">
                            <label class="block text-lg font-semibold text-gray-700">
                                Lokasi
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text"
                                name="location"
                                value="{{ old('location') }}"
                                placeholder="e.g., Central Park, New York"
                                class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                                required
                            >
                            @if($errors->first('location'))
                                <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                    <i class="fas fa-exclamation-circle mr-3"></i>
                                    {{ $errors->first('location') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Media & Status -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-3">Media & Status</h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Image Upload -->
                        <div class="space-y-3">
                            <label class="block text-lg font-semibold text-gray-700">
                                Gambar Acara
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-[#262363] transition-colors duration-300">
                                <input 
                                    type="file"
                                    name="image"
                                    id="imageInput"
                                    accept="image/*"
                                    class="hidden"
                                >
                                <div id="imagePreview" class="mb-6">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-lg text-gray-600">Klik untuk upload gambar acara</p>
                                    <p class="text-sm text-gray-500 mt-2">JPG, PNG, GIF (Maks: 2MB)</p>
                                </div>
                                <button type="button" onclick="document.getElementById('imageInput').click()" 
                                        class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold text-lg">
                                    <i class="fas fa-upload mr-3"></i>
                                    Pilih Gambar
                                </button>
                            </div>
                            @if($errors->first('image'))
                                <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                    <i class="fas fa-exclamation-circle mr-3"></i>
                                    {{ $errors->first('image') }}
                                </p>
                            @endif
                        </div>

                        <!-- Status -->
                        <div class="space-y-3">
                            <label class="block text-lg font-semibold text-gray-700">
                                Status
                            </label>
                            <select name="status"
                                    class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none bg-white">
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <div class="space-y-3 mt-4 text-lg">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-info-circle mr-3 text-[#262363]"></i>
                                    <span><strong>Draft:</strong> Tidak terlihat publik</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-eye mr-3 text-green-500"></i>
                                    <span><strong>Published:</strong> Terlihat publik</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-ban mr-3 text-red-500"></i>
                                    <span><strong>Cancelled:</strong> Acara dibatalkan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-6 pt-8 border-t border-gray-200">
                    <a href="{{ route('admin.events.index') }}"
                       class="inline-flex items-center px-8 py-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold text-lg">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center px-8 py-4 bg-[#e692b7] text-white rounded-xl hover:bg-[#d87ba8] transition-all duration-300 font-semibold text-lg shadow-xl hover:shadow-2xl">
                        <i class="fas fa-plus mr-3"></i>
                        Buat Acara
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-[#262363] rounded-2xl p-8 border 0">
            <h3 class="text-xl font-bold text-gray-100 mb-4 flex items-center">
                <i class="fas fa-lightbulb mr-3"></i>
                Tips Pembuatan Acara
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-lg text-gray-100">
                <div class="space-y-3">
                    <p><strong>Langkah Pertama:</strong></p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Gunakan nama acara yang jelas dan deskriptif</li>
                        <li>Berikan deskripsi yang detail</li>
                        <li>Atur tanggal acara yang realistis</li>
                        <li>Pilih kategori yang sesuai</li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <p><strong>Langkah Selanjutnya:</strong></p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Tambah tiket setelah membuat acara</li>
                        <li>Atur jenis dan harga tiket yang berbeda</li>
                        <li>Kelola kuota tiket</li>
                        <li>Promosikan acara Anda</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image Preview
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="w-full h-48 object-cover rounded-xl mb-4">
                        <p class="text-lg text-green-600">Gambar dipilih: ${file.name}</p>
                    `;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Set minimum datetime to current time
    const dateInput = document.querySelector('input[name="event_date"]');
    if (dateInput && !dateInput.value) {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        dateInput.value = now.toISOString().slice(0, 16);
    }
});
</script>
@endsection