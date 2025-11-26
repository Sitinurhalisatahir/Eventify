<?php
// app/Http/Controllers/EventController.php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display event catalog with filters.
     */
    public function index(Request $request)
    {
        $query = Event::with(['category', 'organizer', 'tickets'])
            ->where('status', 'published')
            ->where('event_date', '>', now());

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by location (search)
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('event_date', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'date'); // default: date
        switch ($sortBy) {
            case 'date':
                $query->orderBy('event_date', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'price_low':
                // Sort by cheapest ticket price
                $query->join('tickets', 'events.id', '=', 'tickets.event_id')
                      ->select('events.*')
                      ->orderBy('tickets.price', 'asc');
                break;
            case 'price_high':
                $query->join('tickets', 'events.id', '=', 'tickets.event_id')
                      ->select('events.*')
                      ->orderBy('tickets.price', 'desc');
                break;
            default:
                $query->orderBy('event_date', 'asc');
        }

        // Paginate results
        $events = $query->paginate(12)->withQueryString();

        // Get all categories for filter
        $categories = Category::withCount(['events' => function ($q) {
            $q->where('status', 'published')
              ->where('event_date', '>', now());
        }])
        ->having('events_count', '>', 0)
        ->get();

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Display event detail.
     */
    public function show($slug)
    {
        // Find event by ID or slug
        $event = Event::with([
            'category',
            'organizer',
            'tickets' => function ($query) {
                $query->orderBy('price', 'asc');
            },
            'reviews' => function ($query) {
                $query->with('user')->latest()->take(10);
            }
        ])
        ->where('status', 'published')
        ->where(function ($query) use ($slug) {
            $query->where('id', $slug)
                  ->orWhere('name', 'like', '%' . str_replace('-', ' ', $slug) . '%');
        })
        ->firstOrFail();

        // Check if user already favorited this event
        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = $event->favorites()
                ->where('user_id', auth()->id())
                ->exists();
        }

        // Check if user can review (has approved booking for this event)
        $canReview = false;
        $userBooking = null;
        if (auth()->check() && auth()->user()->role === 'user') {
            $userBooking = $event->bookings()
                ->where('user_id', auth()->id())
                ->where('status', 'approved')
                ->whereHas('ticket.event', function ($query) {
                    $query->where('event_date', '<', now());
                })
                ->first();

            if ($userBooking) {
                // Check if not already reviewed
                $hasReviewed = $event->reviews()
                    ->where('user_id', auth()->id())
                    ->exists();
                
                $canReview = !$hasReviewed;
            }
        }

        // Get average rating
        $averageRating = $event->reviews()->avg('rating') ?? 0;
        $totalReviews = $event->reviews()->count();

        // Similar events (same category)
        $similarEvents = Event::with(['category', 'tickets'])
            ->where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->where('status', 'published')
            ->where('event_date', '>', now())
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('events.show', compact(
            'event',
            'isFavorited',
            'canReview',
            'userBooking',
            'averageRating',
            'totalReviews',
            'similarEvents'
        ));
    }
}