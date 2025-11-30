{{-- resources/views/organizer/events/show.blade.php --}}
@extends('layouts.organizer')

@section('header', $event->name)

@section('content')
<div class="space-y-6">
    <!-- Header Acara -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-[#262363] to-[#00183c] px-6 py-4">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $event->name }}</h2>
                    <div class="flex items-center space-x-4 mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                            {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : 
                               ($event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-red-100 text-red-800') }}">
                            {{ $event->status === 'published' ? 'Terbit' : 
                               ($event->status === 'draft' ? 'Draft' : 
                               ($event->status === 'cancelled' ? 'Dibatalkan' : $event->status)) }}
                        </span>
                        @if($event->category)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white bg-white bg-opacity-20">
                                <i class="{{ $event->category->icon }} mr-1"></i>
                                {{ $event->category->name }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('organizer.events.edit', $event) }}" 
                       class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg hover:bg-opacity-30 font-medium transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Gambar Acara -->
                <div class="lg:col-span-1">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" 
                             alt="{{ $event->name }}" 
                             class="w-full h-64 object-cover rounded-lg shadow-sm">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-[#262363] to-[#00183c] rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-4xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Detail Acara -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-day text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Acara</p>
                                    <p class="font-semibold text-gray-800">{{ $event->event_date->translatedFormat('j F Y \\p\\u\\k\\u\\l H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Lokasi</p>
                                    <p class="font-semibold text-gray-800">{{ $event->location }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-ticket-alt text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tiket</p>
                                    <p class="font-semibold text-gray-800">{{ $event->tickets_count ?? $event->tickets->count() }} jenis</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-orange-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Penyelenggara</p>
                                    <p class="font-semibold text-gray-800">{{ $event->organizer->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Deskripsi</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $event->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Tiket</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalTickets }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tiket Terjual</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $soldTickets }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-shopping-cart text-orange-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pemesanan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tiket & Aksi -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Manajemen Tiket -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Jenis Tiket</h3>
                    <a href="{{ route('organizer.events.tickets.create', $event) }}" 
                       class="bg-[#e6527b] text-white px-4 py-2 rounded-lg hover:bg-[#d9416d] font-medium transition-colors text-sm">
                        <i class="fas fa-plus mr-2"></i>Tambah Tiket
                    </a>
                </div>

                @if($event->tickets->count() > 0)
                    <div class="space-y-4">
                        @foreach($event->tickets as $ticket)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800">{{ $ticket->name }}</h4>
                                    <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                        <span>Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                                        <span>•</span>
                                        <span>{{ $ticket->quota_remaining }} / {{ $ticket->quota }} tersedia</span>
                                        <span>•</span>
                                        <span class="{{ $ticket->isAvailable() ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $ticket->isAvailable() ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('organizer.tickets.edit', $ticket) }}" 
                                       class="bg-gray-200 text-gray-700 hover:bg-gray-300 p-2 rounded-lg transition-colors">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-ticket-alt text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500 mb-4">Belum ada tiket dibuat</p>
                        <a href="{{ route('organizer.events.tickets.create', $event) }}" 
                           class="bg-[#e6527b] text-white px-4 py-2 rounded-lg hover:bg-[#d9416d] font-medium transition-colors inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>Buat Tiket Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="space-y-6">
            <!-- Status Acara -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Acara</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status Saat Ini</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : 
                               ($event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-red-100 text-red-800') }}">
                            {{ $event->status === 'published' ? 'Terbit' : 
                               ($event->status === 'draft' ? 'Draft' : 
                               ($event->status === 'cancelled' ? 'Dibatalkan' : $event->status)) }}
                        </span>
                    </div>
                    
                    @if($event->isUpcoming())
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Hari Menuju Acara</span>
                            <span class="font-semibold text-blue-600">{{ $event->event_date->diffInDays(now()) }} hari</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Dibuat</span>
                        <span class="text-sm text-gray-500">{{ $event->created_at->translatedFormat('j M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tautan Cepat -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('organizer.bookings.index') }}?event={{ $event->id }}" 
                       class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-gray-700">
                        <i class="fas fa-shopping-cart text-gray-400 mr-3"></i>
                        <span>Lihat Pemesanan</span>
                    </a>
                    
                    <a href="{{ route('organizer.events.edit', $event) }}" 
                       class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-gray-700">
                        <i class="fas fa-edit text-gray-400 mr-3"></i>
                        <span>Edit Acara</span>
                    </a>
                    
                    <a href="{{ route('events.show', $event) }}" 
                       target="_blank"
                       class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-gray-700">
                        <i class="fas fa-external-link-alt text-gray-400 mr-3"></i>
                        <span>Lihat Halaman Publik</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection