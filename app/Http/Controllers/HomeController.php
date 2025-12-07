<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
 
    public function index()
    {
        $featuredEvents = Event::with(['category', 'organizer', 'tickets'])
        ->where('status', 'published')
        ->where('event_date', '>', now())
        ->whereHas('tickets')
        ->addSelect(['successful_tickets' => function($query) {
            $query->selectRaw('COALESCE(SUM(bookings.quantity), 0)')
              ->from('bookings')
              ->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
              ->whereColumn('tickets.event_id', 'events.id')
              ->where('bookings.status', 'approved');
            }])
        ->orderBy('successful_tickets', 'desc')
        ->paginate(6);
        
        $upcomingEvents = Event::with(['category', 'organizer', 'tickets'])
            ->where('status', 'published')
            ->where('event_date', '>', now())
            ->whereHas('tickets')
            ->orderBy('event_date', 'asc')
            ->paginate(8);  
        
        $pastEvents = Event::with(['category', 'organizer', 'tickets', 'reviews'])
            ->where('status', 'published')
            ->where('event_date', '<', now())
            ->orderBy('event_date', 'desc')
            ->paginate(6);  

        $categories = Category::withCount(['events' => function ($query) {
            $query->where('status', 'published')
                  ->where('event_date', '>', now());
        }])
        ->having('events_count', '>', 0)
        ->get();

        return view('home.index', compact('featuredEvents', 'upcomingEvents', 'pastEvents', 'categories'));
    }
}