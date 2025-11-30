{{-- resources/views/admin/bookings/index.blade.php --}}
@extends('layouts.admin')

@section('header', 'Manajemen Pemesanan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pemesanan</h1>
            <p class="text-gray-600 mt-2">Kelola semua pemesanan tiket dalam sistem</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Disetujui</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $approvedCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-red-100 text-red-600">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Dibatalkan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $cancelledCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-red-100 text-red-600">
                    <i class="fas fa-ban text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $rejectedCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pencarian</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Kode booking, nama user atau email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A3FF] focus:border-[#00A3FF] transition-all duration-300 outline-none"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A3FF] focus:border-[#00A3FF] transition-all duration-300 outline-none bg-white">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Event Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Acara</label>
                <select name="event" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A3FF] focus:border-[#00A3FF] transition-all duration-300 outline-none bg-white">
                    <option value="">Semua Acara</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ request('event') == $event->id ? 'selected' : '' }}>
                            {{ $event->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range -->
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                    <input 
                        type="date" 
                        name="date_from" 
                        value="{{ request('date_from') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A3FF] focus:border-[#00A3FF] transition-all duration-300 outline-none"
                    >
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                    <input 
                        type="date" 
                        name="date_to" 
                        value="{{ request('date_to') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A3FF] focus:border-[#00A3FF] transition-all duration-300 outline-none"
                    >
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="md:col-span-4 flex justify-end space-x-4 mt-4">
                <a href="{{ route('admin.bookings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold">
                    <i class="fas fa-refresh mr-2"></i>
                    Reset
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#262363] to-[#262363] text-white rounded-xl hover:from-[#221f5a] hover:to-#221f5a]  transition-all duration-300 font-semibold">
                    <i class="fas fa-filter mr-2"></i>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Semua Pemesanan</h2>
        </div>

        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pemesanan & Pengguna
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acara & Tiket
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Detail
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Booking & User Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">
                                                #{{ $booking->booking_code }}
                                            </div>
                                            <div class="text-sm text-gray-500 mt-1">
                                                {{ $booking->user->name }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $booking->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Event & Ticket -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $booking->ticket->event->name }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            {{ $booking->ticket->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            oleh {{ $booking->ticket->event->organizer->name }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Booking Details -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="text-sm text-gray-900">
                                            {{ $booking->quantity }} tiket
                                        </div>
                                        <div class="text-sm font-semibold text-green-600">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @if($booking->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Menunggu
                                        </span>
                                    @elseif($booking->status === 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Disetujui
                                        </span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-ban mr-1"></i>
                                            Ditolak
                                        </span>
                                    @endif
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $booking->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $booking->created_at->format('H:i') }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-[#262363] text-white rounded-xl hover:bg-[#24215e] transition-all duration-300 text-sm font-semibold">
                                            <i class="fas fa-eye mr-1"></i>
                                            Lihat
                                        </a>

                                        @if($booking->isPending())
                                            <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all duration-300 text-sm font-semibold">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Setujui
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all duration-300 text-sm font-semibold">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Tolak
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bookings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-ticket-alt text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pemesanan</h3>
                <p class="text-gray-600 mb-6">Tidak ada pemesanan yang sesuai dengan filter Anda.</p>
                <a href="{{ route('admin.bookings.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold">
                    <i class="fas fa-refresh mr-2"></i>
                    Hapus Filter
                </a>
            </div>
        @endif
    </div>
</div>
@endsection