<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | SPAMAST SSG</title>

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

        .container { max-width: 900px; margin: auto; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 15px;
        }

        h1 {
            color: #0f172a;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 24px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .back-link:hover { color: #2563eb; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            transition: all 0.2s;
        }

        .btn-primary { background: #2563eb; color: white; }
        .btn-primary:hover { background: #1d4ed8; }

        .btn-ghost { background: #f1f5f9; color: #475569; }
        .btn-ghost:hover { background: #e2e8f0; }

        .btn-danger { background: #fef2f2; color: #dc2626; }
        .btn-danger:hover { background: #fee2e2; }

        .btn-sm { padding: 8px 14px; font-size: 13px; }

        .success {
            background: #f0fdf4;
            color: #166534;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            border: 1px solid #bbf7d0;
            font-weight: 500;
            font-size: 14px;
        }

        .announcement {
            background: white;
            padding: 28px;
            margin-bottom: 20px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease-in-out;
        }

        .announcement:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }

        .announcement h2 {
            color: #0f172a;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .muted {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .announcement p.content {
            color: #334155;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .attachment {
            margin-bottom: 20px;
        }

        .attachment a {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .attachment a:hover { text-decoration: underline; }

        .actions {
            display: flex;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 16px;
            border: 1px dashed #cbd5e1;
        }

        .empty-state .icon {
            font-size: 48px;
            display: block;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            color: #0f172a;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #64748b;
            font-size: 14px;
        }

        .pagination { margin-top: 32px; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Announcements</h1>
        <a href="{{ route('announcements.create') }}" class="btn btn-primary">
            + Create Announcement
        </a>
    </div>

    <a href="{{ route('dashboard') }}" class="back-link">
        &larr; Back to Dashboard
    </a>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @forelse($announcements as $announcement)
        <div class="announcement">
            <h2>{{ $announcement->title }}</h2>

            <div class="muted">
                <span>👤 {{ $announcement->author?->name ?? 'Unknown' }}</span>
                <span>•</span>
                <span>
                    🕒 {{ $announcement->published_at?->format('M d, Y h:i A') ?? 'Not published' }}
                </span>
            </div>

            <p class="content">{!! nl2br(e($announcement->short_content)) !!}</p>

            @if($announcement->attachment_path)
                <div class="attachment">
                    <a href="{{ asset('storage/' . $announcement->attachment_path) }}" target="_blank">
                        📎 View Attachment
                    </a>
                </div>
            @endif

            <div class="actions">
                <a href="{{ route('announcements.edit', $announcement) }}" class="btn btn-ghost btn-sm">
                    Edit
                </a>

                <form action="{{ route('announcements.destroy', $announcement) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this announcement?')"
                      style="margin: 0;">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <span class="icon">📢</span>
            <h3>No announcements yet</h3>
            <p>Click the "Create Announcement" button above to post your first update.</p>
        </div>
    @endforelse

    <div class="pagination">
        {{ $announcements->links() }}
    </div>

</div>
</body>
</html>
