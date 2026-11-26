<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Events | SPAMAST SSG</title>

    <!-- Modern Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            padding: 40px 20px;
            -webkit-font-smoothing: antialiased;
        }

        .container { max-width: 1200px; margin: auto; }

        /* --- BACK LINK --- */
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .back-link:hover { color: #2563eb; }

        /* --- MAIN CARD --- */
        .box {
            background: white;
            padding: 32px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        /* --- HEADER --- */
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 15px;
        }
        h1 { margin: 0; color: #0f172a; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }

        /* --- BUTTONS --- */
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            background: #2563eb; color: white;
            padding: 10px 20px; border-radius: 10px; text-decoration: none;
            border: none; cursor: pointer; font-size: 14px; font-weight: 600;
            font-family: inherit; transition: all 0.2s;
        }
        .btn:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }

        .btn-sm { padding: 8px 14px; font-size: 13px; }
        .btn-ghost { background: #f1f5f9; color: #475569; }
        .btn-ghost:hover { background: #e2e8f0; box-shadow: none; transform: none; }

        .btn-danger { background: #ef4444; }
        .btn-danger:hover { background: #dc2626; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2); }

        /* --- ALERTS --- */
        .success {
            background: #f0fdf4; color: #166534; padding: 14px 20px;
            border-radius: 12px; margin-bottom: 24px; border: 1px solid #bbf7d0;
            font-weight: 500; font-size: 14px;
        }

        /* --- TABLE --- */
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th {
            text-align: left; padding: 12px 16px; color: #64748b;
            font-size: 11px; text-transform: uppercase; letter-spacing: 1px;
            background: #f8fafc; border-bottom: 1px solid #e2e8f0;
        }
        th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }

        td { padding: 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; color: #334155; }
        tr:hover td { background: #f8fafc; }

        /* --- ACTIONS --- */
        .actions { display: flex; gap: 8px; align-items: center; }
        .actions form { margin: 0; }

        .empty { text-align: center; padding: 40px; color: #64748b; font-size: 15px; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('dashboard') }}" class="back-link">&larr; Back to dashboard</a>

    <div class="box">
        <!-- Header -->
        <div class="top">
            <h1>Events</h1>
            <a class="btn" href="{{ route('events.create') }}">+ Add Event</a>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td style="font-weight: 500; color: #0f172a;">{{ $event->name }}</td>
                        <td>{{ $event->event_date }}</td>
                        <td>{{ $event->venue }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-ghost">View</a>
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-ghost">Edit</a>

                                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">No events yet. Click "+ Add Event" to get started.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
