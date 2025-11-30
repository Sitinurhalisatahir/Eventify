{{-- resources/views/organizer/events/create.blade.php --}}
@extends('layouts.organizer')

@section('header', 'Buat Acara Baru')

@section('content')
<div class="max-w-full mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-[#262363] to-[#00183c] px-6 py-4">
            <h2 class="text-xl font-bold text-white">Buat Acara Baru</h2>
            <p class="text-blue-100 text-sm">Isi detail di bawah untuk membuat acara Anda</p>
        </div>

        <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-6">
                    <!-- Nama Acara -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Acara <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}"
                               required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama acara">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" 
                                id="category_id"
                                required
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('category_id') border-red-500 @enderror">
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Acara -->
                    <div>
                        <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal & Waktu Acara <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               name="event_date" 
                               id="event_date"
                               value="{{ old('event_date') }}"
                               min="{{ now()->format('Y-m-d\TH:i') }}"
                               required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('event_date') border-red-500 @enderror">
                        @error('event_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="location" 
                               id="location"
                               value="{{ old('location') }}"
                               required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('location') border-red-500 @enderror"
                               placeholder="Masukkan lokasi acara">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select name="status" 
                                id="status"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none">
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Terbit</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Pilih "Terbit" untuk membuat acara Anda terlihat oleh pengguna</p>
                    </div>

                    <!-- Gambar Acara -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Acara
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF (Maks. 2MB)</p>
                                </div>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        <!-- Preview Gambar -->
                        <div id="image-preview" class="mt-3 hidden">
                            <img id="preview" class="w-full h-48 object-cover rounded-lg border border-gray-200">
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="6"
                          required
                          class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('description') border-red-500 @enderror"
                          placeholder="Jelaskan acara Anda secara detail...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Aksi Form -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 mt-8">
                <a href="{{ route('organizer.events.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-[#e6527b] text-white rounded-lg hover:bg-[#d9416d] font-medium transition-colors shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus mr-2"></i>Buat Acara
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Fungsi preview gambar
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('image-preview');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        
        reader.readAsDataURL(this.files[0]);
    } else {
        previewContainer.classList.add('hidden');
    }
});
</script>
@endsection