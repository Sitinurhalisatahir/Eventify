<?php
// app/Http/Requests/StoreBookingRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Ticket;

class StoreBookingRequest extends FormRequest
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
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'ticket_id.required' => 'Please select a ticket.',
            'ticket_id.exists' => 'Selected ticket does not exist.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a valid number.',
            'quantity.min' => 'Quantity must be at least 1.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $ticket = Ticket::find($this->ticket_id);

            if ($ticket) {
                if ($ticket->quota_remaining < $this->quantity) {
                    $validator->errors()->add(
                        'quantity',
                        "Only {$ticket->quota_remaining} tickets available."
                    );
                }

                if ($ticket->quota_remaining <= 0) {
                    $validator->errors()->add(
                        'ticket_id',
                        'This ticket is sold out.'
                    );
                }
            }
        });
    }
}