<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    // GET /api/events
    public function index(Request $request)
    {
        $query = Event::with(['eventType', 'materials', 'user']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }

        if ($request->has('event_type_id')) {
            $query->where('event_type_id', $request->event_type_id);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'ilike', '%' . $request->search . '%')
                  ->orWhere('client', 'ilike', '%' . $request->search . '%');
            });
        }

        // Filtre par ville
        if ($request->has('city') && $request->city !== '') {
        $query->where('city', 'ilike', '%' . $request->city . '%');
        }  

        $events = $query->orderBy('date', 'asc')->get();
        return response()->json($events);
    }

    // GET /api/events/{id}
    public function show(Event $event)
    {
        return response()->json(
            $event->load(['eventType', 'materials', 'user'])
        );
    }

    // POST /api/events
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'date'               => 'required|date',
            'time'               => 'required',
            'location'           => 'required|string|max:255',
            'client'             => 'required|string|max:255',
            'event_type_id'      => 'required|exists:event_types,id',
            'status'             => 'required|in:confirmed,pending,cancelled',
            'notes'              => 'nullable|string',
            'materials'          => 'nullable|array',
            'materials.*.id'     => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|integer|min:1',
            'phone' => 'nullable|string|max:20',
            'city'  => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = $request->user()->id;

        // On retire materials de validated pour ne pas le passer à create()
        $materialsData = $request->materials ?? [];
        unset($validated['materials']);

        $event = Event::create($validated);

        // Attache les matériels avec leur quantité
        if (!empty($materialsData)) {
            $syncData = [];
            foreach ($materialsData as $item) {
                $syncData[$item['id']] = ['quantity' => $item['quantity']];
            }
            $event->materials()->sync($syncData);
        }

        return response()->json(
            $event->load(['eventType', 'materials', 'user']),
            201
        );
    }

    // PUT /api/events/{id}
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name'               => 'sometimes|required|string|max:255',
            'date'               => 'sometimes|required|date',
            'time'               => 'sometimes|required',
            'location'           => 'sometimes|required|string|max:255',
            'client'             => 'sometimes|required|string|max:255',
            'event_type_id'      => 'sometimes|required|exists:event_types,id',
            'status'             => 'sometimes|required|in:confirmed,pending,cancelled',
            'notes'              => 'nullable|string',
            'materials'          => 'nullable|array',
            'materials.*.id'     => 'required_with:materials|exists:materials,id',
            'materials.*.quantity' => 'required_with:materials|integer|min:1',
            'phone' => 'nullable|string|max:20',
            'city'  => 'nullable|string|max:255',
        ]);

        // On retire materials de validated avant update()
        $materialsData = $request->materials ?? null;
        unset($validated['materials']);

        $event->update($validated);

        // Sync matériels avec quantité si envoyés
        if ($materialsData !== null) {
            $syncData = [];
            foreach ($materialsData as $item) {
                $syncData[$item['id']] = ['quantity' => $item['quantity']];
            }
            $event->materials()->sync($syncData);
        }

        return response()->json(
            $event->load(['eventType', 'materials', 'user'])
        );
    }

    // DELETE /api/events/{id}
    public function destroy(Event $event)
    {
        $event->materials()->detach();
        $event->delete();
        return response()->json(['message' => 'Événement supprimé.']);
    }
}