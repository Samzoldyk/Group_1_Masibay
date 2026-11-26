<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Attendance') - SPAMAST SSG</title>

    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* --- HEADER --- */
        .top {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 40px;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            flex-wrap: wrap;
            gap: 16px;
        }

        .brand { color: #1d4ed8; font-weight: 800; font-size: 22px; letter-spacing: -0.5px; }
        .brand span { display: block; font-size: 10px; letter-spacing: 2px; color: #64748b; font-weight: 600; margin-top: 2px; }

        nav { display: flex; align-items: center; gap: 8px; }
        nav a {
            padding: 8px 12px;
            border-radius: 8px;
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
        }
        nav a:hover { color: #1d4ed8; background: #eff6ff; }

        /* --- MAIN LAYOUT --- */
        main { max-width: 1100px; margin: 40px auto; padding: 0 24px; }

        h1 { font-size: 28px; color: #0f172a; font-weight: 700; letter-spacing: -0.5px; }
        .head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }

        /* --- CARDS --- */
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            overflow-x: auto;
        }

        /* --- BUTTONS --- */
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            background: #2563eb; color: #fff; border: none;
            padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600;
            cursor: pointer; text-decoration: none; transition: all 0.2s; font-family: inherit;
        }
        .btn:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }

        .btn.ghost { background: #f1f5f9; color: #475569; }
        .btn.ghost:hover { background: #e2e8f0; box-shadow: none; transform: none; }

        .btn.danger { background: #ef4444; }
        .btn.danger:hover { background: #dc2626; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2); }

        .btn.small { padding: 6px 14px; font-size: 13px; }

        /* --- FORMS & INPUTS --- */
        .filters { display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; }
        select, input, textarea {
            padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px;
            font-size: 14px; font-family: inherit; background: #fff; color: #1e293b; transition: all 0.2s;
        }
        select:focus, input:focus, textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15); }

        /* --- TABLES --- */
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th {
            text-align: left; padding: 12px 16px; color: #64748b; font-size: 11px;
            text-transform: uppercase; letter-spacing: 1px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;
        }
        th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }

        td { padding: 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; color: #334155; }
        tr:hover td { background: #f8fafc; }
        td small { display: block; color: #94a3b8; font-size: 12px; margin-top: 4px; }
        .actions { display: flex; gap: 8px; }

        /* --- BADGES --- */
        .badge { padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; display: inline-block; }
        .badge.present { background: #dcfce7; color: #166534; }
        .badge.late { background: #fef3c7; color: #92400e; }
        .badge.absent { background: #fee2e2; color: #991b1b; }

        /* --- ALERTS --- */
        .alert { padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; border: 1px solid transparent; }
        .alert.ok { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
        .alert.bad { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
        .alert ul { margin-left: 18px; margin-top: 8px; }

        .empty { text-align: center; color: #64748b; padding: 40px 0; font-size: 15px; }
    </style>
</head>
<body>
    <header class="top">
        <div class="brand">
            SPAMAST SSG <span>EVENT MANAGEMENT SYSTEM</span>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}">Back to Dashboard</a>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('attendance.index') }}">Records</a>
            <a href="{{ route('attendance.create') }}">Record Attendance</a>
        </nav>
    </header>

    <main>
        @if (session('success'))
            <div class="alert ok">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert bad">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
