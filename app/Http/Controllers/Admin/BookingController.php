<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'ticket.event']);

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

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $bookings = $query->latest()->paginate(15);

        $events = Event::where('status', 'published')->get();

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

    public function show(Booking $booking)
    {
        $booking->load(['user', 'ticket.event.organizer']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function approve(Booking $booking)
    {
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