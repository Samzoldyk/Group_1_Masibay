<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard | SPAMAST SSG</title>

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
        }

        a.card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
            border-color: #cbd5e1;
        }

        .card h2 {
            margin: 0 0 12px;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
        }

        .card p {
            color: #1e293b;
            font-size: 20px;
            font-weight: 600;
            line-height: 1.4;
        }

        .profile-card {
            background: #eff6ff;
            border-color: #bfdbfe;
            grid-column: 1 / -1;
        }

        .profile-card h2 { color: #1d4ed8; }
        .profile-card p { color: #1e3a8a; font-size: 15px; font-weight: 500; }
        .profile-card:hover { background: #dbeafe; }

        .icon {
            font-size: 24px;
            opacity: 0.8;
            display: block;
            margin-bottom: 16px;
        }

        .weather-card {
            border-top: 4px solid #0ea5e9;
        }

        .weather-temp {
            font-size: 36px !important;
            font-weight: 800 !important;
            color: #2563eb !important;
            margin-bottom: 8px;
        }

        .weather-card .weather-description {
            font-size: 15px;
            font-weight: 600;
            color: #334155;
        }

        .weather-details {
            margin-top: 12px;
            line-height: 1.8;
            font-size: 13px;
            color: #64748b;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Student Dashboard</h1>
            <p>Welcome back, <strong>{{ $user->name }}</strong></p>
            <p>SPAMAST SSG Management System</p>
        </div>

        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>

    <div class="cards">

        <!-- Profile Card -->
        <a class="card profile-card" href="{{ route('profile.edit') }}">
            <h2>My Profile <span class="icon">⚙️</span></h2>
            <p>View and update your personal account details and password.</p>
        </a>

        <!-- Student ID -->
        <div class="card">
            <h2>My Student ID <span class="icon">🆔</span></h2>
            <p>{{ $user->student_id }}</p>
        </div>

        <!-- Course -->
        <div class="card">
            <h2>My Course <span class="icon">🎓</span></h2>
            <p>{{ $user->course ?? 'Not provided' }}</p>
        </div>

        <!-- Year Level -->
        <div class="card">
            <h2>Year Level <span class="icon">📚</span></h2>
            <p>{{ $user->year_level ?? 'Not provided' }}</p>
        </div>

        <!-- Weather -->
        <div class="card weather-card">
            <h2>SPAMAST Weather <span class="icon">🌤️</span></h2>

            @if($weather)
                <p class="weather-temp">{{ $weather['temperature'] }}°C</p>
                <p class="weather-description">{{ $weather['description'] }}</p>

                <div class="weather-details">
                    <div>Feels like: {{ $weather['feels_like'] }}°C</div>
                    <div>Humidity: {{ $weather['humidity'] }}%</div>
                    <div>Wind speed: {{ $weather['wind_speed'] }} km/h</div>
                </div>
            @else
                <p class="weather-description">
                    Weather information is currently unavailable.
                </p>
            @endif
        </div>

    </div>
</div>
</body>
</html>
