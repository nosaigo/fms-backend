<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - Faculty Monitoring System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />



    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #1f2937 !important;
            box-shadow: 0 0 0 30px white inset !important;
        }
    </style>
</head>

<body
    style="margin: 0; font-family: 'Figtree', sans-serif; background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">

    <div style="width: 100%; max-width: 440px;">

        {{-- Logo Section --}}
        <div style="text-align: center; margin-bottom: 32px;">
            <div
                style="width: 80px; height: 80px; background: white; border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 800; color: #4F46E5; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
                F
            </div>
            <h1 style="color: white; font-size: 24px; font-weight: 700; margin: 16px 0 4px 0;">Create an Account</h1>
            <p style="color: rgba(255,255,255,0.8); font-size: 14px; margin: 0;">Faculty Monitoring System</p>
        </div>

        {{-- Register Card --}}
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 25px 50px rgba(0,0,0,0.25);">

            <h2 style="font-size: 20px; font-weight: 700; color: #1f2937; margin: 0 0 4px 0;">Get started</h2>
            <p style="font-size: 14px; color: #6b7280; margin: 0 0 24px 0;">Fill in the details to register</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div style="margin-bottom: 16px;">
                    <label for="name"
                        style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Full Name
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder=""
                        style="width: 100%; padding: 12px 14px; background: white !important; color: #1f2937; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box; outline: none;">
                    @error('name')
                        <p style="color: #dc2626; font-size: 12px; margin: 6px 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div style="margin-bottom: 16px;">
                    <label for="email"
                        style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder=""
                        style="width: 100%; padding: 12px 14px; background: white !important; color: #1f2937; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box; outline: none;">
                    @error('email')
                        <p style="color: #dc2626; font-size: 12px; margin: 6px 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div style="margin-bottom: 16px;">
                    <label for="password"
                        style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required placeholder=""
                        style="width: 100%; padding: 12px 14px; background: white !important; color: #1f2937; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box; outline: none;">
                    @error('password')
                        <p style="color: #dc2626; font-size: 12px; margin: 6px 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div style="margin-bottom: 24px;">
                    <label for="password_confirmation"
                        style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        placeholder=""
                        style="width: 100%; padding: 12px 14px; background: white !important; color: #1f2937; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box; outline: none;">
                    @error('password_confirmation')
                        <p style="color: #dc2626; font-size: 12px; margin: 6px 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    style="width: 100%; padding: 14px; background-color: #4F46E5 !important; color: white !important; border: none; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; -webkit-appearance: none;">
                    Create Account
                </button>

                {{-- Login Link --}}
                <p style="text-align: center; font-size: 13px; color: #6b7280; margin: 20px 0 0 0;">
                    Already have an account?
                    <a href="{{ route('login') }}" style="color: #4F46E5; font-weight: 600; text-decoration: none;">
                        Sign In
                    </a>
                </p>
            </form>
        </div>

        {{-- Back to Home --}}
        <p style="text-align: center; margin-top: 24px;">
            <a href="{{ route('home') }}" style="color: rgba(255,255,255,0.8); font-size: 13px; text-decoration: none;">
                ← Back to Home
            </a>
        </p>

    </div>

</body>

</html>
