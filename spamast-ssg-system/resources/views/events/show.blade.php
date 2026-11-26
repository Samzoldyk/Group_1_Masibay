
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px auto;
            max-width: 900px;
            padding: 0 20px;
            color: #333;
        }

        .label {
            font-weight: bold;
            margin-top: 12px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .field {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 9px;
            box-sizing: border-box;
        }

        button, .btn {
            display: inline-block;
            padding: 9px 14px;
            border: 0;
            border-radius: 4px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .danger {
            background: #dc2626;
        }

        .session {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .session:last-child {
            border-bottom: none;
        }

        .actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .actions form {
            margin: 0;
        }

        .alert {
            background: #dcfce7;
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h1>{{ $event->name }}</h1>

    <a href="{{ route('events.index') }}">Back to events</a>

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="label">Date</div>
    <div>{{ $event->event_date }}</div>

    <div class="label">Venue</div>
    <div>{{ $event->venue }}</div>

    <div class="label">Description</div>
    <div>{{ $event->description ?: 'No description provided.' }}</div>

    <p>
        <a href="{{ route('events.edit', $event) }}">Edit this event</a>
    </p>

    <div class="card">
        <h2>Create Event Session</h2>

        <form method="POST" action="{{ route('events.sessions.store', $event) }}">
            @csrf

            <div class="field">
                <label for="session_name">Session Name</label>
                <input type="text" id="session_name" name="session_name"
                    value="{{ old('session_name') }}" required>
                @error('session_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="session_date">Session Date</label>
                <input type="date" id="session_date" name="session_date"
                    value="{{ old('session_date') }}" required>
                @error('session_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="start_time">Start Time</label>
                <input type="time" id="start_time" name="start_time"
                    value="{{ old('start_time') }}">
                @error('start_time')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="end_time">End Time</label>
                <input type="time" id="end_time" name="end_time"
                    value="{{ old('end_time') }}">
                @error('end_time')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="venue">Session Venue</label>
                <input type="text" id="venue" name="venue"
                    value="{{ old('venue', $event->venue) }}">
                @error('venue')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Add Session</button>
        </form>
    </div>

    <div class="card">
        <h2>Event Sessions</h2>

        @forelse ($event->sessions()->orderBy('session_date')->orderBy('start_time')->get() as $session)
            <div class="session">
                <h3>{{ $session->session_name }}</h3>

                <p><strong>Date:</strong> {{ $session->session_date }}</p>

                <p>
                    <strong>Time:</strong>
                    {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('g:i A') : 'Not set' }}
                    to
                    {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('g:i A') : 'Not set' }}
                </p>

                <p><strong>Venue:</strong> {{ $session->venue ?: 'Not set' }}</p>

                <div class="actions">
                    <a class="btn" href="{{ route('events.sessions.edit', [$event, $session]) }}">
                        Edit
                    </a>

                    <form method="POST"
                        action="{{ route('events.sessions.destroy', [$event, $session]) }}"
                        onsubmit="return confirm('Delete this event session?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="danger">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No sessions have been added to this event.</p>
        @endforelse
    </div>
</body>
</html>
