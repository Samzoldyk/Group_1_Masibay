<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Announcement | SPAMAST SSG</title>
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
    <h1>Create Announcement</h1>

    @if($errors->any())
        <ul class="error">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Title</label>
        <input type="text" name="title" value="{{ old('title') }}" required>

        <label>Content</label>
        <textarea name="content" required>{{ old('content') }}</textarea>

        <label>Publishing Date and Time</label>
        <input type="datetime-local" name="published_at" value="{{ old('published_at') }}">

        <label>Attachment (PDF, DOC, DOCX, JPG, PNG)</label>
        <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">

        <button type="submit">Publish Announcement</button>
    </form>

    <p><a href="{{ route('announcements.index') }}">Back to Announcements</a></p>
</div>
</body>
</html>
