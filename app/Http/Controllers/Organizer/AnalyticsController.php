<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Disable strict mode
        config(['database.connections.mysql.strict' => false]);
        \DB::reconnect();

        $organizerId = auth()->id();

        // Get period from request with default
        $period = $request->get('period', '12months');
        
        $monthsBack = match($period) {
            '3months' => 3,
            '6months' => 6,
            default => 12,
        };

        // Monthly Revenue Trend
        $monthlyRevenueTrend = Booking::select(
                DB::raw('YEAR(bookings.created_at) as year'),
                DB::raw('MONTH(bookings.created_at) as month'),
                DB::raw('SUM(bookings.total_price) as revenue')
            )
            ->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
            ->join('events', 'tickets.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->where('bookings.status', 'approved')
            ->where('bookings.created_at', '>=', now()->subMonths($monthsBack))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'revenue' => $item->revenue ?? 0
                ];
            });

        // Revenue Growth Rate
        $currentMonthRevenue = Booking::join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
            ->join('events', 'tickets.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->where('bookings.status', 'approved')
            ->whereMonth('bookings.created_at', now()->month)
            ->whereYear('bookings.created_at', now()->year)
            ->sum('bookings.total_price') ?? 0;

        $previousMonthRevenue = Booking::join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
            ->join('events', 'tickets.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->where('bookings.status', 'approved')
            ->whereMonth('bookings.created_at', now()->subMonth()->month)
            ->whereYear('bookings.created_at', now()->subMonth()->year)
            ->sum('bookings.total_price') ?? 0;

        $revenueGrowthRate = $previousMonthRevenue > 0 
            ? (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100 
            : 0;

        // Monthly Bookings Trend
        $monthlyBookingsTrend = Booking::select(
                DB::raw('YEAR(bookings.created_at) as year'),
                DB::raw('MONTH(bookings.created_at) as month'),
                DB::raw('COUNT(*) as bookings')
            )
            ->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
            ->join('events', 'tickets.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->where('bookings.created_at', '>=', now()->subMonths($monthsBack))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'bookings' => $item->bookings ?? 0
                ];
            });

        // Event Performance
        $eventPerformance = Event::where('organizer_id', $organizerId)
            ->where('status', 'published')
            ->withCount(['bookings' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($event) {
                $totalTickets = $event->tickets()->sum('quota');
                $soldTickets = $totalTickets - $event->tickets()->sum('quota_remaining');
                
                $revenue = Booking::join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
                    ->where('tickets.event_id', $event->id)
                    ->where('bookings.status', 'approved')
                    ->sum('bookings.total_price') ?? 0;
                
                return [
                    'event' => $event,
                    'total_tickets' => $totalTickets,
                    'sold_tickets' => $soldTickets,
                    'booking_rate' => $totalTickets > 0 ? ($soldTickets / $totalTickets) * 100 : 0,
                    'revenue' => $revenue,
                ];
            });

        // Booking Status Distribution
        $bookingStatusDistribution = Booking::select('bookings.status', DB::raw('count(*) as total'))
            ->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
            ->join('events', 'tickets.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->groupBy('bookings.status')
            ->get()
            ->pluck('total', 'status');

        // Key Metrics
        $totalRevenue = Booking::join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
            ->join('events', 'tickets.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->where('bookings.status', 'approved')
            ->sum('bookings.total_price') ?? 0;

        $totalBookings = Booking::join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
            ->join('events', 'tickets.event_id', '=', 'events.id')
            ->where('events.organizer_id', $organizerId)
            ->count();

        $avgBookingValue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;

        $totalEvents = Event::where('organizer_id', $organizerId)->count();
        $publishedEvents = Event::where('organizer_id', $organizerId)
            ->where('status', 'published')
            ->count();

        $keyMetrics = [
            'total_revenue' => $totalRevenue,
            'total_bookings' => $totalBookings,
            'avg_booking_value' => $avgBookingValue,
            'total_events' => $totalEvents,
            'published_events' => $publishedEvents,
            'revenue_growth_rate' => round($revenueGrowthRate, 2),
        ];

        // Re-enable strict mode
        config(['database.connections.mysql.strict' => true]);

        return view('organizer.analytics.index', compact(
            'period',
            'monthlyRevenueTrend',
            'monthlyBookingsTrend',
            'eventPerformance',
            'bookingStatusDistribution',
            'keyMetrics'
        ));
    }
}