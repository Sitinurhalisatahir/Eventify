{{-- resources/views/organizer/dashboard.blade.php --}}
@extends('layouts.organizer')

@section('header', 'Dashboard Organizer')

@section('content')
<div class="space-y-6">
    <!-- Grid Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-cards.stats-card 
            title="Total Acara"
            value="{{ $totalEvents }}"
            icon="fas fa-calendar-alt"
            color="blue"
            description="{{ $publishedEvents }} published, {{ $draftEvents }} draft"
        />
        
        <x-cards.stats-card 
            title="Total Pemesanan"
            value="{{ $totalBookings }}"
            icon="fas fa-ticket-alt"
            color="green"
            description="{{ $pendingBookings }} menunggu persetujuan"
        />
        
        <x-cards.stats-card 
            title="Total Pendapatan"
            value="Rp {{ number_format($totalRevenue, 0, ',', '.') }}"
            icon="fas fa-money-bill-wave"
            color="purple"
            description="Rp {{ number_format($monthlyRevenue, 0, ',', '.') }} bulan ini"
        />
        
        <x-cards.stats-card 
            title="Pemesanan Tertunda"
            value="{{ $pendingBookings }}"
            icon="fas fa-clock"
            color="yellow"
            description="Perlu persetujuan Anda"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Acara Populer -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Acara Populer</h3>
                <a href="{{ route('organizer.events.index') }}" class="text-sm text-[#262363] hover:text-[#00183c]">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($popularEvents as $event)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800">{{ $event->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $event->bookings_count }} pemesanan</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $event->status === 'published' ? 'Terbit' : 
                                ($event->status === 'draft' ? 'Draft' : 
                                ($event->status === 'cancelled' ? 'Dibatalkan' : $event->status)) }}
                                </span>
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada acara</p>
                @endforelse
            </div>
        </div>

        <!-- Acara Mendatang -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Acara Mendatang</h3>
                <a href="{{ route('organizer.events.index') }}" class="text-sm text-[#262363] hover:text-[#00183c]">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($upcomingEvents as $event)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800">{{ $event->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $event->event_date->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Akan Datang
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Tidak ada acara mendatang</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pemesanan Terbaru -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pemesanan Terbaru</h3>
            <a href="{{ route('organizer.bookings.index') }}" class="text-sm text-[#262363] hover:text-[#00183c]">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acara</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $booking->booking_code }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->ticket->event->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $booking->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $booking->status === 'approved' ? 'Disetujui' : 
                                       ($booking->status === 'pending' ? 'Menunggu' : 
                                       ($booking->status === 'rejected' ? 'Ditolak' : 
                                       ($booking->status === 'cancelled' ? 'Dibatalkan' : $booking->status))) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Belum ada pemesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection