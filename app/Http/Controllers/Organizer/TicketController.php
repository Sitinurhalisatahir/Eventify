<?php
// app/Http/Controllers/Organizer/TicketController.php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Show the form for creating a new ticket.
     */
    public function create(Event $event)
    {
        // Authorization: hanya bisa create ticket untuk event sendiri
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('organizer.tickets.create', compact('event'));
    }

    /**
     * Store a newly created ticket.
     */
    public function store(StoreTicketRequest $request, Event $event)
    {
        // Authorization: hanya bisa create ticket untuk event sendiri
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $data = $request->validated();
        $data['event_id'] = $event->id;

        // Set quota_remaining sama dengan quota
        $data['quota_remaining'] = $data['quota'];

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tickets', 'public');
        }

        Ticket::create($data);

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Show the form for editing the specified ticket.
     */
    public function edit(Ticket $ticket)
    {
        // Authorization: hanya bisa edit ticket untuk event sendiri
        if ($ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $ticket->load('event');
        
        return view('organizer.tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified ticket.
     */
    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        // Authorization: hanya bisa update ticket untuk event sendiri
        if ($ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $data = $request->validated();

        // Handle quota changes
        // Jika quota berubah, adjust quota_remaining
        if (isset($data['quota']) && $data['quota'] != $ticket->quota) {
            $soldTickets = $ticket->quota - $ticket->quota_remaining;
            $newQuotaRemaining = $data['quota'] - $soldTickets;
            
            // Validasi: quota baru tidak boleh kurang dari sold tickets
            if ($newQuotaRemaining < 0) {
                return back()->with('error', "Cannot set quota to {$data['quota']}. Already sold {$soldTickets} tickets.");
            }
            
            $data['quota_remaining'] = $newQuotaRemaining;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($ticket->image) {
                Storage::disk('public')->delete($ticket->image);
            }
            
            $data['image'] = $request->file('image')->store('tickets', 'public');
        }

        $ticket->update($data);

        return redirect()
            ->route('organizer.events.show', $ticket->event_id)
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified ticket.
     */
    public function destroy(Ticket $ticket)
    {
        // Authorization: hanya bisa delete ticket untuk event sendiri
        if ($ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if ticket has bookings
        if ($ticket->bookings()->count() > 0) {
            return back()->with('error', 'Cannot delete ticket with existing bookings. Please cancel bookings first.');
        }

        $eventId = $ticket->event_id;

        // Delete image
        if ($ticket->image) {
            Storage::disk('public')->delete($ticket->image);
        }

        $ticketName = $ticket->name;
        $ticket->delete();

        return redirect()
            ->route('organizer.events.show', $eventId)
            ->with('success', "Ticket '{$ticketName}' has been deleted successfully.");
    }
}