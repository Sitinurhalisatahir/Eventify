{{-- resources/views/user/favorites/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Acara Favorit - ' . config('app.name', 'Eventify'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Acara Favorit Saya</h1>
            <p class="text-gray-600">Acara yang Anda simpan untuk nanti</p>
        </div>

        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorites as $favorite)
                    @php $event = $favorite->event; @endphp
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <!-- Event Image -->
                        <div class="relative h-48 overflow-hidden">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#262363] to-[#52154E] flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-white text-3xl"></i>
                                </div>
                            @endif

                            <!-- Event Status -->
                            <div class="absolute top-3 left-3">
                                @if($event->isCancelled())
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        DIBATALKAN
                                    </span>
                                @elseif($event->isPast())
                                    <span class="bg-gray-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        SELESAI
                                    </span>
                                @elseif($event->isUpcoming())
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        AKAN DATANG
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Event Content -->
                        <div class="p-4">
                            <!-- Category -->
                            @if($event->category)
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-[#e692b7]/10 text-[#262363] border border-[#e692b7]/20">
                                        <i class="{{ $event->category->icon }} mr-1"></i>
                                        {{ $event->category->name }}
                                    </span>
                                </div>
                            @endif

                            <!-- Event Name -->
                            <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">
                                <a href="{{ route('events.show', $event) }}" class="hover:text-[#262363] transition-colors">
                                    {{ $event->name }}
                                </a>
                            </h3>

                            <!-- Event Date & Location -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-gray-600 text-sm">
                                    <i class="fas fa-calendar-day w-4 mr-2"></i>
                                    <span>{{ $event->event_date->translatedFormat('d M Y | H:i') }}</span>
                                </div>
                                
                                <div class="flex items-center text-gray-600 text-sm">
                                    <i class="fas fa-map-marker-alt w-4 mr-2"></i>
                                    <span class="line-clamp-1">{{ $event->location }}</span>
                                </div>
                            </div>

                            <!-- Price & Availability -->
                            <div class="flex justify-between items-center mb-4 p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <div class="text-xs text-gray-500 font-medium">MULAI DARI</div>
                                    <div class="font-bold text-[#262363] text-lg">
                                        Rp. {{ number_format($event->cheapest_price, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-semibold {{ $event->hasAvailableTickets() ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $event->total_available_tickets }} tersisa
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('events.show', $event) }}" 
                                   class="flex-1 bg-gray-100 text-gray-700 hover:bg-gray-200 text-center py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                    Lihat Detail
                                </a>
                                
                                @if($event->isPublished() && $event->hasAvailableTickets() && $event->isUpcoming())
                                    <a href="{{ route('events.show', $event) }}#booking" 
                                       class="flex-1 bg-[#262363] text-white hover:bg-[#00183c] text-center py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                        Pesan Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-200">
                <i class="fas fa-heart text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada acara favorit</h3>
                <p class="text-gray-500 mb-6">Mulai jelajahi acara dan tambahkan ke favorit Anda</p>
                <a href="{{ route('events.index') }}" 
                   class="bg-[#262363] text-white px-6 py-3 rounded-lg hover:bg-[#00183c] font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Jelajahi Acara
                </a>
            </div>
        @endif
    </div>
</div>
@endsection