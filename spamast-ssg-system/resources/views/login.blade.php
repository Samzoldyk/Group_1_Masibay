<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPAMAST SSG</title>

    <!-- Modern Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc; /* Unified soft background */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        .card {
            background: #fff;
            width: 100%;
            max-width: 420px;
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

        label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #334155; }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            margin-bottom: 20px;
            outline: none;
            font-family: inherit;
            transition: all 0.2s;
        }
        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .remember input {
            width: auto;
            padding: 0;
            margin: 0;
            cursor: pointer;
        }
        .remember label {
            margin: 0;
            font-weight: 500;
            color: #475569;
            cursor: pointer;
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

        <h1>Welcome back</h1>
        <p class="sub">Log in to your account to continue.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <div class="remember">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit">Login</button>
        </form>

        <p class="switch">No account yet? <a href="{{ route('register') }}">Register here</a></p>
        <a class="back" href="{{ url('/') }}">&larr; Back to home</a>
    </div>
</body>
</html>
