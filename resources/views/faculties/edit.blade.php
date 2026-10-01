<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Faculty Member') }}
        </h2>
    </x-slot>

    <div style="padding: 32px;">
        <div
            style="max-width: 640px; margin: 0 auto; background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">

            <form method="POST" action="{{ route('faculties.update', $faculty) }}">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Full Name
                        *</label>
                    <input type="text" name="name" value="{{ old('name', $faculty->name) }}" required
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    @error('name')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $faculty->email) }}" required
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    @error('email')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Department
                        *</label>
                    <input type="text" name="department" value="{{ old('department', $faculty->department) }}" required
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    @error('department')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:24px;">
                    <a href="{{ route('faculties.index') }}"
                        style="display: inline-block; padding:10px 20px; background:#e5e7eb; color:#374151; border-radius:6px; text-decoration:none; font-weight:600;">
                        Cancel
                    </a>
                    <button type="submit"
                        style="display: inline-block; padding:10px 20px; background-color: #4F46E5 !important; color: white !important; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px; -webkit-appearance: none; appearance: none;">
                        Update Faculty
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
