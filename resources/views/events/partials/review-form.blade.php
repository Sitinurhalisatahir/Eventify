{{-- Review Form Partial --}}
@if($canReview && $userBooking)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Write a Review</h3>
        <form action="{{ route('user.reviews.store', $event) }}" method="POST">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $userBooking->id }}">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                <div class="flex space-x-1" id="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none" data-rating="{{ $i }}">
                            <i class="far fa-star"></i>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-value" value="0" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Comment</label>
                <textarea name="comment" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#00A3FF] focus:ring-2 focus:ring-[#00A3FF] transition-all duration-300 outline-none" placeholder="Share your experience..." required></textarea>
            </div>

            <button type="submit" class="bg-gradient-to-r from-[#00A3FF] to-[#8A2BE2] text-white px-6 py-3 rounded-lg hover:from-[#0095E6] hover:to-[#7B1FA2] font-semibold transition-all duration-300">
                Submit Review
            </button>
        </form>
    </div>
@endif