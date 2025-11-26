<?php
// app/Http/Controllers/Admin/EventController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request)
    {
        $query = Event::with(['category', 'organizer', 'tickets']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by organizer
        if ($request->filled('organizer')) {
            $query->where('organizer_id', $request->organizer);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(12);

        // Get categories and organizers for filter
        $categories = Category::all();
        $organizers = User::where('role', 'organizer')
                          ->where('organizer_status', 'approved')
                          ->get();

        return view('admin.events.index', compact('events', 'categories', 'organizers'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $categories = Category::all();
        $organizers = User::where('role', 'organizer')
                          ->where('organizer_status', 'approved')
                          ->get();

        return view('admin.events.create', compact('categories', 'organizers'));
    }

    /**
     * Store a newly created event.
     */
    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        // Set organizer_id (admin bisa pilih organizer atau set ke diri sendiri jika admin)
        if (!isset($data['organizer_id'])) {
            $data['organizer_id'] = auth()->id();
        }

        $event = Event::create($data);

        return redirect()
            ->route('admin.events.show', $event)
            ->with('success', 'Event created successfully. You can now add tickets.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->load(['category', 'organizer', 'tickets', 'bookings.user']);

        // Statistics
        $totalTickets = $event->tickets()->sum('quota');
        $soldTickets = $totalTickets - $event->tickets()->sum('quota_remaining');
        $totalRevenue = $event->bookings()->where('status', 'approved')->sum('total_price');
        $totalBookings = $event->bookings()->count();

        return view('admin.events.show', compact(
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
        $categories = Category::all();
        $organizers = User::where('role', 'organizer')
                          ->where('organizer_status', 'approved')
                          ->get();

        return view('admin.events.edit', compact('event', 'categories', 'organizers'));
    }

    /**
     * Update the specified event.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
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
            ->route('admin.events.show', $event)
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
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
            ->route('admin.events.index')
            ->with('success', "Event '{$eventName}' has been deleted successfully.");
    }
}