<?php
// app/Http/Controllers/User/FavoriteController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display user's favorite events.
     */
    public function index()
    {
        $user = auth()->user();

        $favorites = $user->favorites()
            ->with(['event.category', 'event.tickets'])
            ->latest()
            ->paginate(12);

        return view('user.favorites.index', compact('favorites'));
    }

    /**
     * Add event to favorites.
     */
    public function store(Event $event)
    {
        $user = auth()->user();

        // Check if already favorited
        $exists = $user->favorites()
            ->where('event_id', $event->id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Event is already in your favorites.');
        }

        // Add to favorites
        $user->favorites()->create([
            'event_id' => $event->id,
        ]);

        return back()->with('success', 'Event added to favorites.');
    }

    /**
     * Remove event from favorites.
     */
    public function destroy(Event $event)
    {
        $user = auth()->user();

        // Find and delete favorite
        $favorite = $user->favorites()
            ->where('event_id', $event->id)
            ->first();

        if (!$favorite) {
            return back()->with('error', 'Event not found in your favorites.');
        }

        $favorite->delete();

        return back()->with('success', 'Event removed from favorites.');
    }
}