<?php

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
    public function index(Request $request)
    {
        $query = Event::with(['category', 'organizer', 'tickets']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('organizer')) {
            $query->where('organizer_id', $request->organizer);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::all();
        $organizers = User::where('role', 'organizer')
                          ->where('organizer_status', 'approved')
                          ->get();

        return view('admin.events.index', compact('events', 'categories', 'organizers'));
    }


    public function create()
    {
        $categories = Category::all();
        $organizers = User::where('role', 'organizer')
                          ->where('organizer_status', 'approved')
                          ->get();

        return view('admin.events.create', compact('categories', 'organizers'));
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        if (!isset($data['organizer_id'])) {
            $data['organizer_id'] = auth()->id();
        }

        $event = Event::create($data);

        return redirect()
            ->route('admin.events.show', $event)
            ->with('success', 'Event created successfully. You can now add tickets.');
    }

   
    public function show(Event $event)
    {
        $event->load(['category', 'organizer', 'tickets', 'bookings.user']);

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

    public function edit(Event $event)
    {
        $categories = Category::all();
        $organizers = User::where('role', 'organizer')
                          ->where('organizer_status', 'approved')
                          ->get();

        return view('admin.events.edit', compact('event', 'categories', 'organizers'));
    }


    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

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


    public function destroy(Event $event)
    {
        $eventName = $event->name;
        $hasBookings = $event->bookings()->exists();

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->tickets()->delete();
        $event->bookings()->delete(); 
        $event->favorites()->delete(); 
        $event->reviews()->delete();   

        $event->delete();

        $message = $hasBookings 
            ? "Event '{$eventName}' and all associated bookings have been deleted successfully."
            : "Event '{$eventName}' has been deleted successfully.";

        return redirect()
            ->route('admin.events.index')
            ->with('success', $message);
    }
}