{{-- resources/views/organizer/events/edit.blade.php --}}
@extends('layouts.organizer')

@section('header', 'Edit Acara')

@section('content')
<div class="max-w-full mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-[#262363] to-[#00183c] px-6 py-4">
            <h2 class="text-xl font-bold text-white">Edit Acara</h2>
            <p class="text-blue-100 text-sm">Perbarui detail acara Anda</p>
        </div>

        <form action="{{ route('organizer.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

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
                               value="{{ old('name', $event->name) }}"
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
                                <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
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
                               value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}"
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
                               value="{{ old('location', $event->location) }}"
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
                            <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Terbit</option>
                            <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Gambar Acara -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Acara
                        </label>
                        
                        <!-- Gambar Saat Ini -->
                        @if($event->image)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/' . $event->image) }}" 
                                     alt="{{ $event->name }}" 
                                     class="w-full h-48 object-cover rounded-lg border border-gray-200">
                            </div>
                        @endif

                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-semibold">Klik untuk upload</span> gambar baru
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF (Maks. 2MB)</p>
                                </div>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        <!-- Preview Gambar Baru -->
                        <div id="image-preview" class="mt-3 hidden">
                            <p class="text-sm text-gray-600 mb-2">Preview Gambar Baru:</p>
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
                          placeholder="Jelaskan acara Anda secara detail...">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Aksi Form -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-8">
                <div>
                    <button type="button" 
                            onclick="confirmDelete()"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-colors text-sm">
                        <i class="fas fa-trash mr-2"></i>Hapus Acara
                    </button>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('organizer.events.show', $event) }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-[#262363] text-white rounded-lg hover:bg-[#00183c] font-medium transition-colors shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>Perbarui Acara
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Form Konfirmasi Hapus -->
<form id="delete-form" action="{{ route('organizer.events.destroy', $event) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

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

// Konfirmasi hapus
function confirmDelete() {
    if (confirm('Yakin ingin menghapus acara ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection