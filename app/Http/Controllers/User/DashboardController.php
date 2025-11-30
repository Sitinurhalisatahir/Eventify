<?php
// app/Http/Controllers/User/DashboardController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display user dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Total Statistics
        $totalBookings = $user->bookings()->count();
        $approvedBookings = $user->bookings()->where('status', 'approved')->count();
        $pendingBookings = $user->bookings()->where('status', 'pending')->count();
        $totalFavorites = $user->favorites()->count();
        
        // Total Spent
        $totalSpent = $user->bookings()
            ->where('status', 'approved')
            ->sum('total_price');
        
        // Recent Bookings (5 terbaru)
        $recentBookings = $user->bookings()
            ->with('ticket.event.category')
            ->latest()
            ->take(5)
            ->get();
        
        // Upcoming Events (dari booking yang approved)
        $upcomingEvents = $user->bookings()
            ->with('ticket.event')
            ->where('status', 'approved')
            ->whereHas('ticket.event', function ($query) {
                $query->where('event_date', '>', now());
            })
            ->latest()
            ->take(5)
            ->get()
            ->pluck('ticket.event')
            ->unique('id');
        
        // Past Events (untuk review)
        $pastEvents = $user->bookings()
            ->with('ticket.event')
            ->where('status', 'approved')
            ->whereHas('ticket.event', function ($query) {
                $query->where('event_date', '<', now());
            })
            ->latest()
            ->take(5)
            ->get()
            ->pluck('ticket.event')
            ->unique('id');
        
        // Favorite Events
        $favoriteEvents = $user->favorites()
            ->with('event.category')
            ->latest()
            ->take(6)
            ->get()
            ->pluck('event');

        return view('user.dashboard', compact(
            'totalBookings',
            'approvedBookings',
            'pendingBookings',
            'totalFavorites',
            'totalSpent',
            'recentBookings',
            'upcomingEvents',
            'pastEvents',
            'favoriteEvents'
        ));
    }
}