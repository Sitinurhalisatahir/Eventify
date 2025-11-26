<?php
// app/Http/Controllers/Admin/BookingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'ticket.event']);

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

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $bookings = $query->latest()->paginate(15);

        // Get events for filter
        $events = Event::where('status', 'published')->get();

        // Count by status
        $pendingCount = Booking::where('status', 'pending')->count();
        $approvedCount = Booking::where('status', 'approved')->count();
        $cancelledCount = Booking::where('status', 'cancelled')->count();
        $rejectedCount = Booking::where('status', 'rejected')->count();

        return view('admin.bookings.index', compact(
            'bookings',
            'events',
            'pendingCount',
            'approvedCount',
            'cancelledCount',
            'rejectedCount'
        ));
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'ticket.event.organizer']);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Approve a booking.
     */
    public function approve(Booking $booking)
    {
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