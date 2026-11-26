<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Announcement | SPAMAST SSG</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; }
        .container { max-width: 700px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        input, textarea { width: 100%; padding: 12px; margin: 8px 0 18px; box-sizing: border-box; }
        textarea { min-height: 180px; }
        button { background: #176b3a; color: white; padding: 12px 20px; border: 0; border-radius: 5px; cursor: pointer; }
        .error { color: #b42318; }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Announcement</h1>

    @if($errors->any())
        <ul class="error">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Title</label>
        <input type="text" name="title"
               value="{{ old('title', $announcement->title) }}" required>

        <label>Content</label>
        <textarea name="content" required>{{ old('content', $announcement->content) }}</textarea>

        <label>Publishing Date and Time</label>
        <input type="datetime-local" name="published_at"
               value="{{ old('published_at', $announcement->published_at?->format('Y-m-d\TH:i')) }}">

        <label>Replace Attachment (Optional)</label>
        <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">

        @if($announcement->attachment_path)
            <p>
                Current attachment:
                <a href="{{ asset('storage/' . $announcement->attachment_path) }}" target="_blank">View attachment</a>
            </p>
        @endif

        <button type="submit">Update Announcement</button>
    </form>

    <p><a href="{{ route('announcements.index') }}">Back to Announcements</a></p>
</div>
</body>
</html>
