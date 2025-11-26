<?php
// app/Http/Controllers/Admin/OrganizerApprovalController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizerApprovalController extends Controller
{
    /**
     * Display list of organizers waiting for approval.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'organizer');

        // Filter by status
        $status = $request->get('status', 'pending');
        
        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('organizer_status', $status);
        }

        $organizers = $query->latest()->paginate(10);

        // Count by status for tabs
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

    /**
     * Approve an organizer.
     */
    public function approve(User $user)
    {
        // Validate user is organizer with pending status
        if ($user->role !== 'organizer') {
            return back()->with('error', 'User is not an organizer.');
        }

        if ($user->organizer_status === 'approved') {
            return back()->with('info', 'Organizer is already approved.');
        }

        // Approve organizer
        $user->update([
            'organizer_status' => 'approved'
        ]);

        // TODO: Send email notification to organizer (optional)
        // Mail::to($user->email)->send(new OrganizerApproved($user));

        return back()->with('success', "Organizer '{$user->name}' has been approved successfully.");
    }

    /**
     * Reject an organizer.
     */
    public function reject(User $user)
    {
        // Validate user is organizer
        if ($user->role !== 'organizer') {
            return back()->with('error', 'User is not an organizer.');
        }

        if ($user->organizer_status === 'rejected') {
            return back()->with('info', 'Organizer is already rejected.');
        }

        // Reject organizer
        $user->update([
            'organizer_status' => 'rejected'
        ]);

        // TODO: Send email notification to organizer (optional)
        // Mail::to($user->email)->send(new OrganizerRejected($user));

        return back()->with('success', "Organizer '{$user->name}' has been rejected. They can delete their account from the pending page.");
    }
}
