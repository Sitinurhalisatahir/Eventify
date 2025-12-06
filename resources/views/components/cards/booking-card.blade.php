{{-- resources/views/components/cards/booking-card.blade.php --}}
<div class="bg-white rounded-2xl shadow-lg border-0 p-5 hover:shadow-xl transition-all duration-300">
    <!-- Booking Header -->
    <div class="flex justify-between items-start mb-4">
        <div>
            <h4 class="font-bold text-gray-800 text-lg">BOOKING #{{ $booking->booking_code }}</h4>
            <p class="text-sm text-gray-500 font-medium">Placed on {{ $booking->created_at->format('M j, Y') }}</p>
        </div>
        
        <!-- Status Badge -->
        @if($booking->isPending())
            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                PENDING
            </span>
        @elseif($booking->isApproved())
            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                APPROVED
            </span>
        @elseif($booking->isCancelled())
            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                CANCELLED
            </span>
        @elseif($booking->isRejected())
            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                REJECTED
            </span>
        @endif
    </div>

    <!-- Event Info -->
    <div class="border-t border-gray-100 pt-4 mb-4">
        <h5 class="font-semibold text-gray-800 mb-3 text-lg">{{ $booking->ticket->event->name }}</h5>
        <div class="grid grid-cols-1 gap-3 text-sm text-gray-600">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-[#00A3FF] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-calendar-day text-[#00A3FF] text-sm"></i>
                </div>
                <span class="font-medium">{{ $booking->ticket->event->event_date->format('M j, Y | H:i') }}</span>
            </div>
            <div class="flex items-center">
                <div class="w-8 h-8 bg-[#8A2BE2] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-map-marker-alt text-[#8A2BE2] text-sm"></i>
                </div>
                <span class="font-medium truncate">{{ $booking->ticket->event->location }}</span>
            </div>
        </div>
    </div>

    <!-- Ticket Info -->
    <div class="bg-gradient-to-r from-[#00A3FF] to-[#8A2BE2] bg-opacity-5 rounded-xl p-4 mb-5 border border-[#00A3FF] border-opacity-20">
        <div class="flex justify-between items-center">
            <div>
                <div class="font-semibold text-gray-800">{{ $booking->ticket->name }}</div>
                <div class="text-sm text-gray-600 font-medium">Quantity: {{ $booking->quantity }}</div>
            </div>
            <div class="text-right">
                <div class="font-bold text-[#00A3FF] text-lg"> Rp{{ number_format($booking->total_price, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex space-x-3">
        <a href="{{ route('user.bookings.show', $booking) }}" 
           class="flex-1 bg-gray-100 text-gray-700 hover:bg-gray-200 text-center py-3 px-4 rounded-xl font-semibold transition-colors text-sm">
            View Details
        </a>
        
        @if($booking->canBeCancelled())
            <form action="{{ route('user.bookings.cancel', $booking) }}" method="POST" class="flex-1">
                @csrf
                @method('PUT')
                <button type="submit" 
                        class="w-full bg-red-500 text-white hover:bg-red-600 text-center py-3 px-4 rounded-xl font-semibold transition-colors text-sm"
                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                    Cancel
                </button>
            </form>
        @endif

        @if($booking->canBeReviewed())
            <a href="{{ route('user.reviews.create', $booking) }}" 
               class="flex-1 bg-green-500 text-white hover:bg-green-600 text-center py-3 px-4 rounded-xl font-semibold transition-colors text-sm">
                Write Review
            </a>
        @endif
    </div>
</div>