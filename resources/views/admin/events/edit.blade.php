@extends('layouts.admin')

@section('header', 'Edit Event')

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
                    Events
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                <span class="text-sm font-medium text-[#262363]">Edit {{ $event->name }}</span>
            </li>
        </ol>
    </nav>

    <!-- Form Container - FULL WIDTH -->
    <div class="w-full">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header dengan warna #262363 -->
            <div class="px-6 py-4 border-b border-gray-200 bg-[#262363] text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold">Edit Event</h2>
                        <p class="text-gray-200 mt-1">Update event details and properties</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" 
                                 alt="{{ $event->name }}"
                                 class="w-12 h-12 rounded-lg object-cover border-2 border-white">
                        @else
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- FORM EDIT -->
            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Dasar</h3>
                    
                    <!-- Nama Event -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            Nama Event
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="name"
                            value="{{ old('name', $event->name) }}"
                            placeholder="e.g., Summer Music Festival 2024"
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

                    <!-- Kategori & Organizer -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kategori -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Kategori
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none bg-white">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->first('category_id'))
                                <p class="text-red-600 text-sm font-medium flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $errors->first('category_id') }}
                                </p>
                            @endif
                        </div>

                        <!-- Organizer -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Organizer
                            </label>
                            <select name="organizer_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none bg-white">
                                <option value="">Pilih Organizer (Opsional)</option>
                                @foreach($organizers as $organizer)
                                    <option value="{{ $organizer->id }}" {{ old('organizer_id', $event->organizer_id) == $organizer->id ? 'selected' : '' }}>
                                        {{ $organizer->name }} ({{ $organizer->email }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-gray-500 text-sm">Kosongkan untuk assign ke diri sendiri (Admin)</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Event -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Detail Event</h3>
                    
                    <!-- Deskripsi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            Deskripsi
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="description"
                            rows="6"
                            placeholder="Deskripsikan event Anda secara detail..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none resize-vertical"
                            required
                        >{{ old('description', $event->description) }}</textarea>
                        @if($errors->first('description'))
                            <p class="text-red-600 text-sm font-medium flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $errors->first('description') }}
                            </p>
                        @endif
                    </div>

                    <!-- Tanggal & Lokasi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal Event -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Tanggal & Waktu Event
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="datetime-local"
                                name="event_date"
                                value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}"
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                                required
                            >
                            @if($errors->first('event_date'))
                                <p class="text-red-600 text-sm font-medium flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $errors->first('event_date') }}
                                </p>
                            @endif
                        </div>

                        <!-- Lokasi -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Lokasi
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text"
                                name="location"
                                value="{{ old('location', $event->location) }}"
                                placeholder="e.g., Central Park, New York"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none"
                                required
                            >
                            @if($errors->first('location'))
                                <p class="text-red-600 text-sm font-medium flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $errors->first('location') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Media & Status -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Media & Status</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Upload Gambar -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Gambar Event
                            </label>
                            
                            <!-- Gambar Saat Ini -->
                            @if($event->image)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $event->image) }}" 
                                         alt="{{ $event->name }}"
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
                                    @if($event->image)
                                        <p class="text-sm text-gray-600">Upload gambar baru untuk mengganti yang lama</p>
                                    @else
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-600">Klik untuk upload gambar event</p>
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

                        <!-- Status -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Status
                            </label>
                            <select name="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none bg-white">
                                <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <div class="space-y-2 mt-3 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-info-circle mr-2 text-[#262363]"></i>
                                    <span><strong>Draft:</strong> Tersembunyi dari publik</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-eye mr-2 text-green-500"></i>
                                    <span><strong>Published:</strong> Terlihat oleh publik</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-ban mr-2 text-red-500"></i>
                                    <span><strong>Cancelled:</strong> Event dibatalkan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Event -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="font-semibold text-gray-800 mb-3">Statistik Event</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">{{ $event->tickets->count() }}</div>
                            <div class="text-gray-600">Jenis Tiket</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">{{ $event->total_available_tickets }}</div>
                            <div class="text-gray-600">Tiket Tersedia</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">{{ $event->bookings()->count() }}</div>
                            <div class="text-gray-600">Total Booking</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900">
                                @if($event->isPast())
                                    <span class="text-gray-500">Event Selesai</span>
                                @elseif($event->isUpcoming())
                                    <span class="text-green-600">Akan Datang</span>
                                @else
                                    <span class="text-blue-600">Sedang Berlangsung</span>
                                @endif
                            </div>
                            <div class="text-gray-600">Timeline</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.events.show', $event) }}"
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-[#262363] text-white rounded-xl hover:bg-[#1e1a4f] transition-all duration-300 font-semibold shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>
                            Perbarui Acara
                        </button>
                    </div>
                </div>
            </form>

            <!-- DELETE FORM TERPISAH -->
            @if(!$event->bookings()->exists())
                <div class="px-6 pb-6 border-t border-gray-200 pt-4">
                    <form 
                        action="{{ route('admin.events.destroy', $event) }}" 
                        method="POST" 
                        class="inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Ini akan menghapus semua tiket yang terkait.')"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Event
                        </button>
                    </form>
                </div>
            @else
                <div class="px-6 pb-6 border-t border-gray-200 pt-4">
                    <button disabled
                            class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed font-semibold"
                            title="Tidak dapat menghapus event yang memiliki booking">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Event (Ada Booking)
                    </button>
                </div>
            @endif
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