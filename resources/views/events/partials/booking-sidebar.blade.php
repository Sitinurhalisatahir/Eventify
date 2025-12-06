{{-- Booking Sidebar Partial --}}
<div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 sticky top-4">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Pesan Tiket</h3>
    
    <!-- Price -->
    <div class="mb-4">
        <div class="text-sm text-gray-500">Mulai dari</div>
        <div class="text-3xl font-bold text-black-900">
            Rp{{ number_format($event->cheapest_price, 0, ',', '.') }}
        </div>
    </div>

    <!-- Availability -->
    <div class="mb-6">
        <div class="text-sm font-semibold {{ $event->hasAvailableTickets() ? 'text-green-600' : 'text-red-600' }} bg-gray-100 px-3 py-2 rounded-lg">
            <i class="fas fa-ticket-alt mr-2"></i>
            {{ $event->total_available_tickets }} tiket tersedia
        </div>
    </div>

    <!-- Book Now Button -->
    @if($event->isPublished() && $event->hasAvailableTickets() && $event->isUpcoming())
        @auth
            @if(auth()->user()->role === 'user')
                <a href="{{ route('user.bookings.create', ['ticket_id' => $event->tickets->first()->id]) }}" 
                   class="w-full bg-[#e6527b] text-white py-4 px-6 rounded-xl hover:bg-[#d9416d] font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl text-center block">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Pesan Tiket
                </a>
            @else
                <button disabled class="w-full bg-gray-300 text-gray-500 py-4 px-6 rounded-xl font-bold text-lg cursor-not-allowed">
                    Masuk sebagai Penggunauntuk Memesan
                </button>
            @endif
        @else
            <a href="{{ route('login') }}" 
               class="w-full bg-[#e6527b] text-white py-4 px-6 rounded-xl hover:bg-[#d9416d] font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl text-center block">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Masuk untuk Memesan
            </a>
        @endauth
    @else
        <button disabled class="w-full bg-gray-300 text-gray-500 py-4 px-6 rounded-xl font-bold text-lg cursor-not-allowed">
            {{ $event->isCancelled() ? 'Acara Dibatalkan' : ($event->isPast() ? 'Acara Selesai' : 'Habis') }}
        </button>
    @endif
</div>