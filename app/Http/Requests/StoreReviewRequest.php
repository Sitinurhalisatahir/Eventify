<?php
// app/Http/Requests/StoreReviewRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Booking;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'booking_id.required' => 'Booking is required.',
            'booking_id.exists' => 'Selected booking does not exist.',
            'rating.required' => 'Rating is required.',
            'rating.integer' => 'Rating must be a number.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating must not exceed 5 stars.',
            'comment.max' => 'Comment must not exceed 1000 characters.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $booking = Booking::find($this->booking_id);

            if ($booking) {
                // Check if booking belongs to authenticated user
                if ($booking->user_id !== auth()->id()) {
                    $validator->errors()->add(
                        'booking_id',
                        'You can only review your own bookings.'
                    );
                }

                // Check if booking is approved
                if ($booking->status !== 'approved') {
                    $validator->errors()->add(
                        'booking_id',
                        'You can only review approved bookings.'
                    );
                }

                // Check if event has passed
                if ($booking->ticket->event->event_date->isFuture()) {
                    $validator->errors()->add(
                        'booking_id',
                        'You can only review after the event has ended.'
                    );
                }

                // Check if already reviewed (when creating)
                if ($this->isMethod('POST')) {
                    if ($booking->reviews()->where('user_id', auth()->id())->exists()) {
                        $validator->errors()->add(
                            'booking_id',
                            'You have already reviewed this event.'
                        );
                    }
                }
            }
        });
    }
}