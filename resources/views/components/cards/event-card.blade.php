{{-- resources/views/components/cards/event-card.blade.php --}}
<div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border-0 hover:scale-[1.02] flex flex-col h-full">
    <!-- Event Image - FIXED HEIGHT -->
    <div class="relative h-48 overflow-hidden flex-shrink-0">
        @if($event->image)
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" 
                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                <i class="fas fa-calendar-alt text-gray-400 text-4xl"></i>
            </div>
        @endif
        
        <!-- Event Status -->
        <div class="absolute top-3 left-3">
            @if($event->isCancelled())
                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-times-circle mr-1"></i>DIBATALKAN
                </span>
            @elseif($event->isPast())
                <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-check-circle mr-1"></i>SELESAI
                </span>
            @elseif($event->isUpcoming())
                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-clock mr-1"></i>AKAN DATANG
                </span>
            @endif
        </div>

        <!-- Organizer Badge -->
        <div class="absolute bottom-2 left-2 bg-black bg-opacity-60 text-white px-2 py-1 rounded-full text-xs truncate max-w-[180px]">
            <i class="fas fa-user mr-1"></i>{{ $event->organizer->name }}
        </div>
        
        <!-- Sold Out Overlay -->
        @if(!$event->hasAvailableTickets() && $event->isUpcoming())
            <div class="absolute inset-0 bg-red-500 bg-opacity-90 flex items-center justify-center">
                <div class="text-white text-center">
                    <i class="fas fa-ticket-alt text-2xl mb-1"></i>
                    <div class="font-bold text-sm">HABIS</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Event Content - FLEX GROW -->
    <div class="p-5 flex flex-col flex-1">
        <!-- Category - FIXED HEIGHT -->
        <div class="mb-3 h-7 flex items-center">
            @if($event->category)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#e692b7]/10 text-[#262363] border border-[#e692b7]/20">
                    <i class="{{ $event->category->icon }} mr-1"></i>
                    {{ $event->category->name }}
                </span>
            @endif
        </div>

  <!-- Popularity Badge - FIXED HEIGHT -->
  <div class="mb-2 h-7 flex items-center">
    @if($event->successful_bookings_count > 0)
        @if($event->isUpcoming())
        
        {{-- Acara AKAN DATANG --}}
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
            <i class="fas fa-fire mr-1"></i>
            {{ $event->successful_bookings_count }} Tiket Terjual
        </span>
        @elseif($event->isPast())

        {{-- Acara SUDAH LEWAT --}}
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
            <i class="fas fa-users mr-1"></i>
            {{ $event->successful_bookings_count }} Peserta
        </span>
        @endif
        @endif
    </div>

        <!-- Event Name - FIXED 2 LINES -->
        <h3 class="font-bold text-xl text-gray-800 mb-3 line-clamp-2 h-14 hover:text-[#262363] transition-colors">
            <a href="{{ route('events.show', $event)}}">
                {{ $event->name }}
            </a>
        </h3>

        <!-- Event Date & Location - FIXED HEIGHT -->
        <div class="space-y-3 mb-4 flex-shrink-0">
            <div class="flex items-start text-gray-600">
                <div class="w-5 h-5 flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                    <i class="fas fa-calendar-day text-[#e6527b] text-sm"></i>
                </div>
                <div>
                    <div class="text-sm font-medium">{{ $event->event_date->translatedFormat('d M Y') }}</div>
                    <div class="text-xs text-gray-500">{{ $event->event_date->format('H:i') }}</div>
                </div>
            </div>
            
            <div class="flex items-start text-gray-600">
                <div class="w-5 h-5 flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                    <i class="fas fa-map-marker-alt text-[#e6527b] text-sm"></i>
                </div>
                <div class="text-sm font-medium line-clamp-1">{{ $event->location }}</div>
            </div>
        </div>

        <!-- Rating - FIXED HEIGHT -->
        <div class="mb-4 h-16 flex items-center flex-shrink-0">
            @if($event->total_reviews > 0)
                <div class="flex items-center w-full p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                    <div class="flex items-center mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($event->average_rating))
                                <i class="fas fa-star text-yellow-400 text-sm"></i>
                            @elseif($i == ceil($event->average_rating) && ($event->average_rating - floor($event->average_rating)) >= 0.5)
                                <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                            @else
                                <i class="far fa-star text-gray-300 text-sm"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-gray-700 font-medium">
                        {{ number_format($event->average_rating, 1) }} • {{ $event->total_reviews }} ulasan
                    </span>
                </div>
            @else
                <div class="text-sm text-gray-500 font-medium">
                    <i class="far fa-star mr-1 text-gray-400"></i> Belum ada ulasan
                </div>
            @endif
        </div>

        <!-- SPACER - Push buttons to bottom -->
        <div class="flex-1"></div>

        <!-- Price & Availability - FIXED HEIGHT -->
        <div class="flex justify-between items-center mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200 flex-shrink-0">
            <div>
                <div class="text-xs text-gray-500 font-medium">MULAI DARI</div>
                <div class="font-bold text-[#262363] text-xl">
                    Rp{{ number_format($event->sorted_price ?? $event->cheapest_price, 0, ',', '.') }}</div>
            </div>
            <div class="text-right">
                <div class="text-sm font-semibold {{ $event->hasAvailableTickets() ? 'text-green-600' : 'text-red-600' }}">
                    @if($event->hasAvailableTickets())
                        {{ $event->total_available_tickets }} tersisa
                    @else
                        Habis
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons - ALWAYS AT BOTTOM -->
        <div class="flex space-x-3 flex-shrink-0">
            <a href="{{ route('events.show', $event) }}" 
               class="flex-1 bg-gray-100 text-gray-700 hover:bg-gray-200 text-center py-3 px-4 rounded-xl font-semibold transition-colors flex items-center justify-center">
                <i class="fas fa-eye mr-2"></i>Detail
            </a>
            
            @if($event->isPublished() && $event->hasAvailableTickets() && $event->isUpcoming())
                <a href="{{ route('events.show', $event) }}#booking" 
                   class="flex-1 bg-[#e6527b] text-white hover:bg-[rgb(226,61,108)] text-center py-3 px-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt mr-2"></i>Pesan
                </a>
            @elseif($event->isPast())
                <button class="flex-1 bg-gray-300 text-gray-500 text-center py-3 px-4 rounded-xl font-semibold cursor-not-allowed flex items-center justify-center">
                    <i class="fas fa-history mr-2"></i>Selesai
                </button>
            @endif
        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
}
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}
</style>