<?php
// app/Http/Controllers/User/BookingController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display user's booking history.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->bookings()->with('ticket.event.category');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by booking code or event name
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('booking_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('ticket.event', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $bookings = $query->latest()->paginate(10);

        // Count by status
        $pendingCount = $user->bookings()->where('status', 'pending')->count();
        $approvedCount = $user->bookings()->where('status', 'approved')->count();
        $cancelledCount = $user->bookings()->where('status', 'cancelled')->count();

        return view('user.bookings.index', compact(
            'bookings',
            'pendingCount',
            'approvedCount',
            'cancelledCount'
        ));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request)
    {
        // Get ticket from query parameter
        $ticketId = $request->get('ticket_id');
        
        if (!$ticketId) {
            return redirect()->route('events.index')
                ->with('error', 'Please select a ticket first.');
        }

        $ticket = Ticket::with('event')->findOrFail($ticketId);

        // Check if ticket is available
        if ($ticket->quota_remaining <= 0) {
            return redirect()->route('events.show', $ticket->event->id)
                ->with('error', 'This ticket is sold out.');
        }

        return view('user.bookings.create', compact('ticket'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();
        $ticket = Ticket::findOrFail($data['ticket_id']);

        // Double check quota
        if ($ticket->quota_remaining < $data['quantity']) {
            return back()->with('error', "Only {$ticket->quota_remaining} tickets available.");
        }

        // Calculate total price
        $totalPrice = $ticket->price * $data['quantity'];

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'ticket_id' => $data['ticket_id'],
            'booking_code' => strtoupper(Str::random(10)),
            'quantity' => $data['quantity'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Decrease ticket quota
        $ticket->decrement('quota_remaining', $data['quantity']);

        return redirect()
            ->route('user.bookings.show', $booking)
            ->with('success', 'Booking created successfully. Waiting for approval.');
    }

    /**
     * Display the specified booking (with digital ticket).
     */
    public function show(Booking $booking)
    {
        // Authorization: hanya bisa lihat booking sendiri
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $booking->load('ticket.event.organizer');

        // Check if can be cancelled
        $canCancel = $booking->canBeCancelled();

        // Check if can be reviewed
        $canReview = $booking->canBeReviewed();

        return view('user.bookings.show', compact('booking', 'canCancel', 'canReview'));
    }

    /**
     * Cancel the specified booking.
     */
    public function destroy(Booking $booking)
    {
        // Authorization: hanya bisa cancel booking sendiri
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if can be cancelled
        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        // Cancel booking
        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        // Kembalikan quota tiket
        $booking->ticket->increment('quota_remaining', $booking->quantity);

        return redirect()
            ->route('user.bookings.index')
            ->with('success', 'Booking cancelled successfully. Ticket quota has been restored.');
    }
}