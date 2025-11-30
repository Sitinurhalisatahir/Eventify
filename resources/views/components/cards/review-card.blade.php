{{-- resources/views/components/cards/review-card.blade.php --}}
<div class="bg-white rounded-2xl shadow-lg border-0 p-5 hover:shadow-xl transition-all duration-300">
    <!-- Review Header -->
    <div class="flex justify-between items-start mb-4">
        <div class="flex items-center">
            @if($review->user->photo)
                <img src="{{ Storage::url($review->user->photo) }}" 
                     alt="{{ $review->user->name }}" 
                     class="w-10 h-10 rounded-full object-cover mr-3">
            @else
                <div class="w-10 h-10 bg-gradient-to-r from-[#00A3FF] to-[#8A2BE2] rounded-full flex items-center justify-center text-white font-semibold mr-3">
                    {{ substr($review->user->name, 0, 1) }}
                </div>
            @endif
            <div>
                <h5 class="font-semibold text-gray-800">{{ $review->user->name }}</h5>
                <div class="flex items-center text-sm text-gray-500 font-medium">
                    <span>{{ $review->created_at->format('M j, Y') }}</span>
                    <span class="mx-2">•</span>
                    <span class="flex items-center">
                        {!! $review->star_rating !!}
                    </span>
                </div>
            </div>
        </div>
        
        @if($review->booking)
            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                Verified
            </span>
        @endif
    </div>

    <!-- Review Comment -->
    <div class="text-gray-700 mb-4 text-sm leading-relaxed">
        {{ $review->comment }}
    </div>

    <!-- Event Info -->
    <div class="border-t border-gray-100 pt-3">
        <p class="text-sm text-gray-600 font-medium">
            For event: 
            <a href="{{ route('events.show', $review->event) }}" class="text-[#00A3FF] hover:text-[#0085CC] font-semibold">
                {{ $review->event->name }}
            </a>
        </p>
    </div>
</div>