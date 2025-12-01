<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $organizer = auth()->user();
        $query = $organizer->events()->with(['category', 'tickets']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(12);

        $events->getCollection()->transform(function ($event) {
        $event->revenue = \App\Models\Booking::whereHas('ticket', function($query) use ($event) {
            $query->where('event_id', $event->id);
        })->where('status', 'approved')->sum('total_price');
        
        return $event;
    });

        // Get categories for filter
        $categories = Category::all();

        return view('organizer.events.index', compact('events', 'categories'));
    }

   
    public function create()
    {
        $categories = Category::all();

        return view('organizer.events.create', compact('categories'));
    }


    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        $data['organizer_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event = Event::create($data);

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Event created successfully. You can now add tickets.');
    }

   
    public function show(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $event->load(['category', 'tickets', 'bookings.user']);
        
        $totalTickets = $event->tickets()->sum('quota');
        $soldTickets = $totalTickets - $event->tickets()->sum('quota_remaining');
        $totalRevenue = $event->bookings()->where('status', 'approved')->sum('total_price');
        $totalBookings = $event->bookings()->count();

        return view('organizer.events.show', compact(
            'event',
            'totalTickets',
            'soldTickets',
            'totalRevenue',
            'totalBookings'
        ));
    }


    public function edit(Event $event)
    {
        // Authorization: hanya bisa edit event sendiri
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $categories = Category::all();

        return view('organizer.events.edit', compact('event', 'categories'));
    }

   
    public function update(UpdateEventRequest $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Event updated successfully.');
    }

  
    public function destroy(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($event->bookings()->count() > 0) {
            return back()->with('error', 'Cannot delete event with existing bookings. Please cancel bookings first.');
        }

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->tickets()->delete();

        $eventName = $event->name;
        $event->delete();

        return redirect()
            ->route('organizer.events.index')
            ->with('success', "Event '{$eventName}' has been deleted successfully.");
    }
}