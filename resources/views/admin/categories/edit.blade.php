{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('layouts.admin')

@section('header', 'Edit Kategori')

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
                <span class="text-sm font-medium text-[#262363]">Edit {{ $category->name }}</span>
            </li>
        </ol>
    </nav>

    <!-- Form Container - FULL WIDTH -->
    <div class="w-full">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-[#262363] to-[#00183c]">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Edit Kategori</h2>
                        <p class="text-blue-200 mt-2">Perbarui detail dan properti kategori</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div 
                            class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-xl"
                            style="background-color: {{ $category->color }}"
                        >
                            @if($category->icon)
                                <i class="{{ $category->icon }} text-2xl"></i>
                            @else
                                <i class="fas fa-tag text-2xl"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-8 space-y-8">
                @csrf
                @method('PUT')

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
                            value="{{ old('name', $category->name) }}"
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
                    </div>

                    <!-- Slug Input -->
                    <div class="space-y-3">
                        <label class="block text-lg font-semibold text-gray-800">
                            Slug
                        </label>
                        <input 
                            type="text"
                            name="slug"
                            value="{{ old('slug', $category->slug) }}"
                            placeholder="e.g., music-concert"
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                        >
                        @if($errors->first('slug'))
                            <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                {{ $errors->first('slug') }}
                            </p>
                        @endif
                        <p class="text-gray-600 text-sm mt-2">URL-friendly version</p>
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
                            value="{{ old('icon', $category->icon) }}"
                            placeholder="e.g., fas fa-music"
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                        >
                        @if($errors->first('icon'))
                            <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                {{ $errors->first('icon') }}
                            </p>
                        @endif
                        <p class="text-gray-600 text-sm mt-2">Font Awesome icon class</p>
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
                            value="{{ old('color', $category->color) }}"
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                            required
                        >
                        @if($errors->first('color'))
                            <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                {{ $errors->first('color') }}
                            </p>
                        @endif
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
                    >{{ old('description', $category->description) }}</textarea>
                    @if($errors->first('description'))
                        <p class="text-red-600 text-lg font-medium flex items-center mt-2">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>

                <!-- Category Stats -->
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 border border-gray-200 shadow-sm">
                    <h4 class="text-xl font-bold text-gray-800 mb-4">Statistik Kategori</h4>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                            <div class="text-3xl font-bold text-gray-900">{{ $category->events_count }}</div>
                            <div class="text-gray-600 font-medium">Total Acara</div>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                            <div class="text-xl font-bold text-gray-900">{{ $category->created_at->format('d M Y') }}</div>
                            <div class="text-gray-600 font-medium">Tanggal Dibuat</div>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                            <div class="text-xl font-bold text-gray-900">{{ $category->updated_at->format('d M Y') }}</div>
                            <div class="text-gray-600 font-medium">Terakhir Diupdate</div>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                            <div class="text-xl font-bold">
                                @if($category->events_count > 0)
                                    <span class="text-green-600">Aktif</span>
                                @else
                                    <span class="text-gray-500">Tidak Ada Acara</span>
                                @endif
                            </div>
                            <div class="text-gray-600 font-medium">Status</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                    <div>
                        @if($category->events_count === 0)
                            <form 
                                action="{{ route('admin.categories.destroy', $category) }}" 
                                method="POST" 
                                class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all duration-300 font-semibold text-lg">
                                    <i class="fas fa-trash mr-2"></i>
                                    Hapus Kategori
                                </button>
                            </form>
                        @else
                            <button disabled
                                    class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed font-semibold text-lg"
                                    title="Tidak dapat menghapus kategori yang memiliki acara">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Kategori
                            </button>
                        @endif
                    </div>

                    <div class="flex items-center space-x-6">
                        <a href="{{ route('admin.categories.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold text-lg">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#262363] to-[#00183c] text-white rounded-xl hover:from-[#1e1a4f] hover:to-[#001225] transition-all duration-300 font-semibold text-lg shadow-xl hover:shadow-2xl">
                            <i class="fas fa-save mr-2"></i>
                            Update Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection