<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Officer Dashboard | SPAMAST SSG</title>

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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            background: white;
            padding: 30px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        h1 {
            margin: 0 0 6px;
            color: #0f172a;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        p { margin: 0; color: #64748b; font-size: 15px; }

        .logout {
            background: #f1f5f9;
            color: #475569;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            transition: all 0.2s;
        }

        .logout:hover { background: #e2e8f0; color: #1e293b; }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            transition: all 0.2s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        a.card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            transform: translateY(-2px);
            border-color: #cbd5e1;
        }

        .card h2 {
            margin: 0 0 10px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }

        .stat {
            font-size: 40px;
            font-weight: 800;
            color: #2563eb;
            margin-top: auto;
            letter-spacing: -1px;
        }

        .icon { font-size: 24px; opacity: 0.8; }

        .weather-temp {
            font-size: 40px;
            font-weight: 800;
            color: #2563eb;
            margin: 8px 0;
        }

        .weather-details {
            margin-top: 12px;
            line-height: 1.8;
            font-size: 13px;
            color: #64748b;
        }

        .weather-credit {
            margin-top: 14px;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Officer Dashboard</h1>
            <p>Welcome back, <strong>{{ $user->name }}</strong></p>
            <p>SPAMAST SSG Management System</p>
        </div>

        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>

    <div class="cards">

        <!-- Registered Students -->
        <div class="card" style="border-top: 4px solid #2563eb;">
            <h2>Registered Students <span class="icon">👥</span></h2>
            <div class="stat">{{ $totalStudents }}</div>
        </div>

        <!-- Weather Card -->
        <div class="card" style="border-top: 4px solid #0ea5e9;">
            <h2>SPAMAST Weather <span class="icon">🌤️</span></h2>

            @if($weather)
                <div class="weather-temp">{{ $weather['temperature'] }}°C</div>
                <p>{{ $weather['description'] }}</p>

                <div class="weather-details">
                    <div>Feels like: {{ $weather['feels_like'] }}°C</div>
                    <div>Humidity: {{ $weather['humidity'] }}%</div>
                    <div>Wind speed: {{ $weather['wind_speed'] }} km/h</div>
                </div>
            @else
                <p>Weather information is currently unavailable.</p>
            @endif

            <p class="weather-credit">Weather data by Open-Meteo</p>
        </div>

        <!-- Events -->
        <a class="card" href="{{ route('events.index') }}">
            <h2>Events <span class="icon">📅</span></h2>
            <p>Create and manage campus events.</p>
        </a>

        <!-- Attendance -->
        <a class="card" href="{{ route('attendance.index') }}">
            <h2>Attendance <span class="icon">✅</span></h2>
            <p>Track and manage student attendance.</p>
        </a>

        <!-- Sanctions -->
        <a class="card" href="{{ route('sanctions.index') }}">
            <h2>Sanctions <span class="icon">⚖️</span></h2>
            <p>Manage student sanctions and records.</p>
        </a>

        <!-- Announcements -->
        <a class="card" href="{{ route('announcements.index') }}">
            <h2>Announcements <span class="icon">📢</span></h2>
            <p>Create and manage important SSG announcements.</p>
        </a>

        <!-- Profile -->
        <a class="card" href="{{ route('profile.edit') }}">
            <h2>My Profile <span class="icon">⚙️</span></h2>
            <p>Update your account and personal details.</p>
        </a>

    </div>
</div>
</body>
</html>
