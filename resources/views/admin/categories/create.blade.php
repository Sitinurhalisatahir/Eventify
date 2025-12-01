@extends('layouts.admin')

@section('header', 'Buat Kategori')

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
                <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-gray-500 hover:text-[#262363] transition-colors">
                    Kategori
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                <span class="text-sm font-medium text-[#262363]">Buat Kategori Baru</span>
            </li>
        </ol>
    </nav>

    <!-- Form Container - FULL WIDTH -->
    <div class="w-full">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-[#262363] to-[#00183c]">
                <h2 class="text-2xl font-bold text-white">Buat Kategori Baru</h2>
                <p class="text-blue-200 mt-2">Tambahkan kategori acara baru dengan ikon dan warna</p>
            </div>

            <!-- Form Content -->
            <form action="{{ route('admin.categories.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <!-- Name & Slug Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Name Input -->
                    <div class="space-y-3">
                        <label class="block text-lg font-semibold text-gray-800">
                            Nama Kategori
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="e.g., Music Concert"
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                            required
                        >
                        @if($errors->first('name'))
                            <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                        <p class="text-gray-600 text-sm mt-2">Nama unik untuk kategori acara</p>
                    </div>

                    <!-- Slug Input -->
                    <div class="space-y-3">
                        <label class="block text-lg font-semibold text-gray-800">
                            Slug
                        </label>
                        <input 
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            placeholder="e.g., music-concert"
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                        >
                        @if($errors->first('slug'))
                            <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                {{ $errors->first('slug') }}
                            </p>
                        @endif
                        <p class="text-gray-600 text-sm mt-2">URL-friendly version (auto-generated if empty)</p>
                    </div>
                </div>

                <!-- Icon & Color Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Icon Input -->
                    <div class="space-y-3">
                        <label class="block text-lg font-semibold text-gray-800">
                            Icon Class
                        </label>
                        <input 
                            type="text"
                            name="icon"
                            value="{{ old('icon') }}"
                            placeholder="e.g., fas fa-music"
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                        >
                        @if($errors->first('icon'))
                            <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                {{ $errors->first('icon') }}
                            </p>
                        @endif
                        <p class="text-gray-600 text-sm mt-2">Font Awesome icon class (optional)</p>
                    </div>

                    <!-- Color Input -->
                    <div class="space-y-3">
                        <label class="block text-lg font-semibold text-gray-800">
                            Warna
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="color"
                            value="{{ old('color', '#3b82f6') }}"
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                            required
                        >
                        @if($errors->first('color'))
                            <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                {{ $errors->first('color') }}
                            </p>
                        @endif
                        <p class="text-gray-600 text-sm mt-2">Kode warna hex untuk tema kategori</p>
                    </div>
                </div>

                <!-- Description Textarea -->
                <div class="space-y-3">
                    <label class="block text-lg font-semibold text-gray-800">
                        Deskripsi
                    </label>
                    <textarea 
                        name="description"
                        rows="5"
                        placeholder="Describe this category..."
                        class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none resize-vertical"
                    >{{ old('description') }}</textarea>
                    @if($errors->first('description'))
                        <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                    <p class="text-gray-600 text-sm mt-2">Deskripsi opsional untuk kategori</p>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-6 pt-8 border-t border-gray-200">
                    <a href="{{ route('admin.categories.index') }}"
                       class="inline-flex items-center px-8 py-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold text-lg">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#262363] to-[#00183c] text-white rounded-xl hover:from-[#1e1a4f] hover:to-[#001225] transition-all duration-300 font-semibold text-lg shadow-xl hover:shadow-2xl">
                        <i class="fas fa-plus mr-3"></i>
                        Buat Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('blur', function() {
            if (!slugInput.value) {
                const slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                slugInput.value = slug;
            }
        });
    }
});
</script>
@endsection