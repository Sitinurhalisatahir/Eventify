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
    public function index(Request $request)
    {
        config(['database.connections.mysql.strict' => false]);
        \DB::reconnect();

        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        $totalRevenue = Booking::where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');

        $revenueByStatus = Booking::select('status', DB::raw('sum(total_price) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        $dailyRevenue = Booking::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('sum(total_price) as total')
            )
            ->where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->count();
        
        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        $topEventsByRevenue = Event::select('events.*', DB::raw('sum(bookings.total_price) as revenue'))
            ->join('tickets', 'events.id', '=', 'tickets.event_id')
            ->join('bookings', 'tickets.id', '=', 'bookings.ticket_id')
            ->where('bookings.status', 'approved')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('events.id')
            ->orderBy('revenue', 'desc')
            ->take(10)
            ->get();

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

        $revenueByCategory = Category::select('categories.*', DB::raw('sum(bookings.total_price) as revenue'))
            ->join('events', 'categories.id', '=', 'events.category_id')
            ->join('tickets', 'events.id', '=', 'tickets.event_id')
            ->join('bookings', 'tickets.id', '=', 'bookings.ticket_id')
            ->where('bookings.status', 'approved')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('categories.id')
            ->orderBy('revenue', 'desc')
            ->get();

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

        $topCustomers = User::select('users.*', DB::raw('sum(bookings.total_price) as total_spent'))
            ->where('users.role', 'user')
            ->join('bookings', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.status', 'approved')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('users.id')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();

       
        $statistics = [
            'total_users' => User::where('role', 'user')->count(),
            'total_organizers' => User::where('role', 'organizer')->where('organizer_status', 'approved')->count(),
            'total_events' => Event::where('status', 'published')->count(),
            'total_tickets_sold' => Booking::where('status', 'approved')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('quantity'),
        ];

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