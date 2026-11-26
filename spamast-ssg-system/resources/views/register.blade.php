<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SPAMAST SSG</title>

    <!-- Modern Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        .card {
            background: #fff;
            width: 100%;
            max-width: 460px; /* Slightly wider for the form */
            padding: 40px 36px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.08);
        }

        .brand { text-align: center; margin-bottom: 28px; }
        .brand h2 { color: #1d4ed8; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; }
        .brand span {
            display: block;
            font-size: 11px;
            letter-spacing: 3px;
            color: #64748b;
            margin-top: 4px;
            font-weight: 600;
        }

        h1 { font-size: 24px; color: #0f172a; margin-bottom: 6px; font-weight: 700; }
        .sub { color: #64748b; font-size: 14px; margin-bottom: 28px; }

        label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            color: #334155;
        }

        input, select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            margin-bottom: 20px;
            outline: none;
            background: #fff;
            font-family: inherit;
            transition: all 0.2s;
            color: #1e293b;
        }

        input:focus, select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        button {
            width: 100%;
            padding: 14px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
            margin-top: 8px;
        }

        button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .error {
            background: #fef2f2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
            font-weight: 500;
        }

        .error ul { margin-left: 18px; }
        .error ul li { margin-bottom: 4px; }

        .switch { text-align: center; margin-top: 24px; font-size: 14px; color: #64748b; }
        .switch a { color: #2563eb; font-weight: 600; text-decoration: none; }
        .switch a:hover { text-decoration: underline; }

        .back { display: block; text-align: center; margin-top: 16px; font-size: 13px; color: #64748b; text-decoration: none; transition: color 0.2s; }
        .back:hover { color: #1d4ed8; }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">
            <h2>SPAMAST SSG</h2>
            <span>EVENT MANAGEMENT SYSTEM</span>
        </div>

        <h1>Student Registration</h1>
        <p class="sub">Create your student account to join campus events.</p>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="student_id">Student ID</label>
            <input type="text" id="student_id" name="student_id"
                value="{{ old('student_id') }}"
                placeholder="e.g. 2024-00123" required>

            <label for="name">Full Name</label>
            <input type="text" id="name" name="name"
                value="{{ old('name') }}"
                placeholder="Juan Dela Cruz" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email') }}"
                placeholder="you@example.com" required>

            <label for="program_id">Institute and Program</label>
            <select id="program_id" name="program_id" required>
                <option value="">Select your program</option>

                @foreach ($institutes as $institute)
                    @if ($institute->programs->isNotEmpty())
                        <optgroup label="{{ $institute->code }} - {{ $institute->name }}">
                            @foreach ($institute->programs as $program)
                                <option value="{{ $program->id }}"
                                    {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>

            <label for="year_level">Year Level</label>
            <input type="text" id="year_level" name="year_level"
                value="{{ old('year_level') }}"
                placeholder="e.g. 1st Year">

            <label for="contact_number">Contact Number</label>
            <input type="text" id="contact_number" name="contact_number"
                value="{{ old('contact_number') }}"
                placeholder="09xxxxxxxxx">

            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                placeholder="At least 8 characters" required>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation"
                name="password_confirmation"
                placeholder="Repeat your password" required>

            <button type="submit">Register</button>
        </form>

        <p class="switch">Already have an account?
            <a href="{{ route('login') }}">Login here</a>
        </p>

        <a class="back" href="{{ url('/') }}">&larr; Back to home</a>
    </div>
</body>
</html>
