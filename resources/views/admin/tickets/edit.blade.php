{{-- resources/views/admin/tickets/edit.blade.php --}}
@extends('layouts.admin')

@section('header', 'Edit Tiket')

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
                <a href="{{ route('admin.events.show', $ticket->event) }}" class="text-sm font-medium text-gray-500 hover:text-[#262363] transition-colors">
                    {{ $ticket->event->name }}
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                <span class="text-sm font-medium text-[#262363]">Edit {{ $ticket->name }}</span>
            </li>
        </ol>
    </nav>

    <!-- Form Container - FULL WIDTH -->
    <div class="w-full">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-[#262363] text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold">Edit Tiket</h2>
                        <p class="text-gray-200 mt-1">Perbarui detail tiket untuk {{ $ticket->event->name }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($ticket->image)
                            <img src="{{ asset('storage/' . $ticket->image) }}" 
                                 alt="{{ $ticket->name }}"
                                 class="w-12 h-12 rounded-lg object-cover border-2 border-white">
                        @else
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-white"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

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
                            value="{{ old('name', $ticket->name) }}"
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
                        >{{ old('description', $ticket->description) }}</textarea>
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
                                    value="{{ old('price', $ticket->price) }}"
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
                                value="{{ old('quota', $ticket->quota) }}"
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
                            <p class="text-sm text-gray-500">
                                Terjual: {{ $ticket->sold_count }} tiket | Tersedia: {{ $ticket->quota_remaining }} tiket
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Upload Gambar -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Gambar Tiket</h3>
                    
                    <div class="space-y-2">
                        <!-- Gambar Saat Ini -->
                        @if($ticket->image)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/' . $ticket->image) }}" 
                                     alt="{{ $ticket->name }}"
                                     class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                            </div>
                        @endif

                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#262363] transition-colors duration-300">
                            <input 
                                type="file"
                                name="image"
                                id="imageInput"
                                accept="image/*"
                                class="hidden"
                            >
                            <div id="imagePreview" class="mb-4">
                                @if($ticket->image)
                                    <p class="text-sm text-gray-600">Upload gambar baru untuk mengganti yang lama</p>
                                @else
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600">Klik untuk mengupload gambar tiket</p>
                                @endif
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

                <!-- Statistik Tiket -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-3">Statistik Tiket</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">{{ $ticket->sold_count }}</div>
                            <div class="text-gray-600">Terjual</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">{{ $ticket->quota_remaining }}</div>
                            <div class="text-gray-600">Tersedia</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">{{ $ticket->quota }}</div>
                            <div class="text-gray-600">Total Kuota</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">{{ number_format($ticket->sold_percentage, 1) }}%</div>
                            <div class="text-gray-600">Persentase Terjual</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div>
                        <form 
                            action="{{ route('admin.tickets.destroy', $ticket) }}" 
                            method="POST" 
                            class="inline"
                            onsubmit="return confirm('Hapus tiket {{ $ticket->name }}? {{ $ticket->bookings()->count() > 0 ? 'Ini akan menghapus ' . $ticket->bookings()->count() . ' booking yang terkait.' : '' }}')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all duration-300 font-semibold">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Tiket
                            </button>
                        </form>
                    </div>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.events.show', $ticket->event) }}"
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-[#262363] text-white rounded-xl hover:bg-[#1e1a4f] transition-all duration-300 font-semibold shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>
                            Perbarui Tiket
                        </button>
                    </div>
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
                        <p class="text-sm text-green-600">Gambar baru dipilih: ${file.name}</p>
                    `;
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection