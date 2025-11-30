{{-- resources/views/user/reviews/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Review - ' . $review->event->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#262363] to-[#00183c] px-6 py-4">
                <h2 class="text-xl font-bold text-white">Edit Review</h2>
                <p class="text-blue-100 text-sm">Perbarui review Anda untuk: {{ $review->event->name }}</p>
            </div>

            <!-- Review Form -->
            <form action="{{ route('user.reviews.update', $review) }}" method="POST" class="p-6">
                @csrf
                @method('PATCH')

                <!-- Event Info -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="font-semibold text-gray-800 mb-2">Detail Acara</h3>
                    <p class="text-gray-600">{{ $review->event->name }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $review->event->event_date->format('j F Y') }} • {{ $review->event->location }}
                    </p>
                </div>

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Rating Anda <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="flex space-x-1" id="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" data-rating="{{ $i }}" 
                                    class="p-1 transition-all duration-200 hover:scale-110">
                                <i class="far fa-star text-2xl text-gray-300"></i>
                            </button>
                        @endfor
                    </div>
                    
                    <input type="hidden" name="rating" id="rating-value" value="{{ old('rating', $review->rating) }}" required>
                    
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                        Review Anda (Opsional)
                    </label>
                    <textarea name="comment" id="comment" rows="6"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none"
                              placeholder="Bagikan pengalaman Anda dengan acara ini...">{{ old('comment', $review->comment) }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <div>
                        <button type="button" 
                                onclick="confirmDelete()"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-colors text-sm">
                            <i class="fas fa-trash mr-2"></i>Hapus Review
                        </button>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('events.show', $review->event) }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                        class="px-6 py-3 bg-[#262363] text-white rounded-lg hover:bg-[#00183c] font-medium transition-colors shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>Perbarui Review
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Form -->
<form id="delete-form" action="{{ route('user.reviews.destroy', $review) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    // Rating stars interaction
    document.addEventListener('DOMContentLoaded', function() {
        const ratingStars = document.querySelectorAll('#rating-stars button');
        const ratingValue = document.getElementById('rating-value');
        
        // Set initial rating from existing review
        updateStars(parseInt(ratingValue.value));
        
        ratingStars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingValue.value = rating;
                updateStars(rating);
            });
            
            star.addEventListener('mouseover', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                updateStars(rating, true);
            });
            
            star.addEventListener('mouseout', function() {
                const currentRating = parseInt(ratingValue.value);
                updateStars(currentRating);
            });
        });
        
        function updateStars(rating, isHover = false) {
            ratingStars.forEach((star, index) => {
                const starIcon = star.querySelector('i');
                if (index < rating) {
                    starIcon.className = 'fas fa-star text-2xl text-yellow-400';
                } else {
                    starIcon.className = 'far fa-star text-2xl text-gray-300';
                }
                
                // Add hover effect
                if (isHover && index < rating) {
                    starIcon.className = 'fas fa-star text-2xl text-yellow-300';
                }
            });
        }
    });

    // Delete confirmation
    function confirmDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus review ini? Tindakan ini tidak dapat dibatalkan.')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endpush
@endsection