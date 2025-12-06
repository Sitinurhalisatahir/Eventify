{{-- resources/views/organizer/tickets/create.blade.php --}}
@extends('layouts.organizer')

@section('header', 'Buat Tiket Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-[#262363] to-[#00183c] px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Buat Tiket Baru</h2>
                    <p class="text-blue-100 text-sm">Tambah jenis tiket untuk: {{ $event->name }}</p>
                </div>
                <a href="{{ route('organizer.events.show', $event) }}" 
                   class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg hover:bg-opacity-30 font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Acara
                </a>
            </div>
        </div>

        <form action="{{ route('organizer.events.tickets.store', $event) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-6">
                    <!-- Nama Tiket -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Tiket <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}"
                               required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('name') border-red-500 @enderror"
                               placeholder="contoh: Reguler, VIP, Early Bird">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="number" 
                                   name="price" 
                                   id="price"
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01"
                                   required
                                   class="w-full rounded-lg border border-gray-300 pl-16 pr-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('price') border-red-500 @enderror"
                                   placeholder="0.00">
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kuota -->
                    <div>
                        <label for="quota" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Kuota <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="quota" 
                               id="quota"
                               value="{{ old('quota') }}"
                               min="1"
                               required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('quota') border-red-500 @enderror"
                               placeholder="Jumlah tiket yang tersedia">
                        @error('quota')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-6">
                    <!-- Gambar Tiket -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Tiket (Opsional)
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
                    Deskripsi (Opsional)
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('description') border-red-500 @enderror"
                          placeholder="Jelaskan jenis tiket ini (manfaat, fasilitas, dll)">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Acara -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-blue-800">Membuat tiket untuk:</p>
                        <p class="text-sm text-blue-600">{{ $event->name }}</p>
                        <p class="text-xs text-blue-500 mt-1">Tanggal Acara: {{ $event->event_date->translatedFormat('j F Y \\p\\u\\k\\u\\l H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Aksi Form -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 mt-8">
                <a href="{{ route('organizer.events.show', $event) }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-[#e6527b] text-white rounded-lg hover:bg-[#d9416d] font-medium transition-colors shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus mr-2"></i>Buat Tiket
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

// Format harga
document.getElementById('price').addEventListener('blur', function(e) {
    if (this.value) {
        this.value = parseFloat(this.value).toFixed(2);
    }
});
</script>
@endsection