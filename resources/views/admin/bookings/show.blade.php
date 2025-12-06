@extends('layouts.admin')

@section('header', 'Detail Booking')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb Manual -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-[#00A3FF] transition-colors">
                    Dashboard
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                <a href="{{ route('admin.bookings.index') }}" class="text-sm font-medium text-gray-500 hover:text-[#00A3FF] transition-colors">
                    Bookings
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                <span class="text-sm font-medium text-[#00A3FF]">Booking #{{ $booking->booking_code }}</span>
            </li>
        </ol>
    </nav>

    <!-- Header dengan Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Booking#{{ $booking->booking_code }}</h1>
            <p class="text-gray-600 mt-2">Detail lengkap pesanan dan manajemen</p>
        </div>
        <div class="flex items-center space-x-3">
            @if($booking->isPending())
                <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all duration-300 font-semibold shadow-lg">
                        <i class="fas fa-check mr-2"></i>
                        Setujui Booking
                    </button>
                </form>

                <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all duration-300 font-semibold">
                        <i class="fas fa-times mr-2"></i>
                        Tolak Booking
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Booking -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-800">Informasi Booking</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Detail Booking -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="font-semibold text-gray-700 mb-3">Detail Booking</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Kode Booking:</span>
                                        <span class="font-semibold text-gray-900">#{{ $booking->booking_code }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($booking->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800')) }}">
                                            {{ $booking->status === 'pending' ? 'Menunggu' : 
                                               ($booking->status === 'approved' ? 'Disetujui' : 
                                               ($booking->status === 'cancelled' ? 'Dibatalkan' : 'Ditolak')) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Jumlah:</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->quantity }} tiket</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Total Harga:</span>
                                        <span class="font-semibold text-green-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Booking:</span>
                                        <span class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y \\p\\a\\d\\a H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Acara -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-700 mb-3">Detail Acara</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="font-semibold text-gray-900 text-lg">{{ $booking->ticket->event->name }}</p>
                                    <p class="text-gray-600 text-sm mt-1">{{ $booking->ticket->event->description }}</p>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-calendar-day mr-2 w-5"></i>
                                    <span>{{ $booking->ticket->event->event_date->format('l, j F Y \\p\\a\\d\\a H:i') }}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 w-5"></i>
                                    <span>{{ $booking->ticket->event->location }}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-user mr-2 w-5"></i>
                                    <span>Organizer: {{ $booking->ticket->event->organizer->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tiket -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="font-semibold text-gray-700 mb-3">Informasi Tiket</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $booking->ticket->name }}</p>
                                    <p class="text-gray-600 text-sm mt-1">{{ $booking->ticket->description }}</p>
                                    <div class="flex items-center space-x-4 mt-2 text-sm">
                                        <span class="text-green-600 font-semibold">Rp {{ number_format($booking->ticket->price, 0, ',', '.') }} per tiket</span>
                                        <span class="text-gray-500">Tersedia: {{ $booking->ticket->quota_remaining }}/{{ $booking->ticket->quota }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Perhitungan Harga:</p>
                                    <p class="font-semibold text-green-600">{{ $booking->quantity }} × Rp {{ number_format($booking->ticket->price, 0, ',', '.') }}</p>
                                    <p class="text-lg font-bold text-green-600">= Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pelanggan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-800">Informasi Pelanggan</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div>
                                <p class="font-semibold text-gray-700">Nama Lengkap</p>
                                <p class="text-gray-900">{{ $booking->user->name }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">Alamat Email</p>
                                <p class="text-gray-900">{{ $booking->user->email }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">Nomor Telepon</p>
                                <p class="text-gray-900">{{ $booking->user->phone ?? 'Tidak tersedia' }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="font-semibold text-gray-700">Member Sejak</p>
                                <p class="text-gray-900">{{ $booking->user->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">Total Booking</p>
                                <p class="text-gray-900">{{ $booking->user->bookings()->count() }} booking</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">Peran Pengguna</p>
                                <p class="text-gray-900 capitalize">{{ $booking->user->role }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Aksi Cepat -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Aksi Cepat</h2>
                </div>
                <div class="p-6 space-y-3">
                    @if($booking->isPending())
                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center justify-center p-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all duration-300 font-semibold">
                                <i class="fas fa-check mr-2"></i>
                                Setujui Booking
                            </button>
                        </form>

                        <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center justify-center p-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all duration-300 font-semibold">
                                <i class="fas fa-times mr-2"></i>
                                Tolak Booking
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.events.show', $booking->ticket->event) }}" 
                       class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-300 w-full">
                        <i class="fas fa-calendar text-blue-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Lihat Acara</span>
                    </a>

                    {{-- <a href="mailto:{{ $booking->user->email }}" 
                       class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-300 w-full">
                        <i class="fas fa-envelope text-purple-500 mr-3"></i>
                        <span class="font-medium text-gray-700">Hubungi Pelanggan</span>
                    </a> --}}
                </div>
            </div>

            <!-- Timeline Booking -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Timeline Booking</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <div>
                                <p class="font-medium text-gray-700">Booking Dibuat</p>
                                <p class="text-sm text-gray-500">{{ $booking->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        
                        @if($booking->isApproved())
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="font-medium text-gray-700">Disetujui</p>
                                    <p class="text-sm text-gray-500">{{ $booking->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @elseif($booking->isRejected())
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="font-medium text-gray-700">Ditolak</p>
                                    <p class="text-sm text-gray-500">{{ $booking->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @elseif($booking->isCancelled())
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="font-medium text-gray-700">Dibatalkan</p>
                                    <p class="text-sm text-gray-500">{{ $booking->cancelled_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                            <div>
                                <p class="font-medium text-gray-700">Tanggal Acara</p>
                                <p class="text-sm text-gray-500">{{ $booking->ticket->event->event_date->format('j M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Informasi Status</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-2 text-sm">
                        @if($booking->isPending())
                            <p class="text-yellow-600 font-medium">⏳ Booking ini menunggu persetujuan.</p>
                            <p class="text-gray-600">Anda dapat menyetujui atau menolak permintaan booking ini.</p>
                        @elseif($booking->isApproved())
                            <p class="text-green-600 font-medium">✅ Booking ini telah disetujui.</p>
                            <p class="text-gray-600">Pelanggan akan menerima tiket digital mereka.</p>
                        @elseif($booking->isRejected())
                            <p class="text-red-600 font-medium">❌ Booking ini telah ditolak.</p>
                            <p class="text-gray-600">Kuota tiket telah dikembalikan ke acara.</p>
                        @else
                            <p class="text-orange-600 font-medium">🚫 Booking ini dibatalkan.</p>
                            <p class="text-gray-600">Booking dibatalkan oleh pelanggan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection