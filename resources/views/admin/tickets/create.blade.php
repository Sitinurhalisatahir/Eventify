@extends('layouts.admin')

@section('header', 'Buat Tiket Baru')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb Manual -->
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
                <a href="{{ route('admin.events.show', $event) }}" class="text-sm font-medium text-gray-500 hover:text-[#262363] transition-colors">
                    {{ $event->name }}
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                <span class="text-sm font-medium text-[#262363]">Buat Tiket Baru</span>
            </li>
        </ol>
    </nav>

    <!-- Form Container - FULL WIDTH -->
    <div class="w-full">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-[#262363] text-white">
                <h2 class="text-xl font-semibold">Buat Tiket Baru</h2>
                <p class="text-gray-200 mt-1">Tambahkan tiket baru untuk {{ $event->name }}</p>
            </div>

            <!-- Form Content -->
            <form action="{{ route('admin.events.tickets.store', $event) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Informasi Tiket -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Tiket</h3>
                    
                    <!-- Nama Tiket -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            Nama Tiket
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="e.g., Early Bird, VIP, Regular"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                            required
                        >
                        @if($errors->first('name'))
                            <p class="text-red-600 text-sm font-medium flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            Deskripsi
                        </label>
                        <textarea 
                            name="description"
                            rows="3"
                            placeholder="Deskripsikan tipe tiket ini..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none resize-vertical"
                        >{{ old('description') }}</textarea>
                        @if($errors->first('description'))
                            <p class="text-red-600 text-sm font-medium flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $errors->first('description') }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Harga & Kuota -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Harga & Kuota</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Harga -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Harga
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                <input 
                                    type="number"
                                    name="price"
                                    value="{{ old('price') }}"
                                    placeholder="0"
                                    min="0"
                                    step="0.01"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                                    required
                                >
                            </div>
                            @if($errors->first('price'))
                                <p class="text-red-600 text-sm font-medium flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $errors->first('price') }}
                                </p>
                            @endif
                        </div>

                        <!-- Kuota -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Kuota
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number"
                                name="quota"
                                value="{{ old('quota') }}"
                                placeholder="100"
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                                required
                            >
                            @if($errors->first('quota'))
                                <p class="text-red-600 text-sm font-medium flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $errors->first('quota') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Upload Gambar -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Gambar Tiket (Opsional)</h3>
                    
                    <div class="space-y-2">
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#262363] transition-colors duration-300">
                            <input 
                                type="file"
                                name="image"
                                id="imageInput"
                                accept="image/*"
                                class="hidden"
                            >
                            <div id="imagePreview" class="mb-4">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">Klik untuk mengupload gambar tiket</p>
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (Maks: 2MB)</p>
                            </div>
                            <button type="button" onclick="document.getElementById('imageInput').click()" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold text-sm">
                                <i class="fas fa-upload mr-2"></i>
                                Pilih Gambar
                            </button>
                        </div>
                        @if($errors->first('image'))
                            <p class="text-red-600 text-sm font-medium flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $errors->first('image') }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.events.show', $event) }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-[#e692b7] text-white rounded-xl hover:bg-[#d87ba8] transition-all duration-300 font-semibold shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Tiket
                    </button>
                </div>
            </form>
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
                        <img src="${e.target.result}" alt="Preview" class="w-full h-32 object-cover rounded-lg mb-2">
                        <p class="text-sm text-green-600">Gambar dipilih: ${file.name}</p>
                    `;
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection