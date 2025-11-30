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
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Event sudah ada di favorit.']);
            }
            return back()->with('info', 'Event sudah ada di favorit.');
        }

        // Add to favorites
        $user->favorites()->create([
            'event_id' => $event->id,
        ]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Event ditambahkan ke favorit.']);
        }

        return back()->with('success', 'Event ditambahkan ke favorit.');
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
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Event tidak ditemukan di favorit.']);
            }
            return back()->with('error', 'Event tidak ditemukan di favorit.');
        }

        $favorite->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Event dihapus dari favorit.']);
        }

        return back()->with('success', 'Event dihapus dari favorit.');
    }
}