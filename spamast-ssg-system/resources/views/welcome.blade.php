<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPAMAST SSG | Event Management System</title>

    <!-- Modern Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* --- NAVIGATION --- */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            padding: 16px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .logo { font-size: 22px; font-weight: 800; color: #1d4ed8; letter-spacing: -0.5px; }
        .logo span { display: block; font-size: 10px; color: #64748b; letter-spacing: 2px; font-weight: 600; margin-top: 2px; }

        nav { display: flex; gap: 24px; align-items: center; }
        nav a { text-decoration: none; color: #475569; font-weight: 500; font-size: 14px; transition: color 0.2s; }
        nav a:hover { color: #1d4ed8; }

        .nav-button {
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .nav-button:hover { background: #1d4ed8; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); transform: translateY(-1px); }

        /* --- HERO SECTION --- */
        .hero {
            padding: 100px 8%;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
        }

        .hero-content { max-width: 600px; }

        .tag {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 24px;
            border: 1px solid #bfdbfe;
        }

        h1 {
            font-size: clamp(36px, 5vw, 56px);
            line-height: 1.1;
            margin-bottom: 24px;
            color: #0f172a;
            font-weight: 800;
            letter-spacing: -1px;
        }

        h1 span { color: #2563eb; }

        .hero p {
            color: #475569;
            font-size: 17px;
            max-width: 520px;
            margin-bottom: 32px;
            line-height: 1.7;
        }

        .buttons { display: flex; flex-wrap: wrap; gap: 12px; }

        .button {
            display: inline-block;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s;
        }

        .primary { background: #2563eb; color: white; }
        .primary:hover { background: #1d4ed8; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25); }

        .secondary { background: white; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .secondary:hover { background: #eff6ff; transform: translateY(-2px); }

        /* --- HERO CARD --- */
        .hero-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            min-width: 300px;
            max-width: 340px;
            width: 100%;
            box-shadow: 0 20px 50px rgba(30, 64, 175, 0.1);
            border: 1px solid #e2e8f0;
            transition: transform 0.3s ease;
        }
        .hero-card:hover { transform: translateY(-5px); }

        .hero-card .symbol { font-size: 48px; margin-bottom: 20px; }
        .hero-card h2 { font-size: 22px; margin-bottom: 12px; color: #0f172a; font-weight: 700; }
        .hero-card p { font-size: 15px; color: #64748b; margin-bottom: 0; line-height: 1.6; }

        /* --- FEATURES SECTION --- */
        .features { padding: 90px 8%; text-align: center; background: #fff; }

        .section-label {
            color: #2563eb;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .features h2 { font-size: 36px; margin: 12px 0; color: #0f172a; font-weight: 800; letter-spacing: -0.5px; }
        .section-description { color: #64748b; margin-bottom: 48px; font-size: 16px; max-width: 600px; margin-left: auto; margin-right: auto; }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
            text-align: left;
        }

        .feature {
            background: white;
            padding: 32px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(30, 64, 175, 0.08);
            border-color: #bfdbfe;
        }

        .feature-icon { font-size: 32px; margin-bottom: 16px; }
        .feature h3 { font-size: 18px; margin-bottom: 10px; color: #0f172a; font-weight: 700; }
        .feature p { color: #64748b; font-size: 14px; line-height: 1.6; }

        /* --- CTA SECTION --- */
        .cta {
            margin: 0 8% 90px;
            padding: 60px 40px;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            color: white;
            border-radius: 24px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(30, 64, 175, 0.2);
        }

        .cta h2 { font-size: 32px; margin-bottom: 12px; font-weight: 800; letter-spacing: -0.5px; }
        .cta p { color: #dbeafe; margin-bottom: 28px; font-size: 16px; }

        .cta .button.secondary { background: white; color: #1e40af; border: none; }
        .cta .button.secondary:hover { background: #f8fafc; }

        /* --- FOOTER --- */
        footer {
            padding: 30px 8%;
            background: #ffffff;
            color: #64748b;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .feature-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 900px) {
            .hero { flex-direction: column; align-items: flex-start; padding: 65px 6%; gap: 40px; }
            .hero-card { max-width: 100%; }
        }

        @media (max-width: 550px) {
            header { padding: 16px 5%; flex-wrap: wrap; }
            nav { flex-wrap: wrap; gap: 16px; }
            .hero { padding: 50px 5%; }
            .features { padding: 60px 5%; }
            .feature-grid { grid-template-columns: 1fr; }
            .features h2 { font-size: 28px; }
            .cta { margin: 0 5% 60px; padding: 40px 20px; }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            SPAMAST SSG
            <span>EVENT MANAGEMENT SYSTEM</span>
        </div>

        <nav>
            <a href="#home">Home</a>
            <a href="#features">Features</a>
            <a href="{{ route('login') }}" class="nav-button">Login</a>
        </nav>
    </header>

    <main>
        <!-- HERO -->
        <section class="hero" id="home">
            <div class="hero-content">
                <span class="tag">STUDENT LEADERSHIP • CAMPUS EVENTS</span>

                <h1>
                    Every Event.<br>
                    Every Student.<br>
                    <span>One System.</span>
                </h1>

                <p>
                    Welcome to the SPAMAST SSG Event Management System.
                    A centralized platform designed to organize campus
                    events, manage student participation, monitor attendance,
                    and keep track of sanctions.
                </p>

                <div class="buttons">
                    <a href="{{ route('register') }}" class="button primary">Get Started →</a>
                    <a href="#features" class="button secondary">Explore Features</a>
                </div>
            </div>

            <div class="hero-card">
                <div class="symbol">🎓</div>
                <h2>Organize. Participate. Lead.</h2>
                <p>Bringing student organizations and campus activities together through one organized digital platform.</p>
            </div>
        </section>

        <!-- FEATURES -->
        <section class="features" id="features">
            <span class="section-label">What You Can Do</span>
            <h2>Everything in One Place</h2>
            <p class="section-description">Tools to support student affairs and event management.</p>

            <div class="feature-grid">
                <article class="feature">
                    <div class="feature-icon">👥</div>
                    <h3>Register Students</h3>
                    <p>Organize student information and maintain accessible registration records.</p>
                </article>

                <article class="feature">
                    <div class="feature-icon">📅</div>
                    <h3>Manage Events</h3>
                    <p>Keep campus activities organized with clear event information and schedules.</p>
                </article>

                <article class="feature">
                    <div class="feature-icon">✅</div>
                    <h3>Attendance</h3>
                    <p>Record and monitor student attendance during school activities and events.</p>
                </article>

                <article class="feature">
                    <div class="feature-icon">⚖️</div>
                    <h3>Sanctions</h3>
                    <p>Maintain organized records of event-related sanctions and student accountability.</p>
                </article>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta" id="register">
            <h2>Be Part of Every Campus Event</h2>
            <p>Stay organized, stay informed, and stay involved.</p>
            <a href="{{ route('register') }}" class="button secondary">Register Now</a>
        </section>
    </main>

    <footer>
        <p>© <span id="year"></span> SPAMAST SSG Event Management System. All rights reserved.</p>
    </footer>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>

</body>
</html>
