<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Featured/Popular events (events with most bookings or random)
        $featuredEvents = Event::with(['category', 'organizer', 'tickets'])
            ->where('status', 'published')
            ->where('event_date', '>', now())
            ->whereHas('tickets')
            ->inRandomOrder()
            ->paginate(6);  // ✅ UBAH: get() -> paginate(6)

        // Upcoming events (sorted by date) - TAMBAH PAGINATION
        $upcomingEvents = Event::with(['category', 'organizer', 'tickets'])
            ->where('status', 'published')
            ->where('event_date', '>', now())
            ->whereHas('tickets')
            ->orderBy('event_date', 'asc')
            ->paginate(8);  // ✅ UBAH: get() -> paginate(8)
        
        // Past Events untuk lihat rating - TAMBAH PAGINATION
        $pastEvents = Event::with(['category', 'organizer', 'tickets', 'reviews'])
            ->where('status', 'published')
            ->where('event_date', '<', now())
            ->orderBy('event_date', 'desc')
            ->paginate(6);  // ✅ UBAH: get() -> paginate(6)

        // All categories with event count
        $categories = Category::withCount(['events' => function ($query) {
            $query->where('status', 'published')
                  ->where('event_date', '>', now());
        }])
        ->having('events_count', '>', 0)
        ->get();

        return view('home.index', compact('featuredEvents', 'upcomingEvents', 'pastEvents', 'categories'));
    }
}