<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['category', 'organizer', 'tickets' => function($q) {
            $q->where('quota_remaining', '>', 0);
        }])->where('status', 'published');

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

        $query->whereHas('tickets', function($q) {
            $q->where('quota_remaining', '>', 0);
        });

        $sortBy = $request->get('sort_by', 'date');
        
        if (in_array($sortBy, ['price_low', 'price_high'])) {
            $allEvents = $query->get();
            
            $eventsWithPrice = [];
            foreach($allEvents as $event) {
                $availableTickets = $event->tickets->where('quota_remaining', '>', 0);
                
                if ($sortBy === 'price_low') {
                    $sortPrice = $availableTickets->min('price') ?? 999999999;
                } else {
                    $sortPrice = $availableTickets->max('price') ?? 0;
                }
                
                $eventsWithPrice[] = [
                    'event' => $event,
                    'sort_price' => (float) $sortPrice
                ];
            }
            
          
            usort($eventsWithPrice, function($a, $b) use ($sortBy) {
                if ($sortBy === 'price_low') {
                    $priceComparison = $a['sort_price'] <=> $b['sort_price'];
                } else {
                    $priceComparison = $b['sort_price'] <=> $a['sort_price'];
                }
                
               
                if ($priceComparison !== 0) {
                    return $priceComparison;
                }
                
                return strcmp($a['event']->name, $b['event']->name);
            });
            
            $sortedEvents = collect(array_map(function($item) {
                $item['event']->sorted_price = $item['sort_price'];
                return $item['event'];
            }, $eventsWithPrice));

           
            $page = $request->get('page', 1);
            $perPage = 12;
            $total = $sortedEvents->count();
            
            $events = new \Illuminate\Pagination\LengthAwarePaginator(
                $sortedEvents->forPage($page, $perPage)->values(),
                $total,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            switch ($sortBy) {
                case 'date':
                    $query->orderBy('event_date', 'asc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->orderBy('event_date', 'asc');
            }
            
            $events = $query->paginate(12)->withQueryString();
        }

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
                      ->orderBy('price', 'asc');
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