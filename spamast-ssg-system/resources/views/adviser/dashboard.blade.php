
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adviser Dashboard | SPAMAST SSG</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #1f2937;
        }
        .container { max-width: 1200px; margin: auto; }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }
        h1 { color: #173b2d; margin: 0 0 8px; }
        p { color: #6b7280; }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-decoration: none;
            color: inherit;
        }
        .card h2 { color: #176b4d; }
        .stat { font-size: 36px; font-weight: bold; }
        button {
            background: #6b7280;
            color: white;
            padding: 11px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <h1>Adviser Dashboard</h1>
            <p>Welcome, {{ $user->name }}</p>
            <p>SPAMAST SSG Management System</p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="cards">
        <div class="card">
            <h2>Registered Students</h2>
            <div class="stat">{{ $totalStudents }}</div>
        </div>

        <a class="card" href="{{ route('events.index') }}">
            <h2>Events</h2>
            <p>View and manage SSG events.</p>
        </a>

        <a class="card" href="{{ route('attendance.index') }}">
            <h2>Attendance</h2>
            <p>Monitor student attendance.</p>
        </a>

        <a class="card" href="{{ route('sanctions.index') }}">
            <h2>Sanctions</h2>
            <p>Review and manage student sanctions.</p>
        </a>

        <a class="card" href="{{ route('profile.edit') }}">
            <h2>My Profile</h2>
            <p>Update your account details.</p>
        </a>
    </div>
</div>
</body>
</html>
