<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventSession;
use Illuminate\Http\Request;

class EventSessionController extends Controller
{
    private function rules(): array
    {
        return [
            'session_name' => ['required', 'string', 'max:255'],
            'session_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'venue' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function store(Request $request, Event $event)
    {
        $data = $request->validate($this->rules());

        $event->sessions()->create($data);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event session created.');
    }

    public function edit(Event $event, EventSession $session)
    {
        abort_unless($session->event_id === $event->id, 404);

        return view('events.sessions.edit', compact('event', 'session'));
    }

    public function update(Request $request, Event $event, EventSession $session)
    {
        abort_unless($session->event_id === $event->id, 404);

        $session->update($request->validate($this->rules()));

        return redirect()->route('events.show', $event)
            ->with('success', 'Event session updated.');
    }

    public function destroy(Event $event, EventSession $session)
    {
        abort_unless($session->event_id === $event->id, 404);

        $session->delete();

        return redirect()->route('events.show', $event)
            ->with('success', 'Event session deleted.');
    }
}
