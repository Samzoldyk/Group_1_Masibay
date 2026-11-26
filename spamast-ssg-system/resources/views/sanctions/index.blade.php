<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sanctions Management | SPAMAST SSG</title>

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

        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 32px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        /* --- HEADER --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        h1 { margin: 0 0 6px 0; color: #0f172a; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { margin: 0; color: #64748b; font-size: 14px; }

        .header-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

        /* --- BUTTONS --- */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            font-family: inherit;
            border: none;
            cursor: pointer;
        }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }

        .btn-success { background: #059669; color: #fff; }
        .btn-success:hover { background: #047857; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2); }

        .btn-ghost { background: #f1f5f9; color: #475569; }
        .btn-ghost:hover { background: #e2e8f0; }

        /* --- ALERTS --- */
        .alert-success {
            background: #f0fdf4; color: #166534; padding: 14px 20px;
            border-radius: 12px; margin-bottom: 24px; border: 1px solid #bbf7d0;
            font-weight: 500; font-size: 14px;
        }

        /* --- TABLE --- */
        .table-wrap { overflow-x: auto; }
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

        /* --- STATUS BADGES --- */
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: #fef3c7; /* Default yellow */
            color: #92400e;
        }
        /* Dynamic Badge Colors based on your DB status */
        .status.resolved, .status.completed { background: #dcfce7; color: #166534; }
        .status.pending, .status.unresolved { background: #fef3c7; color: #92400e; }
        .status.overdue, .status.cancelled { background: #fee2e2; color: #991b1b; }

        /* --- ACTION LINKS --- */
        .edit-link { color: #2563eb; font-weight: 600; text-decoration: none; transition: color 0.2s; }
        .edit-link:hover { color: #1d4ed8; text-decoration: underline; }

        .empty { text-align: center; padding: 40px; color: #64748b; font-size: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>Sanctions Management</h1>
                <p>SPAMAST Supreme Student Government</p>
            </div>

            <div class="header-actions">
                <a class="btn btn-ghost" href="{{ route('dashboard') }}">← Back</a>
                <a class="btn btn-success" href="{{ route('sanctions.create') }}">+ Add Sanction</a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-ghost">Logout</button>
                </form>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-success" style="background: #fef2f2; color: #991b1b; border-color: #fecaca;">
                Please check the form for errors.
            </div>
        @endif

        <!-- Table -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Event</th>
                        <th>Sanction</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sanctions as $sanction)
                        <tr>
                            <td>{{ $sanction->student_id }}</td>
                            <td>{{ $sanction->student_name }}</td>
                            <td>{{ $sanction->event_name }}</td>
                            <td>{{ $sanction->sanction_type }}</td>
                            <td>{{ $sanction->sanction_date?->format('M d, Y') ?? '—' }}</td>
                            <td>
                                <!-- Added strtolower to class for CSS matching -->
                                <span class="status {{ strtolower($sanction->status) }}">
                                    {{ str($sanction->status)->replace('_', ' ')->title() }}
                                </span>
                            </td>
                            <td>
                                <a class="edit-link" href="{{ route('sanctions.edit', $sanction) }}">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">
                                No sanction records yet. Click "+ Add Sanction" to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Container (to give it some spacing) -->
        <div style="margin-top: 24px;">
            {{ $sanctions->links() }}
        </div>
    </div>
</body>
</html>
