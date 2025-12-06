{{-- resources/views/organizer/tickets/edit.blade.php --}}
@extends('layouts.organizer')

@section('header', 'Edit Tiket')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-[#262363] to-[#00183c] px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Edit Tiket</h2>
                    <p class="text-blue-100 text-sm">Perbarui detail tiket untuk: {{ $ticket->event->name }}</p>
                </div>
                <a href="{{ route('organizer.events.show', $ticket->event) }}" 
                   class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg hover:bg-opacity-30 font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Acara
                </a>
            </div>
        </div>

        <form action="{{ route('organizer.tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PATCH')

            <!-- Statistik Tiket -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="text-center">
                    <p class="text-sm text-gray-500">Total Kuota</p>
                    <p class="text-lg font-bold text-gray-800">{{ $ticket->quota }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500">Tiket Terjual</p>
                    <p class="text-lg font-bold text-green-600">{{ $ticket->sold_count }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500">Tersedia</p>
                    <p class="text-lg font-bold text-blue-600">{{ $ticket->quota_remaining }}</p>
                </div>
            </div>

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
                               value="{{ old('name', $ticket->name) }}"
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
                                   value="{{ old('price', $ticket->price) }}"
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
                               value="{{ old('quota', $ticket->quota) }}"
                               min="{{ $ticket->sold_count }}"
                               required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('quota') border-red-500 @enderror"
                               placeholder="Jumlah tiket yang tersedia">
                        <p class="mt-1 text-sm text-gray-500">
                            Kuota minimum: {{ $ticket->sold_count }} (tiket sudah terjual)
                        </p>
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
                            Gambar Tiket
                        </label>
                        
                        <!-- Gambar Saat Ini -->
                        @if($ticket->image)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/' . $ticket->image) }}" 
                                     alt="{{ $ticket->name }}" 
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
                    Deskripsi (Opsional)
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none @error('description') border-red-500 @enderror"
                          placeholder="Jelaskan jenis tiket ini (manfaat, fasilitas, dll)">{{ old('description', $ticket->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Aksi Form -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-8">
                <div>
                    @if($ticket->bookings()->count() == 0)
                        <button type="button" 
                                onclick="confirmDelete()"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-colors text-sm">
                            <i class="fas fa-trash mr-2"></i>Hapus Tiket
                        </button>
                    @else
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Tidak dapat menghapus - {{ $ticket->bookings()->count() }} pemesanan ada
                        </p>
                    @endif
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('organizer.events.show', $ticket->event) }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-[#262363] text-white rounded-lg hover:bg-[#00183c] font-medium transition-colors shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>Perbarui Tiket
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Form Konfirmasi Hapus -->
<form id="delete-form" action="{{ route('organizer.tickets.destroy', $ticket) }}" method="POST" class="hidden">
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

// Format harga
document.getElementById('price').addEventListener('blur', function(e) {
    if (this.value) {
        this.value = parseFloat(this.value).toFixed(2);
    }
});

// Konfirmasi hapus
function confirmDelete() {
    if (confirm('Yakin ingin menghapus tiket ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection