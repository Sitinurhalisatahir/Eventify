{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('header', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Grid Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-cards.stats-card 
            title="Total Pengguna"
            value="{{ $totalUsers }}"
            icon="fas fa-users"
            color="blue"
            description="Pengguna terdaftar"
        />
        
        <x-cards.stats-card 
            title="Organizer Disetujui"
            value="{{ $totalOrganizers }}"
            icon="fas fa-user-check"
            color="green"
            description="Organizer aktif"
        />
        
        <x-cards.stats-card 
            title="Total Acara"
            value="{{ $totalEvents }}"
            icon="fas fa-calendar-alt"
            color="purple"
            description="Acara terbit"
        />
        
        <x-cards.stats-card 
            title="Menunggu Persetujuan"
            value="{{ $pendingOrganizers }}"
            icon="fas fa-clock"
            color="yellow"
            description="Organizer menunggu"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ringkasan Pendapatan -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Ringkasan Pendapatan</h3>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm text-gray-600">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Bulan Ini</p>
                        <p class="text-lg font-semibold text-green-600">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <!-- Distribusi Status Pemesanan -->
                <div class="mt-4">
                    <h4 class="font-medium text-gray-700 mb-3">Status Pemesanan</h4>
                    <div class="space-y-2">
                        @foreach($bookingsByStatus as $status => $count)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 capitalize">
                                    {{ $status === 'approved' ? 'Disetujui' : 
                                       ($status === 'pending' ? 'Menunggu' : 
                                       ($status === 'cancelled' ? 'Dibatalkan' : 
                                       ($status === 'rejected' ? 'Ditolak' : $status))) }}
                                </span>
                                <span class="font-medium text-gray-800">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Acara Populer -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Acara Populer</h3>
                <a href="{{ route('admin.events.index') }}" class="text-sm text-[#262363] hover:text-[#00183c]">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($popularEvents as $event)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800">{{ $event->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $event->bookings_count }} pemesanan • {{ $event->organizer->name }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $event->status === 'published' ? 'Terbit' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada acara</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pemesanan Terbaru & Acara per Kategori -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pemesanan Terbaru -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pemesanan Terbaru</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-sm text-[#262363] hover:text-[#00183c]">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($recentBookings as $booking)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $booking->booking_code }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->user->name }} • {{ $booking->ticket->event->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $booking->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $booking->status === 'approved' ? 'Disetujui' : 
                                   ($booking->status === 'pending' ? 'Menunggu' : 
                                   ($booking->status === 'cancelled' ? 'Dibatalkan' : 
                                   ($booking->status === 'rejected' ? 'Ditolak' : $booking->status))) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada pemesanan</p>
                @endforelse
            </div>
        </div>

        <!-- Acara per Kategori -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Acara per Kategori</h3>
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-[#262363] hover:text-[#00183c]">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($eventsByCategory as $category)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-tag text-blue-600 text-sm"></i>
                            </div>
                            <span class="font-medium text-gray-800">{{ $category->name }}</span>
                        </div>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-medium">
                            {{ $category->events_count }} acara
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada kategori</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection