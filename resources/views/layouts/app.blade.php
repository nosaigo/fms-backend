<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Faculty Monitoring System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


</head>

<body style="margin: 0; font-family: 'Figtree', sans-serif; background: #f3f4f6;">
    <div style="display: flex; min-height: 100vh;">

        {{-- SIDEBAR --}}
        <aside
            style="width: 240px; background: #1e293b; color: white; display: flex; flex-direction: column; flex-shrink: 0;">

            {{-- Logo --}}
            <div
                style="padding: 20px; border-bottom: 1px solid #334155; display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('images/ksu-logo.png') }}" alt="KSU"
                    style="width: 40px; height: 40px; border-radius: 8px;">
                <div>
                    <div style="font-weight: 700; font-size: 14px;">FMS</div>
                    <div style="font-size: 10px; color: #94a3b8;">Faculty Monitoring</div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav style="flex: 1; padding: 16px 8px;">
                <a href="{{ route('dashboard') }}"
                    style="display: block; padding: 12px 16px; margin-bottom: 4px; border-radius: 8px; text-decoration: none; color: {{ request()->routeIs('dashboard') ? 'white' : '#cbd5e1' }}; background: {{ request()->routeIs('dashboard') ? '#4F46E5' : 'transparent' }}; font-size: 14px; font-weight: 500;">
                    📊 Dashboard
                </a>
                <a href="{{ route('schedules.index') }}"
                    style="display: block; padding: 12px 16px; margin-bottom: 4px; border-radius: 8px; text-decoration: none; color: {{ request()->routeIs('schedules.*') ? 'white' : '#cbd5e1' }}; background: {{ request()->routeIs('schedules.*') ? '#4F46E5' : 'transparent' }}; font-size: 14px; font-weight: 500;">
                    📅 Schedules
                </a>
                <a href="{{ route('attendance.index') }}"
                    style="display: block; padding: 12px 16px; margin-bottom: 4px; border-radius: 8px; text-decoration: none; color: {{ request()->routeIs('attendance.*') ? 'white' : '#cbd5e1' }}; background: {{ request()->routeIs('attendance.*') ? '#4F46E5' : 'transparent' }}; font-size: 14px; font-weight: 500;">
                    ✓ Attendance
                </a>
                <a href="{{ route('faculties.index') }}"
                    style="display: block; padding: 12px 16px; margin-bottom: 4px; border-radius: 8px; text-decoration: none; color: {{ request()->routeIs('faculties.*') ? 'white' : '#cbd5e1' }}; background: {{ request()->routeIs('faculties.*') ? '#4F46E5' : 'transparent' }}; font-size: 14px; font-weight: 500;">
                    👥 Faculty
                </a>
                <a href="{{ route('rooms.index') }}"
                    style="display: block; padding: 12px 16px; margin-bottom: 4px; border-radius: 8px; text-decoration: none; color: {{ request()->routeIs('rooms.*') ? 'white' : '#cbd5e1' }}; background: {{ request()->routeIs('rooms.*') ? '#4F46E5' : 'transparent' }}; font-size: 14px; font-weight: 500;">
                    🚪 Rooms
                </a>
            </nav>

            {{-- User Section at Bottom --}}
            <div style="padding: 16px; border-top: 1px solid #334155;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <div
                        style="width: 36px; height: 36px; background: #4F46E5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 13px; font-weight: 600;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 11px; color: #94a3b8;">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}"
                    style="display: block; padding: 8px 12px; margin-bottom: 4px; border-radius: 6px; text-decoration: none; color: #cbd5e1; font-size: 13px;">
                    ⚙️ Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        style="width: 100%; text-align: left; padding: 8px 12px; background: transparent; border: none; color: #cbd5e1; cursor: pointer; border-radius: 6px; font-size: 13px;">
                        🚪 Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">

            {{-- HEADER --}}
            <header style="background: white; border-bottom: 1px solid #e5e7eb; padding: 16px 32px;">
                @isset($header)
                    {{ $header }}
                @else
                    <h1 style="margin: 0; font-size: 20px; font-weight: 600; color: #1f2937;">
                        Faculty Monitoring System
                    </h1>
                @endisset
            </header>

            {{-- PAGE CONTENT --}}
            <main style="flex: 1; overflow-y: auto;">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
