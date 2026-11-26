<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile | SPAMAST SSG</title>

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

        /* --- MAIN CARD --- */
        .card {
            max-width: 700px; /* Wider to accommodate 2 columns */
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        h1 { color: #0f172a; margin-top: 0; margin-bottom: 24px; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }

        /* --- FORM ELEMENTS --- */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }

        input, select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            color: #1e293b;
            background: #fff;
            transition: all 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        input[readonly] {
            background: #f1f5f9;
            color: #64748b;
            cursor: not-allowed;
            border-color: #e2e8f0;
        }

        /* --- 2 COLUMN LAYOUT --- */
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* --- MESSAGES --- */
        .error { color: #dc2626; font-size: 13px; margin-top: 6px; font-weight: 500; }
        .success {
            background: #f0fdf4;
            color: #166534;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            border: 1px solid #bbf7d0;
            font-weight: 500;
        }
        .hint { color: #64748b; font-size: 13px; margin-top: 6px; }

        /* --- BUTTONS & LINKS --- */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .back-link {
            display: inline-block;
            margin-top: 24px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .back-link:hover { color: #1d4ed8; }

        /* --- PASSWORD SECTION DIVIDER --- */
        .password-section {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }
        .password-section h2 {
            font-size: 18px;
            color: #0f172a;
            margin-bottom: 16px;
            font-weight: 700;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>Edit Profile</h1>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Student ID</label>
            <input type="text" value="{{ $student->student_id }}" readonly>
        </div>

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}">
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="program_id">Institute and Program</label>
            <select id="program_id" name="program_id">
                <option value="">Select your program</option>
                @foreach ($institutes as $institute)
                    @if ($institute->programs->isNotEmpty())
                        <optgroup label="{{ $institute->code }} - {{ $institute->name }}">
                            @foreach ($institute->programs as $program)
                                <option value="{{ $program->id }}"
                                    {{ old('program_id', $student->program_id) == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>
            @error('program_id')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 2 Column Row -->
        <div class="row">
            <div class="form-group">
                <label for="year_level">Year Level</label>
                <input type="text" id="year_level" name="year_level" value="{{ old('year_level', $student->year_level) }}">
                @error('year_level')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}">
                @error('contact_number')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Password Section -->
        <div class="password-section">
            <h2>Change Password</h2>

            <div class="form-group">
               <label for="current_password">Current Password</label>
               <input type="password" id="current_password" name="current_password"
                autocomplete="current-password">
                @error('current_password')
                <div class="error">{{ $message }}</div>
                @enderror
                </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password">
                <div class="hint">Leave blank to keep your current password.</div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>
        </div>

        <div style="margin-top: 32px; display: flex; align-items: center; justify-content: space-between;">
            <button type="submit" class="btn">Save Changes</button>
            <a href="{{ route('dashboard') }}" class="back-link">← Back to dashboard</a>
        </div>
    </form>
</div>
</body>
</html>
