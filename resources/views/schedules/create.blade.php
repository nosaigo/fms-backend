<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('schedules.store') }}">
                    @csrf

                    {{-- Faculty --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Faculty <span class="text-red-500">*</span>
                        </label>
                        <select name="faculty_id" required
                            class="w-full border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Select Faculty --</option>
                            @foreach($faculties as $f)
                                <option value="{{ $f->id }}" {{ old('faculty_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('faculty_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Room --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Room <span class="text-red-500">*</span>
                        </label>
                        <select name="room_id" required
                            class="w-full border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Select Room --</option>
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}" {{ old('room_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->room_number }} ({{ $r->building }})
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Subject --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Subject <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required
                            placeholder="e.g., IT 101"
                            class="w-full border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                        @error('subject')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Section --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Section <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="section" value="{{ old('section') }}" required
                            placeholder="e.g., A, B, C"
                            class="w-full border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                        @error('section')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Day --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Day <span class="text-red-500">*</span>
                        </label>
                        <select name="day" required
                            class="w-full border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Select Day --</option>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                        @error('day')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Time --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Start Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" required
                                class="w-full border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                            @error('start_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                End Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" required
                                class="w-full border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                            @error('end_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('schedules.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit"
                            style="display: inline-block; padding:10px 20px; background-color: #4F46E5 !important; color: white !important; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px; -webkit-appearance: none; appearance: none;">
                            Save Schedule
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
