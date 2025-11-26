<?php
// app/Http/Controllers/Organizer/AnalyticsController.php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display analytics for organizer's events.
     */
    public function index(Request $request)
    {
        $organizer = auth()->user();

        // ========== REVENUE ANALYTICS ==========
        
        // Monthly Revenue Trend (last 12 months)
        $monthlyRevenueTrend = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('sum(total_price) as revenue')
        )
        ->where('status', 'approved')
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get()
        ->map(function ($item) {
            return [
                'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                'revenue' => $item->revenue
            ];
        });

        // Revenue Growth Rate
        $currentMonthRevenue = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->where('status', 'approved')
        ->whereMonth('created_at', now()->month)
        ->sum('total_price');

        $previousMonthRevenue = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->where('status', 'approved')
        ->whereMonth('created_at', now()->subMonth()->month)
        ->sum('total_price');

        $revenueGrowthRate = $previousMonthRevenue > 0 
            ? (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100 
            : 0;

        // ========== EVENT PERFORMANCE ==========
        
        // Event Performance (booking rate, revenue)
        $eventPerformance = $organizer->events()
            ->with('tickets')
            ->withCount('bookings')
            ->get()
            ->map(function ($event) {
                $totalTickets = $event->tickets->sum('quota');
                $soldTickets = $totalTickets - $event->tickets->sum('quota_remaining');
                $revenue = $event->bookings()->where('status', 'approved')->sum('total_price');
                
                return [
                    'event' => $event,
                    'booking_rate' => $totalTickets > 0 ? ($soldTickets / $totalTickets) * 100 : 0,
                    'sold_tickets' => $soldTickets,
                    'total_tickets' => $totalTickets,
                    'revenue' => $revenue,
                ];
            })
            ->sortByDesc('revenue');

        // ========== BOOKING ANALYTICS ==========
        
        // Booking Status Distribution
        $bookingStatusDistribution = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get()
        ->pluck('total', 'status');

        // Average Booking Value
        $avgBookingValue = Booking::whereHas('ticket.event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })
        ->where('status', 'approved')
        ->avg('total_price');

        // ========== KEY METRICS ==========
        
        $keyMetrics = [
            'total_revenue' => Booking::whereHas('ticket.event', function ($query) use ($organizer) {
                $query->where('organizer_id', $organizer->id);
            })->where('status', 'approved')->sum('total_price'),
            
            'total_bookings' => Booking::whereHas('ticket.event', function ($query) use ($organizer) {
                $query->where('organizer_id', $organizer->id);
            })->count(),
            
            'total_events' => $organizer->events()->count(),
            'published_events' => $organizer->events()->where('status', 'published')->count(),
            'avg_booking_value' => $avgBookingValue,
            'revenue_growth_rate' => round($revenueGrowthRate, 2),
        ];

        return view('organizer.analytics.index', compact(
            'monthlyRevenueTrend',
            'revenueGrowthRate',
            'eventPerformance',
            'bookingStatusDistribution',
            'keyMetrics'
        ));
    }
}