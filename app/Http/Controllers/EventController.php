<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['category', 'organizer', 'tickets'])
            ->where('status', 'published');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('filter')) {
            if ($request->filter === 'upcoming') {
                $query->where('event_date', '>', now());
            } elseif ($request->filter === 'past') {
                $query->where('event_date', '<', now());
            }
        }

        if ($request->filled('date_from')) {
            $query->where('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('event_date', '<=', $request->date_to);
        }

        $query->whereHas('tickets');

        $sortBy = $request->get('sort_by', 'date');
        
        switch ($sortBy) {
            case 'date':
                $query->orderBy('event_date', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'price_low':
                $query->addSelect(['min_price' => function($query) {
                    $query->selectRaw('CAST(MIN(price) AS UNSIGNED)')
                          ->from('tickets')
                          ->whereColumn('event_id', 'events.id')
                          ->whereNotNull('price');
                }])->orderBy('min_price', 'asc');
                break;
            case 'price_high':
                $query->addSelect(['max_price' => function($query) {
                    $query->selectRaw('CAST(MAX(price) AS UNSIGNED)')
                          ->from('tickets')
                          ->whereColumn('event_id', 'events.id')
                          ->whereNotNull('price');
                }])->orderBy('max_price', 'desc');
                break;
            default:
                $query->orderBy('event_date', 'asc');
        }

        $events = $query->paginate(12)->withQueryString();

        $categories = Category::withCount(['events' => function ($q) {
            $q->where('status', 'published');
        }])
        ->having('events_count', '>', 0)
        ->get();
        
        return view('events.index', compact('events', 'categories'));
    }

    public function show(Event $event)
    {
        if ($event->status !== 'published') {
            abort(404);
        }

        $event->load([
            'category',
            'organizer',
            'tickets' => function ($query) {
                $query->where('quota_remaining', '>', 0)
                      ->orderByRaw('CAST(price AS UNSIGNED) ASC');
            },
            'reviews' => function ($query) {
                $query->with('user')->latest()->take(10);
            }
        ]);

        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = $event->favorites()
                ->where('user_id', auth()->id())
                ->exists();
        }

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
                $hasReviewed = $event->reviews()
                    ->where('user_id', auth()->id())
                    ->exists();
                
                $canReview = !$hasReviewed;
            }
        }

        $averageRating = $event->reviews()->avg('rating') ?? 0;
        $totalReviews = $event->reviews()->count();

        $similarEvents = Event::with(['category', 'tickets'])
            ->where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->where('status', 'published')
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