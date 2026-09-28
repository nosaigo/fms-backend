<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Room') }}
        </h2>
    </x-slot>

    <div style="padding: 32px;">
        <div
            style="max-width: 640px; margin: 0 auto; background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">

            <form method="POST" action="{{ route('rooms.store') }}">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Room Number
                        *</label>
                    <input type="text" name="room_number" value="{{ old('room_number') }}" required
                        placeholder="e.g., CEIT-401"
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    @error('room_number')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Building *</label>
                    <input type="text" name="building" value="{{ old('building', 'CEIT Building') }}" required
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    @error('building')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Capacity *</label>
                    <input type="number" name="capacity" value="{{ old('capacity', 40) }}" required min="1" max="500"
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    @error('capacity')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:24px;">
                    <a href="{{ route('rooms.index') }}"
                        style="display: inline-block; padding:10px 20px; background:#e5e7eb; color:#374151; border-radius:6px; text-decoration:none; font-weight:600;">
                        Cancel
                    </a>
                    <button type="submit"
                        style="display: inline-block; padding:10px 20px; background-color: #4F46E5 !important; color: white !important; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px; -webkit-appearance: none; appearance: none;">
                        Save Room
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>