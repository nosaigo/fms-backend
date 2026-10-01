<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faculty Monitoring System - Kalinga State University</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            width: 100%;
            text-align: center;
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: 800;
            color: #4F46E5;
            margin-bottom: 32px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .subtitle {
            font-size: 20px;
            opacity: 0.9;
            margin-bottom: 48px;
        }

        .buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 40px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: white;
            color: #4F46E5;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .features {
            margin-top: 64px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
        }

        .feature {
            background: rgba(255, 255, 255, 0.1);
            padding: 24px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .feature-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .feature-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 13px;
            opacity: 0.8;
            line-height: 1.5;
        }

        .footer {
            margin-top: 64px;
            font-size: 13px;
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo-circle">F</div>

        <h1>Faculty Monitoring System</h1>
        <p class="subtitle">Kalinga State University — College of Engineering and Information Technology</p>

        <div class="buttons">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    Go to Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="btn btn-secondary">
                    Register
                </a>
            @endauth
        </div>

        <div class="features">
            <div class="feature">
                <div class="feature-icon">📱</div>
                <div class="feature-title">Mobile App</div>
                <div class="feature-desc">Android app for real-time faculty attendance monitoring</div>
            </div>
            <div class="feature">
                <div class="feature-icon">📊</div>
                <div class="feature-title">Web Dashboard</div>
                <div class="feature-desc">Manage schedules, faculty, rooms, and attendance</div>
            </div>
            <div class="feature">
                <div class="feature-icon">📶</div>
                <div class="feature-title">Offline-First</div>
                <div class="feature-desc">Records attendance even without internet, syncs automatically</div>
            </div>
            <div class="feature">
                <div class="feature-icon">⚡</div>
                <div class="feature-title">Real-Time Sync</div>
                <div class="feature-desc">Data syncs instantly between the mobile app and web system</div>
            </div>
        </div>

        <div class="footer">
            © {{ date('Y') }} Kalinga State University. All rights reserved.
        </div>
    </div>
</body>

</html>
