<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizerApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'organizer');

        $status = $request->get('status', 'pending');
        
        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('organizer_status', $status);
        }

        $organizers = $query->latest()->paginate(10);

        $pendingCount = User::where('role', 'organizer')
                            ->where('organizer_status', 'pending')
                            ->count();
        
        $approvedCount = User::where('role', 'organizer')
                             ->where('organizer_status', 'approved')
                             ->count();
        
        $rejectedCount = User::where('role', 'organizer')
                             ->where('organizer_status', 'rejected')
                             ->count();

        return view('admin.organizers.index', compact(
            'organizers',
            'status',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function approve(User $user)
    {
        if ($user->role !== 'organizer') {
            return back()->with('error', 'User is not an organizer.');
        }

        if ($user->organizer_status === 'approved') {
            return back()->with('info', 'Organizer is already approved.');
        }

        $user->update([
            'organizer_status' => 'approved'
        ]);

        return back()->with('success', "Organizer '{$user->name}' has been approved successfully.");
    }

        public function reject(User $user)
    {
        if ($user->role !== 'organizer') {
            return back()->with('error', 'User is not an organizer.');
        }

        if ($user->organizer_status === 'rejected') {
            return back()->with('info', 'Organizer is already rejected.');
        }

        $user->update([
            'organizer_status' => 'rejected'
        ]);


        return back()->with('success', "Organizer '{$user->name}' has been rejected. They can delete their account from the pending page.");
    }
}
