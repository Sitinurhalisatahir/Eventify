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
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Upcoming events (sorted by date)
        $upcomingEvents = Event::with(['category', 'organizer', 'tickets'])
            ->where('status', 'published')
            ->where('event_date', '>', now())
            ->orderBy('event_date', 'asc')
            ->take(8)
            ->get();

        // All categories with event count
        $categories = Category::withCount(['events' => function ($query) {
            $query->where('status', 'published')
                  ->where('event_date', '>', now());
        }])
        ->having('events_count', '>', 0)
        ->get();

        return view('home.index', compact('featuredEvents', 'upcomingEvents', 'categories'));
    }
}