<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalOrganizers = User::where('role', 'organizer')
                                ->where('organizer_status', 'approved')
                                ->count();
        $totalEvents = Event::where('status', 'published')->count();
        $totalBookings = Booking::count();
        
        $pendingOrganizers = User::where('role', 'organizer')
                                  ->where('organizer_status', 'pending')
                                  ->count();
        
        $totalRevenue = Booking::where('status', 'approved')
                               ->sum('total_price');
        
        $monthlyRevenue = Booking::where('status', 'approved')
                                 ->whereMonth('created_at', now()->month)
                                 ->sum('total_price');
        
        // Recent Bookings
        $recentBookings = Booking::with(['user', 'ticket.event'])
                                 ->latest()
                                 ->take(5)
                                 ->get();
        
        
        $popularEvents = Event::select('events.*')
        ->addSelect(['bookings_count' => Booking::select(DB::raw('count(*)'))
        ->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
        ->whereColumn('tickets.event_id', 'events.id')
        ])
        ->orderBy('bookings_count', 'desc')
        ->take(5)
        ->get();

        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as total'))
                                   ->groupBy('status')
                                   ->get()
                                   ->pluck('total', 'status');

        $eventsByCategory = Category::withCount('events')
                                    ->having('events_count', '>', 0)
                                    ->get();
        
        $monthlyBookings = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrganizers',
            'totalEvents',
            'totalBookings',
            'pendingOrganizers',
            'totalRevenue',
            'monthlyRevenue',
            'recentBookings',
            'popularEvents',
            'bookingsByStatus',
            'eventsByCategory',
            'monthlyBookings'
        ));
    }
}