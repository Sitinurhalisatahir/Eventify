{{-- Review List Partial --}}
@if($event->reviews->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Reviews</h3>
            <div class="flex items-center space-x-2">
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($averageRating))
                            <i class="fas fa-star text-yellow-400"></i>
                        @elseif($i == ceil($averageRating) && ($averageRating - floor($averageRating)) >= 0.5)
                            <i class="fas fa-star-half-alt text-yellow-400"></i>
                        @else
                            <i class="far fa-star text-gray-300"></i>
                        @endif
                    @endfor
                </div>
                <span class="text-gray-600 font-semibold">{{ number_format($averageRating, 1) }} ({{ $totalReviews }} reviews)</span>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($event->reviews as $review)
                <div class="border-b border-gray-200 pb-4 last:border-b-0">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center space-x-3">
                            @if($review->user->photo)
                                <img src="{{ Storage::url($review->user->photo) }}" alt="{{ $review->user->name }}" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 bg-gradient-to-r from-[#00A3FF] to-[#8A2BE2] rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="font-semibold text-gray-900">{{ $review->user->name }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-700">{{ $review->comment }}</p>
                    <p class="text-gray-400 text-sm mt-2">{{ $review->created_at->format('M j, Y') }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endif