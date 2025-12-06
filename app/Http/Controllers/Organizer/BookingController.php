<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $organizer = auth()->user();
        
        $query = Booking::with(['user', 'ticket.event'])
            ->whereHas('ticket.event', function ($q) use ($organizer) {
                $q->where('organizer_id', $organizer->id);
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('event')) {
            $query->whereHas('ticket', function ($q) use ($request) {
                $q->where('event_id', $request->event);
            });
        }

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

        $events = $organizer->events()->where('status', 'published')->get();

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

    public function show(Booking $booking)
    {
        if ($booking->ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $booking->load(['user', 'ticket.event']);

        return view('organizer.bookings.show', compact('booking'));
    }

    public function approve(Booking $booking)
    {
        if ($booking->ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->status === 'approved') {
            return back()->with('info', 'Booking is already approved.');
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Cannot approve a cancelled booking.');
        }

        $booking->update([
            'status' => 'approved'
        ]);

    
        return back()->with('success', "Booking #{$booking->booking_code} has been approved.");
    }

    public function reject(Booking $booking)
    {
        if ($booking->ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->status === 'rejected') {
            return back()->with('info', 'Booking is already rejected.');
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Cannot reject a cancelled booking.');
        }

        $booking->update([
            'status' => 'rejected'
        ]);

        $booking->ticket->increment('quota_remaining', $booking->quantity);

        return back()->with('success', "Booking #{$booking->booking_code} has been rejected. Ticket quota has been restored.");
    }
}