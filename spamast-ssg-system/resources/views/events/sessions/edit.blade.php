
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event Session</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 30px auto;
            padding: 0 20px;
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

        button, a {
            display: inline-block;
            padding: 9px 14px;
            border: 0;
            border-radius: 4px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h1>Edit Event Session</h1>

    <p>
        <a href="{{ route('events.show', $event) }}">Back to event</a>
    </p>

    <h3>{{ $event->name }}</h3>

    <form method="POST"
        action="{{ route('events.sessions.update', [$event, $session]) }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="session_name">Session Name</label>
            <input type="text" id="session_name" name="session_name"
                value="{{ old('session_name', $session->session_name) }}" required>
            @error('session_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="session_date">Session Date</label>
            <input type="date" id="session_date" name="session_date"
                value="{{ old('session_date', $session->session_date) }}" required>
            @error('session_date')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" name="start_time"
                value="{{ old('start_time', $session->start_time ? substr($session->start_time, 0, 5) : '') }}">
            @error('start_time')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="end_time">End Time</label>
            <input type="time" id="end_time" name="end_time"
                value="{{ old('end_time', $session->end_time ? substr($session->end_time, 0, 5) : '') }}">
            @error('end_time')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="venue">Session Venue</label>
            <input type="text" id="venue" name="venue"
                value="{{ old('venue', $session->venue) }}">
            @error('venue')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
