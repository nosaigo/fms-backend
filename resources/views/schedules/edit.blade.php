<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Schedule') }}
        </h2>
    </x-slot>

    <div style="padding: 32px;">
        <div
            style="max-width: 640px; margin: 0 auto; background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">

            <form method="POST" action="{{ route('schedules.update', $schedule) }}">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Faculty *</label>
                    <select name="faculty_id" required
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                        @foreach($faculties as $f)
                            <option value="{{ $f->id }}" {{ old('faculty_id', $schedule->faculty_id) == $f->id ? 'selected' : '' }}>
                                {{ $f->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('faculty_id')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Room *</label>
                    <select name="room_id" required
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                        @foreach($rooms as $r)
                            <option value="{{ $r->id }}" {{ old('room_id', $schedule->room_id) == $r->id ? 'selected' : '' }}>
                                {{ $r->room_number }} ({{ $r->building }})
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Subject *</label>
                    <input type="text" name="subject" value="{{ old('subject', $schedule->subject) }}" required
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    @error('subject')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Section *</label>
                    <input type="text" name="section" value="{{ old('section', $schedule->section) }}" required
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    @error('section')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Day *</label>
                    <select name="day" required
                        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <option value="{{ $day }}" {{ old('day', $schedule->day) == $day ? 'selected' : '' }}>{{ $day }}
                            </option>
                        @endforeach
                    </select>
                    @error('day')
                    <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">Start Time
                            *</label>
                        <input type="time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}"
                            required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                        @error('start_time')
                        <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:14px; font-weight:500; margin-bottom:4px;">End Time
                            *</label>
                        <input type="time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}" required
                            style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                        @error('end_time')
                        <p style="color:red; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:24px;">
                    <a href="{{ route('schedules.index') }}"
                        style="display: inline-block; padding:10px 20px; background:#e5e7eb; color:#374151; border-radius:6px; text-decoration:none; font-weight:600;">
                        Cancel
                    </a>
                    <button type="submit"
                        style="display: inline-block; padding:10px 20px; background-color: #4F46E5 !important; color: white !important; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px; -webkit-appearance: none; appearance: none;">
                        Update Schedule
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
