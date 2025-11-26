<?php
// app/Http/Controllers/Organizer/EventController.php

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
    /**
     * Display a listing of organizer's events.
     */
    public function index(Request $request)
    {
        $organizer = auth()->user();
        $query = $organizer->events()->with(['category', 'tickets']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(12);

        // Get categories for filter
        $categories = Category::all();

        return view('organizer.events.index', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $categories = Category::all();

        return view('organizer.events.create', compact('categories'));
    }

    /**
     * Store a newly created event.
     */
    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        // Set organizer_id ke user yang login
        $data['organizer_id'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event = Event::create($data);

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Event created successfully. You can now add tickets.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Authorization: hanya bisa lihat event sendiri
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $event->load(['category', 'tickets', 'bookings.user']);

        // Statistics
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

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        // Authorization: hanya bisa edit event sendiri
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $categories = Category::all();

        return view('organizer.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified event.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        // Authorization: hanya bisa update event sendiri
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $data = $request->validated();

        // Handle image upload
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

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        // Authorization: hanya bisa delete event sendiri
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if event has bookings
        if ($event->bookings()->count() > 0) {
            return back()->with('error', 'Cannot delete event with existing bookings. Please cancel bookings first.');
        }

        // Delete image
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        // Delete tickets first (cascade)
        $event->tickets()->delete();

        $eventName = $event->name;
        $event->delete();

        return redirect()
            ->route('organizer.events.index')
            ->with('success', "Event '{$eventName}' has been deleted successfully.");
    }
}