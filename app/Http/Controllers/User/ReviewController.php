<?php
// app/Http/Controllers/User/ReviewController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Event;
use App\Models\Review;
use App\Models\Booking; 
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function create(Event $event, Booking $booking)
    {

        
        // Authorization: hanya bisa review booking sendiri
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if booking can be reviewed
        if (!$booking->canBeReviewed()) {
            return redirect()
                ->route('user.bookings.show', $booking)
                ->with('error', 'This booking cannot be reviewed.');
        }

        return view('user.reviews.create', compact('event', 'booking'));
    }
    /**
     * Store a newly created review.
     */
    public function store(StoreReviewRequest $request, Event $event)
    {
        $data = $request->validated();
        
        // Create review
        Review::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'booking_id' => $data['booking_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        return redirect()
            ->route('events.show', $event->id)
            ->with('success', 'Review submitted successfully. Thank you for your feedback!');
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        // Authorization: hanya bisa edit review sendiri
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $review->load('event');

        return view('user.reviews.edit', compact('review'));
    }

    /**
     * Update the specified review.
     */
    public function update(StoreReviewRequest $request, Review $review)
    {
        // Authorization: hanya bisa update review sendiri
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $data = $request->validated();

        $review->update([
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        return redirect()
            ->route('events.show', $review->event_id)
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        // Authorization: hanya bisa delete review sendiri
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $eventId = $review->event_id;
        $review->delete();

        return redirect()
            ->route('events.show', $eventId)
            ->with('success', 'Review deleted successfully.');
    }
}
