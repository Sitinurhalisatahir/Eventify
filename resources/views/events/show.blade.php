@extends('layouts.app')

@section('title', $event->name . ' - ' . config('app.name', 'Eventify'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Event Hero Section -->
    @include('events.partials.event-hero')

    <!-- Event Details Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Event Description -->
                @include('events.partials.event-description')

                <!-- Event Details -->
                @include('events.partials.event-details')

                <!-- Tickets Section -->
                @include('events.partials.ticket-list')

                <!-- Reviews Section -->
                @include('events.partials.review-list')

                <!-- Review Form -->
                @include('events.partials.review-form')
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Organizer Info -->
                @include('events.partials.organizer-info')

                <!-- Similar Events -->
                @include('events.partials.similar-events')
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Rating stars interaction
    document.addEventListener('DOMContentLoaded', function() {
        const ratingStars = document.querySelectorAll('#rating-stars button');
        const ratingValue = document.getElementById('rating-value');
        
        if (ratingStars.length > 0) {
            ratingStars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    ratingValue.value = rating;
                    
                    // Update stars display
                    ratingStars.forEach((s, index) => {
                        const starIcon = s.querySelector('i');
                        if (index < rating) {
                            starIcon.className = 'fas fa-star text-yellow-400';
                        } else {
                            starIcon.className = 'far fa-star text-gray-300';
                        }
                    });
                });
                
                star.addEventListener('mouseover', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    ratingStars.forEach((s, index) => {
                        const starIcon = s.querySelector('i');
                        if (index < rating) {
                            starIcon.className = 'fas fa-star text-yellow-300';
                        }
                    });
                });
                
                star.addEventListener('mouseout', function() {
                    const currentRating = parseInt(ratingValue.value);
                    ratingStars.forEach((s, index) => {
                        const starIcon = s.querySelector('i');
                        if (index < currentRating) {
                            starIcon.className = 'fas fa-star text-yellow-400';
                        } else {
                            starIcon.className = 'far fa-star text-gray-300';
                        }
                    });
                });
            });
        }
    });
</script>
@endpush
@endsection