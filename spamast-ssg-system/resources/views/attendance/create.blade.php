
@extends('attendance.layout')

@section('title', 'Record Attendance')

@section('content')
    <div class="head">
        <h1>Record Attendance</h1>
        <a class="btn ghost" href="{{ route('attendance.index') }}">&larr; Back to records</a>
    </div>

    @if ($events->isEmpty())
        <div class="alert warn">
            No events found. Create an event first.
        </div>
    @elseif ($sessions->isEmpty())
        <div class="alert warn">
            No event sessions found. Create a session first.
        </div>
    @endif

    <div class="card form-card">
        <form method="POST" action="{{ route('attendance.store') }}">
            @csrf

            <div class="field">
                <label for="student_id">Student</label>
                <select id="student_id" name="student_id" required>
                    <option value="">Select a student</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                            {{ $student->name }} ({{ $student->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="event_id">Event</label>
                <select id="event_id" name="event_id" required>
                    <option value="">Select an event</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>
                            {{ $event->label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="event_session_id">Event Session</label>
                <select id="event_session_id" name="event_session_id" required>
                    <option value="">Select a session</option>
                    @foreach ($sessions as $session)
                        <option
                            value="{{ $session->id }}"
                            data-event="{{ $session->event_id }}"
                            @selected(old('event_session_id') == $session->id)
                        >
                            {{ $session->event_label }} | {{ $session->session_name }}
                            ({{ $session->session_date }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(old('status', 'present') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="field">
                    <label for="time_in">Time in</label>
                    <input type="time" id="time_in" name="time_in" value="{{ old('time_in') }}">
                </div>

                <div class="field">
                    <label for="time_out">Time out</label>
                    <input type="time" id="time_out" name="time_out" value="{{ old('time_out') }}">
                </div>
            </div>

            <div class="field">
                <label for="remarks">Remarks (optional)</label>
                <textarea id="remarks" name="remarks" rows="2" maxlength="255">{{ old('remarks') }}</textarea>
            </div>

            <button class="btn" type="submit">Save attendance</button>
        </form>
    </div>

    <script>
        const eventSelect = document.getElementById('event_id');
        const sessionSelect = document.getElementById('event_session_id');

        function filterSessions() {
            const selectedEvent = eventSelect.value;

            Array.from(sessionSelect.options).forEach(option => {
                if (!option.value) return;

                const matches = option.dataset.event === selectedEvent;
                option.hidden = !matches;
                option.disabled = !matches;
            });

            const selectedOption = sessionSelect.options[sessionSelect.selectedIndex];

            if (selectedOption && selectedOption.disabled) {
                sessionSelect.value = '';
            }
        }

        eventSelect.addEventListener('change', filterSessions);
        filterSessions();

        (function () {
            const input = document.getElementById('time_in');

            if (input && !input.value) {
                const now = new Date();
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');

                input.value = h + ':' + m;
            }
        })();
    </script>
@endsection
