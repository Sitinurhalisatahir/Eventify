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
    public function create(Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('organizer.tickets.create', compact('event'));
    }

    public function store(StoreTicketRequest $request, Event $event)
    {
        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $data = $request->validated();
        $data['event_id'] = $event->id;

        $data['quota_remaining'] = $data['quota'];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tickets', 'public');
        }

        Ticket::create($data);

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Ticket created successfully.');
    }

    
    public function edit(Ticket $ticket)
    {
        if ($ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $ticket->load('event');
        
        return view('organizer.tickets.edit', compact('ticket'));
    }

    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        if ($ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $data = $request->validated();

        if (isset($data['quota']) && $data['quota'] != $ticket->quota) {
            $soldTickets = $ticket->quota - $ticket->quota_remaining;
            $newQuotaRemaining = $data['quota'] - $soldTickets;
            
            if ($newQuotaRemaining < 0) {
                return back()->with('error', "Cannot set quota to {$data['quota']}. Already sold {$soldTickets} tickets.");
            }
            
            $data['quota_remaining'] = $newQuotaRemaining;
        }

        if ($request->hasFile('image')) {
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

    public function destroy(Ticket $ticket)
    {
        if ($ticket->event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($ticket->bookings()->count() > 0) {
            return back()->with('error', 'Cannot delete ticket with existing bookings. Please cancel bookings first.');
        }

        $eventId = $ticket->event_id;

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