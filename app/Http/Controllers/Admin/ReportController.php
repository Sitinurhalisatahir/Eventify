<?php
// app/Http\Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display sales report.
     */
    public function index(Request $request)
    {
        // ✅ 1. DISABLE STRICT MODE DI AWAL - Fix GROUP BY issues
        config(['database.connections.mysql.strict' => false]);
        \DB::reconnect();

        // Date range filter (default: this month)
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // ========== REVENUE REPORTS ==========
        
        // Total Revenue (approved bookings only)
        $totalRevenue = Booking::where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');

        // Revenue by Status
        $revenueByStatus = Booking::select('status', DB::raw('sum(total_price) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Daily Revenue (for chart)
        $dailyRevenue = Booking::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('sum(total_price) as total')
            )
            ->where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // ========== BOOKING REPORTS ==========
        
        // Total Bookings
        $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->count();
        
        // Bookings by Status
        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // ========== TOP EVENTS ==========
        
        // ✅ 2. FIX: Top Events by Revenue - GROUP BY sudah handled oleh strict mode disable
        $topEventsByRevenue = Event::select('events.*', DB::raw('sum(bookings.total_price) as revenue'))
            ->join('tickets', 'events.id', '=', 'tickets.event_id')
            ->join('bookings', 'tickets.id', '=', 'bookings.ticket_id')
            ->where('bookings.status', 'approved')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('events.id')
            ->orderBy('revenue', 'desc')
            ->take(10)
            ->get();

        // ✅ 3. FIX: Top Events by Bookings - GANTI dengan query yang benar
        $topEventsByBookings = Event::select('events.*')
            ->addSelect(['bookings_count' => Booking::select(DB::raw('count(*)'))
                ->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
                ->whereColumn('tickets.event_id', 'events.id')
                ->where('bookings.status', 'approved')
                ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ])
            ->having('bookings_count', '>', 0)
            ->orderBy('bookings_count', 'desc')
            ->take(10)
            ->get();

        // ========== CATEGORY REPORTS ==========
        
        // ✅ 4. FIX: Revenue by Category - GROUP BY sudah handled
        $revenueByCategory = Category::select('categories.*', DB::raw('sum(bookings.total_price) as revenue'))
            ->join('events', 'categories.id', '=', 'events.category_id')
            ->join('tickets', 'events.id', '=', 'tickets.event_id')
            ->join('bookings', 'tickets.id', '=', 'bookings.ticket_id')
            ->where('bookings.status', 'approved')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('categories.id')
            ->orderBy('revenue', 'desc')
            ->get();

        // ========== TOP ORGANIZERS ==========
        
        // ✅ 5. FIX: Top Organizers by Revenue - GROUP BY sudah handled
        $topOrganizersByRevenue = User::select('users.*', DB::raw('sum(bookings.total_price) as revenue'))
            ->where('users.role', 'organizer')
            ->join('events', 'users.id', '=', 'events.organizer_id')
            ->join('tickets', 'events.id', '=', 'tickets.event_id')
            ->join('bookings', 'tickets.id', '=', 'bookings.ticket_id')
            ->where('bookings.status', 'approved')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('users.id')
            ->orderBy('revenue', 'desc')
            ->take(10)
            ->get();

        // ========== TOP CUSTOMERS ==========
        
        // ✅ 6. FIX: Top Customers by Spending - GROUP BY sudah handled
        $topCustomers = User::select('users.*', DB::raw('sum(bookings.total_price) as total_spent'))
            ->where('users.role', 'user')
            ->join('bookings', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.status', 'approved')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('users.id')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();

        // ========== SUMMARY STATISTICS ==========
        
        $statistics = [
            'total_users' => User::where('role', 'user')->count(),
            'total_organizers' => User::where('role', 'organizer')->where('organizer_status', 'approved')->count(),
            'total_events' => Event::where('status', 'published')->count(),
            'total_tickets_sold' => Booking::where('status', 'approved')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('quantity'),
        ];

        // ✅ 7. RE-ENABLE STRICT MODE (optional)
        config(['database.connections.mysql.strict' => true]);

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalRevenue',
            'revenueByStatus',
            'dailyRevenue',
            'totalBookings',
            'bookingsByStatus',
            'topEventsByRevenue',
            'topEventsByBookings',
            'revenueByCategory',
            'topOrganizersByRevenue',
            'topCustomers',
            'statistics'
        ));
    }
}