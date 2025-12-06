@extends('layouts.admin')

@section('header', 'Manajemen Kategori')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Create Button -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kategori</h1>
            <p class="text-gray-600 mt-2">Kelola kategori acara dan propertinya</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#262363] to-[#00183c] text-white rounded-xl hover:from-[#1e1a4f] hover:to-[#001225] transition-all duration-300 font-semibold text-base shadow-lg hover:shadow-xl">
            <i class="fas fa-plus mr-2"></i>
            Tambah Kategori Baru
        </a>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-xl font-semibold text-gray-800">Semua Kategori</h2>
        </div>

        @if($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Ikon & Warna
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Acara
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <!-- Name & Slug -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-lg font-semibold text-gray-900">
                                                {{ $category->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 font-mono">
                                                {{ $category->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Icon & Color -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-4">
                                        @if($category->icon)
                                            <div 
                                                class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg"
                                                style="background-color: {{ $category->color }}"
                                            >
                                                <i class="{{ $category->icon }} text-lg"></i>
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <div 
                                                class="w-8 h-8 rounded border-2 shadow-sm"
                                                style="border-color: {{ $category->color }}; background-color: {{ $category->color }}20"
                                            ></div>
                                            <span class="text-xs text-gray-600 font-mono mt-1">
                                                {{ $category->color }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Events Count -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold 
                                        {{ $category->events_count > 0 ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-800 border border-gray-200' }}">
                                        {{ $category->events_count }} acara
                                    </span>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-md">
                                        {{ $category->description ?? 'Tidak ada deskripsi' }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-[#262363] text-white rounded-xl hover:bg-[#00183c] transition-all duration-300 font-semibold">
                                            <i class="fas fa-edit mr-2"></i>
                                            Edit
                                        </a>

                                        @if($category->events_count === 0)
                                            <form 
                                                action="{{ route('admin.categories.destroy', $category) }}" 
                                                method="POST" 
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this category?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all duration-300 font-semibold">
                                                    <i class="fas fa-trash mr-2"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <button disabled
                                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed font-semibold"
                                                title="Tidak dapat menghapus kategori yang memiliki acara">
                                                <i class="fas fa-trash mr-2"></i>
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $categories->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <i class="fas fa-layer-group text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-3">Belum ada kategori</h3>
                <p class="text-gray-500 text-lg mb-8 max-w-md mx-auto">Mulai dengan membuat kategori pertama untuk mengorganisir acara Anda</p>
                <a href="{{ route('admin.categories.create') }}"
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#262363] to-[#00183c] text-white rounded-xl hover:from-[#1e1a4f] hover:to-[#001225] transition-all duration-300 font-semibold text-lg shadow-xl hover:shadow-2xl">
                    <i class="fas fa-plus mr-3"></i>
                    Buat Kategori Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection