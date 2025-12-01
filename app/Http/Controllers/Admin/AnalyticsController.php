<?php
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
        config(['database.connections.mysql.strict' => false]);
        \DB::reconnect();

        $period = $request->get('period', '12months');

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

        $organizerRevenue = User::where('role', 'organizer')
            ->where('organizer_status', 'approved')
            ->withCount(['events as events_count' => function($query) {
                $query->where('status', 'published');
            }])
            ->addSelect([
                'total_revenue' => Booking::select(DB::raw('COALESCE(SUM(total_price), 0)'))
                    ->where('status', 'approved')
                    ->whereIn('ticket_id', function($query) {
                        $query->select('id')
                            ->from('tickets')
                            ->whereIn('event_id', function($q) {
                                $q->select('id')
                                    ->from('events')
                                    ->whereColumn('organizer_id', 'users.id');
                            });
                    })
            ])
            ->having('total_revenue', '>', 0)
            ->orderBy('total_revenue', 'desc')
            ->get();

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

        $eventPerformance = Event::with(['organizer', 'tickets', 'reviews'])
            ->where('status', 'published')
            ->get()
            ->map(function ($event) {
                // Hitung total bookings untuk event ini
                $bookingsCount = Booking::whereHas('ticket', function ($query) use ($event) {
                    $query->where('event_id', $event->id);
                })->count();

                $totalTickets = $event->tickets->sum('quota');
                $soldTickets = $totalTickets - $event->tickets->sum('quota_remaining');
                
                $avgRating = $event->reviews->avg('rating') ?? 0;

                return [
                    'event' => $event,
                    'bookings_count' => $bookingsCount,
                    'booking_rate' => $totalTickets > 0 ? ($soldTickets / $totalTickets) * 100 : 0,
                    'avg_rating' => round($avgRating, 1),
                ];
            })
            ->sortByDesc('bookings_count')
            ->take(10);

        $categoryPerformance = Category::select('categories.*')
            ->withCount(['events' => function ($query) {
                $query->where('status', 'published');
            }])
            ->with(['events' => function ($query) {
                $query->addSelect(['bookings_count' => Booking::select(DB::raw('count(*)'))
                    ->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
                    ->whereColumn('tickets.event_id', 'events.id')
                ]);
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

        $bookingStatusDistribution = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');


        $avgBookingValue = Booking::where('status', 'approved')->avg('total_price');

        $keyMetrics = [
            'total_revenue' => Booking::where('status', 'approved')->sum('total_price'),
            'total_bookings' => Booking::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_events' => Event::where('status', 'published')->count(),
            'avg_booking_value' => $avgBookingValue,
            'revenue_growth_rate' => round($revenueGrowthRate, 2),
        ];

        config(['database.connections.mysql.strict' => true]);

        return view('admin.analytics.index', compact(
            'period',
            'monthlyRevenueTrend',
            'revenueGrowthRate',
            'userGrowthTrend',
            'eventPerformance',
            'categoryPerformance',
            'bookingStatusDistribution',
            'keyMetrics',
            'organizerRevenue'
        ));
    }
}