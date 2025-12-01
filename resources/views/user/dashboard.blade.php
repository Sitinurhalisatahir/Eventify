{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name', 'Eventify'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Selamat datang, {{ auth()->user()->name }} !</h1>
            <p class="text-gray-600 mt-2">Berikut ringkasan pemesanan acara Anda</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Bookings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#e692b7]/10 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-ticket-alt text-[#e6527b] text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pemesanan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalBookings }}</p>
                    </div>
                </div>
            </div>

            <!-- Approved Bookings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-500 bg-opacity-10 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Disetujui</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $approvedBookings }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Bookings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-500 bg-opacity-10 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-yellow-500 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Menunggu</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingBookings }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#262363] bg-opacity-10 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-wallet text-[#262363] text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pengeluaran</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Bookings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Pemesanan Terbaru</h2>
                    <a href="{{ route('user.bookings.index') }}" class="text-[#e6527b] hover:text-[#d9416d] font-medium text-sm">
                        Lihat Semua
                    </a>
                </div>

                @if($recentBookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentBookings as $booking)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-[#e6527b] rounded-lg flex items-center justify-center text-white text-sm font-bold">
                                        {{ substr($booking->booking_code, 0, 3) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">
                                            {{ $booking->ticket->event->name }}
                                        </p>
                                        <p class="text-gray-500 text-xs">
                                            {{ $booking->created_at->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        {{ $booking->status === 'approved' ? 'Disetujui' : ($booking->status === 'pending' ? 'Menunggu' : 'Dibatalkan') }}
                                    </span>
                                    <p class="text-sm font-semibold text-gray-900 mt-1">
                                        Rp. {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-ticket-alt text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">Belum ada pemesanan</p>
                        <a href="{{ route('events.index') }}" class="text-[#e6527b] hover:text-[#d9416d] font-medium text-sm mt-2 inline-block">
                            Jelajahi Acara
                        </a>
                    </div>
                @endif
            </div>

            <!-- Favorite Events -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Acara Favorit</h2>
                    <a href="{{ route('user.favorites.index') }}" class="text-[#e6527b] hover:text-[#d9416d] font-medium text-sm">
                        Lihat Semua
                    </a>
                </div>

                @if($favoriteEvents->count() > 0)
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($favoriteEvents as $event)
                            <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" 
                                         class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-[#e6527b] rounded-lg flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-white text-sm"></i>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate">
                                        {{ $event->name }}
                                    </p>
                                    <p class="text-gray-500 text-xs">
                                        {{ $event->event_date->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                                <form action="{{ route('user.favorites.destroy', $event) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#e6527b] hover:text-[#d9416d] transition-colors">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-heart text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">Belum ada acara favorit</p>
                        <a href="{{ route('events.index') }}" class="text-[#e6527b] hover:text-[#d9416d] font-medium text-sm mt-2 inline-block">
                            Jelajahi Acara
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Events Section -->
        @if($upcomingEvents->count() > 0)
            <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Acara Mendatang</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($upcomingEvents as $event)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="font-semibold text-gray-900 text-sm line-clamp-2">{{ $event->name }}</h3>
                                @if($event->category)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ml-2 flex-shrink-0 bg-[#e692b7]/10 text-[#262363] border border-[#e692b7]/20">
                                        <i class="{{ $event->category->icon }} mr-1 text-xs"></i>
                                        {{ $event->category->name }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center text-gray-500 text-xs mb-2">
                                <i class="fas fa-calendar-day mr-2"></i>
                                {{ $event->event_date->translatedFormat('d M Y | H:i') }}
                            </div>
                            <div class="flex items-center text-gray-500 text-xs mb-3">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span class="truncate">{{ $event->location }}</span>
                            </div>
                            <a href="{{ route('events.show', $event) }}" 
                               class="w-full bg-[#e6527b] text-white text-center py-2 px-4 rounded-lg hover:bg-[#d9416d] font-medium text-sm transition-colors block">
                                Lihat Acara
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection