<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $query->where('id', '!=', auth()->id());

        $users = $query->latest()->paginate(15);

        $totalUsers = User::where('role', 'user')->count();
        $totalOrganizers = User::where('role', 'organizer')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'totalOrganizers',
            'totalAdmins'
        ));
    }

    public function show(User $user)
    {
        if ($user->role === 'organizer') {
            $user->load(['events' => function ($query) {
                $query->latest()->take(5);
            }]);
        } elseif ($user->role === 'user') {
            $user->load([
                'bookings' => function ($query) {
                    $query->with('ticket.event')->latest()->take(5);
                },
                'favorites' => function ($query) {
                    $query->with('event')->latest()->take(5);
                },
                'reviews' => function ($query) {
                    $query->with('event')->latest()->take(5);
                }
            ]);
        }

        $statistics = [];
        
        if ($user->role === 'organizer') {
            $statistics['total_events'] = $user->events()->count();
            $statistics['published_events'] = $user->events()->where('status', 'published')->count();
            $statistics['total_bookings'] = $user->events()->withCount('bookings')->get()->sum('bookings_count');
            $statistics['total_revenue'] = $user->events()
                ->join('tickets', 'events.id', '=', 'tickets.event_id')
                ->join('bookings', 'tickets.id', '=', 'bookings.ticket_id')
                ->where('bookings.status', 'approved')
                ->sum('bookings.total_price');
        } elseif ($user->role === 'user') {
            $statistics['total_bookings'] = $user->bookings()->count();
            $statistics['approved_bookings'] = $user->bookings()->where('status', 'approved')->count();
            $statistics['total_spent'] = $user->bookings()->where('status', 'approved')->sum('total_price');
            $statistics['total_favorites'] = $user->favorites()->count();
            $statistics['total_reviews'] = $user->reviews()->count();
        }

        return view('admin.users.show', compact('user', 'statistics'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'You cannot delete another admin account.');
        }

        if ($user->role === 'organizer' && $user->events()->count() > 0) {
            return back()->with('error', 'Cannot delete organizer with existing events. Please delete events first.');
        }

        if ($user->role === 'user' && $user->bookings()->count() > 0) {
            return back()->with('error', 'Cannot delete user with existing bookings. Please cancel bookings first.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User '{$userName}' has been deleted successfully.");
    }
}