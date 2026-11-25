
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard | SPAMAST SSG</title>
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
            <h1>Student Dashboard</h1>
            <p>Welcome, {{ $user->name }}</p>
            <p>SPAMAST SSG Management System</p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="cards">
        <a class="card" href="{{ route('profile.edit') }}">
            <h2>My Profile</h2>
            <p>View and update your account details.</p>
        </a>

        <div class="card">
            <h2>My Student ID</h2>
            <p>{{ $user->student_id }}</p>
        </div>

        <div class="card">
            <h2>My Course</h2>
            <p>{{ $user->course ?? 'Not provided' }}</p>
        </div>

        <div class="card">
            <h2>Year Level</h2>
            <p>{{ $user->year_level ?? 'Not provided' }}</p>
        </div>
    </div>
</div>
</body>
</html>
