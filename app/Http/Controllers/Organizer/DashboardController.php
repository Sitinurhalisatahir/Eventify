<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $organizer = auth()->user();

        $totalEvents = $organizer->events()->count();
        $publishedEvents = $organizer->events()->where('status', 'published')->count();
        $draftEvents = $organizer->events()->where('status', 'draft')->count();
        
        $totalBookings = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })->count();
        
        $totalRevenue = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->where('status', 'approved')
        ->sum('total_price');
        
        $monthlyRevenue = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->where('status', 'approved')
        ->whereMonth('created_at', now()->month)
        ->sum('total_price');
        
        $pendingBookings = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->where('status', 'pending')
        ->count();
        
        $recentBookings = Booking::with(['user', 'ticket.event'])
            ->whereHas('ticket.event', function ($query) use ($organizer) {
                $query->where('organizer_id', $organizer->id);
            })
            ->latest()
            ->take(5)
            ->get();
        
        $popularEvents = $organizer->events()
         ->with(['tickets.bookings']) 
         ->get()
         ->map(function ($event) {
            $event->bookings_count = $event->tickets->sum(function ($ticket) {
                return $ticket->bookings->count();
            });
            return $event;
        })
        ->sortByDesc('bookings_count')
        ->take(5);

        $bookingsByStatus = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get()
        ->pluck('total', 'status');
        
        $monthlyBookings = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('count(*) as total')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        $upcomingEvents = $organizer->events()
            ->where('status', 'published')
            ->where('event_date', '>', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        return view('organizer.dashboard', compact(
            'totalEvents',
            'publishedEvents',
            'draftEvents',
            'totalBookings',
            'pendingBookings',
            'totalRevenue',
            'monthlyRevenue',
            'recentBookings',
            'popularEvents',
            'bookingsByStatus',
            'monthlyBookings',
            'upcomingEvents'
        ));
    }
}