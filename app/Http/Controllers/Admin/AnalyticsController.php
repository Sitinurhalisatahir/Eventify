<?php
// app/Http/Controllers/Admin/AnalyticsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard.
     */
    public function index(Request $request)
    {
        // Time period filter (default: last 12 months)
        $period = $request->get('period', '12months');

        // ========== REVENUE ANALYTICS ==========
        
        // Monthly Revenue Trend (last 12 months)
        $monthlyRevenueTrend = Booking::select(
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

        // Revenue Growth Rate (compare to previous month)
        $currentMonthRevenue = Booking::where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $previousMonthRevenue = Booking::where('status', 'approved')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_price');

        $revenueGrowthRate = $previousMonthRevenue > 0 
            ? (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100 
            : 0;

        // ========== USER ANALYTICS ==========
        
        // User Growth Trend (last 12 months)
        $userGrowthTrend = User::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as total')
            )
            ->where('role', 'user')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'users' => $item->total
                ];
            });

        // ========== EVENT ANALYTICS ==========
        
        // Event Performance (average rating, booking rate)
        $eventPerformance = Event::select('events.*')
            ->withCount('bookings')
            ->withAvg('reviews', 'rating')
            ->where('status', 'published')
            ->orderBy('bookings_count', 'desc')
            ->take(10)
            ->get()
            ->map(function ($event) {
                // Calculate total tickets
                $totalTickets = $event->tickets()->sum('quota');
                $soldTickets = $totalTickets - $event->tickets()->sum('quota_remaining');
                
                return [
                    'event' => $event,
                    'booking_rate' => $totalTickets > 0 ? ($soldTickets / $totalTickets) * 100 : 0,
                    'avg_rating' => round($event->reviews_avg_rating ?? 0, 1),
                ];
            });

        // ========== CATEGORY ANALYTICS ==========
        
        // Category Performance
        $categoryPerformance = Category::select('categories.*')
            ->withCount(['events' => function ($query) {
                $query->where('status', 'published');
            }])
            ->with(['events' => function ($query) {
                $query->withCount('bookings');
            }])
            ->having('events_count', '>', 0)
            ->get()
            ->map(function ($category) {
                $totalBookings = $category->events->sum('bookings_count');
                $totalRevenue = Booking::whereHas('ticket.event', function ($query) use ($category) {
                    $query->where('category_id', $category->id);
                })
                ->where('status', 'approved')
                ->sum('total_price');

                return [
                    'category' => $category,
                    'total_bookings' => $totalBookings,
                    'total_revenue' => $totalRevenue,
                ];
            })
            ->sortByDesc('total_revenue');

        // ========== BOOKING ANALYTICS ==========
        
        // Booking Status Distribution (Pie Chart)
        $bookingStatusDistribution = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Average Booking Value
        $avgBookingValue = Booking::where('status', 'approved')->avg('total_price');

        // ========== KEY METRICS ==========
        
        $keyMetrics = [
            'total_revenue' => Booking::where('status', 'approved')->sum('total_price'),
            'total_bookings' => Booking::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_events' => Event::where('status', 'published')->count(),
            'avg_booking_value' => $avgBookingValue,
            'revenue_growth_rate' => round($revenueGrowthRate, 2),
        ];

        return view('admin.analytics.index', compact(
            'period',
            'monthlyRevenueTrend',
            'revenueGrowthRate',
            'userGrowthTrend',
            'eventPerformance',
            'categoryPerformance',
            'bookingStatusDistribution',
            'keyMetrics'
        ));
    }
}