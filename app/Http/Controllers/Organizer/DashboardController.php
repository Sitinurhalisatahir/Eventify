<?php
// app/Http/Controllers/Organizer/DashboardController.php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display organizer dashboard.
     */
    public function index()
    {
        $organizer = auth()->user();

        // Total Statistics (hanya event sendiri)
        $totalEvents = $organizer->events()->count();
        $publishedEvents = $organizer->events()->where('status', 'published')->count();
        $draftEvents = $organizer->events()->where('status', 'draft')->count();
        
        // Total Bookings for organizer's events
        $totalBookings = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })->count();
        
        // Revenue Statistics
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
        
        // Pending Bookings (yang perlu di-approve)
        $pendingBookings = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->where('status', 'pending')
        ->count();
        
        // Recent Bookings (5 terbaru)
        $recentBookings = Booking::with(['user', 'ticket.event'])
            ->whereHas('ticket.event', function ($query) use ($organizer) {
                $query->where('organizer_id', $organizer->id);
            })
            ->latest()
            ->take(5)
            ->get();
        
        // My Popular Events (by booking count)
        $popularEvents = $organizer->events()
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();
        
        // Booking Status Distribution
        $bookingsByStatus = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get()
        ->pluck('total', 'status');
        
        // Monthly Booking Chart Data (last 6 months)
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

        // Upcoming Events
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