{{-- resources/views/user/bookings/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pemesanan Saya - ' . config('app.name', 'Eventify'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Pemesanan Saya</h1>
            <p class="text-gray-600">Kelola dan lihat pemesanan acara Anda</p>
        </div>

        <!-- Stats Tabs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('user.bookings.index') }}" 
                   class="text-center p-4 rounded-lg border-2 border-transparent hover:border-[#262363] transition-colors {{ !request('status') ? 'bg-[#e692b7]/10 border-[#262363]' : 'bg-gray-50' }}">
                    <div class="text-2xl font-bold text-gray-900">{{ $pendingCount + $approvedCount + $cancelledCount }}</div>
                    <div class="text-sm text-gray-600">Semua Pemesanan</div>
                </a>
                <a href="{{ route('user.bookings.index', ['status' => 'pending']) }}" 
                   class="text-center p-4 rounded-lg border-2 border-transparent hover:border-yellow-500 transition-colors {{ request('status') == 'pending' ? 'bg-yellow-50 border-yellow-500' : 'bg-gray-50' }}">
                    <div class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</div>
                    <div class="text-sm text-gray-600">Menunggu</div>
                </a>
                <a href="{{ route('user.bookings.index', ['status' => 'approved']) }}" 
                   class="text-center p-4 rounded-lg border-2 border-transparent hover:border-green-500 transition-colors {{ request('status') == 'approved' ? 'bg-green-50 border-green-500' : 'bg-gray-50' }}">
                    <div class="text-2xl font-bold text-gray-900">{{ $approvedCount }}</div>
                    <div class="text-sm text-gray-600">Disetujui</div>
                </a>
                <a href="{{ route('user.bookings.index', ['status' => 'cancelled']) }}" 
                   class="text-center p-4 rounded-lg border-2 border-transparent hover:border-red-500 transition-colors {{ request('status') == 'cancelled' ? 'bg-red-50 border-red-500' : 'bg-gray-50' }}">
                    <div class="text-2xl font-bold text-gray-900">{{ $cancelledCount }}</div>
                    <div class="text-sm text-gray-600">Dibatalkan</div>
                </a>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('user.bookings.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari berdasarkan kode booking atau nama acara..."
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#e6527b] focus:ring-2 focus:ring-[#e6527b] transition-all duration-300 outline-none">
                </div>
                <div class="flex gap-2">
                    <button type="submit" 
                            class="bg-[#262363] text-white px-6 py-2 rounded-lg hover:bg-[#00183c] font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                    <a href="{{ route('user.bookings.index') }}" 
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                        Hapus
                    </a>
                </div>
            </form>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            @if($bookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acara</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-[#262363] rounded-lg flex items-center justify-center text-white text-sm font-bold mr-3">
                                                {{ substr($booking->booking_code, 0, 3) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $booking->booking_code }}</div>
                                                <div class="text-sm text-gray-500">{{ $booking->quantity }} tiket</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 line-clamp-2">{{ $booking->ticket->event->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->ticket->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $booking->created_at->translatedFormat('d M Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ $booking->status === 'approved' ? 'Disetujui' : ($booking->status === 'pending' ? 'Menunggu' : 'Dibatalkan') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('user.bookings.show', $booking) }}" 
                                           class="text-[#262363] hover:text-[#00183c] mr-4">Lihat</a>
                                        @if($booking->canBeCancelled())
                                            <form action="{{ route('user.bookings.destroy', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Yakin ingin membatalkan pemesanan ini?')">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-6 py-4 border-t border-gray-200">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-ticket-alt text-gray-300 text-4xl mb-3"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pemesanan ditemukan</h3>
                    <p class="text-gray-500 mb-6">
                        @if(request('search') || request('status'))
                            Coba sesuaikan kriteria pencarian Anda
                        @else
                            Anda belum melakukan pemesanan apapun
                        @endif
                    </p>
                    <a href="{{ route('events.index') }}" 
                       class="bg-[#262363] text-white px-6 py-3 rounded-lg hover:bg-[#00183c] font-medium transition-colors inline-flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Jelajahi Acara
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection