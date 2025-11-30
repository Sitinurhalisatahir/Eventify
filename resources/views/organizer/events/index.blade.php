{{-- resources/views/organizer/events/index.blade.php --}}
@extends('layouts.organizer')

@section('header', 'Acara Saya')

@section('content')
<div class="space-y-6">
    <!-- Header & Buat Acara -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Acara Saya</h1>
            <p class="text-gray-600">Kelola dan pantau acara Anda</p>
        </div>
        <a href="{{ route('organizer.events.create') }}" 
           class="bg-[#e6527b] text-white px-6 py-3 rounded-lg hover:bg-[#d9416d] font-semibold transition-colors shadow-lg hover:shadow-xl">
            <i class="fas fa-plus mr-2"></i> Buat Acara
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('organizer.events.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Pencarian -->
                <div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari acara..."
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none">
                </div>

                <!-- Filter Status -->
                <div>
                    <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Filter Kategori -->
                <div>
                    <select name="category" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" 
                        class="bg-[#262363] text-white px-6 py-2 rounded-lg hover:bg-[#00183c] font-medium transition-colors">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
                <a href="{{ route('organizer.events.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                    Hapus
                </a>
            </div>
        </form>
    </div>

    <!-- Grid Acara -->
    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <!-- Gambar Acara -->
                    <div class="relative h-48 overflow-hidden">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#262363] to-[#00183c] flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-white text-3xl"></i>
                            </div>
                        @endif
                        
                        <!-- Status Acara -->
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : ($event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                             {{ $event->status === 'published' ? 'Terbit' : 
                             ($event->status === 'draft' ? 'Draft' : 
                             ($event->status === 'cancelled' ? 'Dibatalkan' : $event->status)) }}
                             </span>
                        </div>

                        <!-- Jumlah Tiket -->
                        <div class="absolute top-3 right-3">
                            <span class="bg-black bg-opacity-50 text-white px-2 py-1 rounded-full text-xs font-medium">
                                {{ $event->tickets_count }} tiket
                            </span>
                        </div>
                    </div>

                    <!-- Konten Acara -->
                    <div class="p-4">
                        <!-- Kategori -->
                        @if($event->category)
                            <div class="mb-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold" 
                                      style="background-color: {{ $event->category->color }}20; color: {{ $event->category->color }}; border: 1px solid {{ $event->category->color }}30;">
                                    <i class="{{ $event->category->icon }} mr-1"></i>
                                    {{ $event->category->name }}
                                </span>
                            </div>
                        @endif

                        <!-- Nama Acara -->
                        <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">
                            {{ $event->name }}
                        </h3>

                        <!-- Tanggal & Lokasi Acara -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-gray-600 text-sm">
                                <i class="fas fa-calendar-day w-4 mr-2"></i>
                                <span>{{ $event->event_date->format('d M Y | H:i') }}</span>
                            </div>
                            
                            <div class="flex items-center text-gray-600 text-sm">
                                <i class="fas fa-map-marker-alt w-4 mr-2"></i>
                                <span class="line-clamp-1">{{ $event->location }}</span>
                            </div>
                        </div>

                        <!-- Statistik -->
                        <div class="flex justify-between items-center mb-4 text-sm">
                            <div class="text-center">
                                <div class="font-semibold text-gray-900">{{ $event->bookings_count ?? 0 }}</div>
                                <div class="text-gray-500">Pemesanan</div>
                            </div>
                            <div class="text-center">
                                <div class="font-semibold text-gray-900">
                                    {{ $event->tickets->sum('quota_remaining') }}
                                </div>
                                <div class="text-gray-500">Tersedia</div>
                            </div>
                            <div class="text-center">
                                <div class="font-semibold text-green-600">
                                    Rp {{ number_format($event->revenue ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-gray-500">Pendapatan</div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex space-x-2">
                            <a href="{{ route('organizer.events.show', $event) }}" 
                               class="flex-1 bg-[#262363] text-white hover:bg-[#00183c] text-center py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                Kelola
                            </a>
                            <a href="{{ route('events.show', $event) }}" 
                               class="bg-gray-200 text-gray-700 hover:bg-gray-300 py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('organizer.events.edit', $event) }}" 
                               class="bg-gray-200 text-gray-700 hover:bg-gray-300 py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-200">
            <i class="fas fa-calendar-times text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada acara ditemukan</h3>
            <p class="text-gray-500 mb-6">
                @if(request('search') || request('status') || request('category'))
                    Coba sesuaikan filter pencarian Anda
                @else
                    Anda belum membuat acara apapun
                @endif
            </p>
            <a href="{{ route('organizer.events.create') }}" 
               class="bg-[#e6527b] text-white px-6 py-3 rounded-lg hover:bg-[#d9416d] font-medium transition-colors inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Buat Acara Pertama
            </a>
        </div>
    @endif
</div>
@endsection