<?php
// app/Http/Controllers/Organizer/BookingController.php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display bookings for organizer's events.
     */
    public function index(Request $request)
    {
        $organizer = auth()->user();
        
        $query = Booking::with(['user', 'ticket.event'])
            ->whereHas('ticket.event', function ($q) use ($organizer) {
                $q->where('organizer_id', $organizer->id);
            });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by event
        if ($request->filled('event')) {
            $query->whereHas('ticket', function ($q) use ($request) {
                $q->where('event_id', $request->event);
            });
        }

        // Search by booking code or user name
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('booking_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $bookings = $query->latest()->paginate(15);

        // Get organizer's events for filter
        $events = $organizer->events()->where('status', 'published')->get();

        // Count by status
        $pendingCount = Booking::whereHas('ticket.event', function ($q) use ($organizer) {
            $q->where('organizer_id', $organizer->id);
        })->where('status', 'pending')->count();
        
        $approvedCount = Booking::whereHas('ticket.event', function ($q) use ($organizer) {
            $q->where('organizer_id', $organizer->id);
        })->where('status', 'approved')->count();
        
        $cancelledCount = Booking::whereHas('ticket.event', function ($q) use ($organizer) {
            $q->where('organizer_id', $organizer->id);
        })->where('status', 'cancelled')->count();

        return view('organizer.bookings.index', compact(
            'bookings',
            'events',
            'pendingCount',
            'approvedCount',
            'cancelledCount'
        ));
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        // Authorization: hanya bisa lihat booking untuk event sendiri
        if ($booking->ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $booking->load(['user', 'ticket.event']);

        return view('organizer.bookings.show', compact('booking'));
    }

    /**
     * Approve a booking.
     */
    public function approve(Booking $booking)
    {
        // Authorization: hanya bisa approve booking untuk event sendiri
        if ($booking->ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if already approved
        if ($booking->status === 'approved') {
            return back()->with('info', 'Booking is already approved.');
        }

        // Check if booking is cancelled
        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Cannot approve a cancelled booking.');
        }

        // Approve booking
        $booking->update([
            'status' => 'approved'
        ]);

        // TODO: Send email to user with digital ticket (optional)
        // Mail::to($booking->user->email)->send(new BookingApproved($booking));

        return back()->with('success', "Booking #{$booking->booking_code} has been approved.");
    }

    /**
     * Reject a booking.
     */
    public function reject(Booking $booking)
    {
        // Authorization: hanya bisa reject booking untuk event sendiri
        if ($booking->ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if already rejected
        if ($booking->status === 'rejected') {
            return back()->with('info', 'Booking is already rejected.');
        }

        // Check if booking is cancelled
        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Cannot reject a cancelled booking.');
        }

        // Reject booking
        $booking->update([
            'status' => 'rejected'
        ]);

        // Kembalikan quota tiket
        $booking->ticket->increment('quota_remaining', $booking->quantity);

        // TODO: Send email to user (optional)
        // Mail::to($booking->user->email)->send(new BookingRejected($booking));

        return back()->with('success', "Booking #{$booking->booking_code} has been rejected. Ticket quota has been restored.");
    }
}