<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Class Schedules') }}
            </h2>
            <a href="{{ route('schedules.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                + Add Schedule
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Add Button --}}
            <div style="margin-bottom: 16px; display: flex; justify-content: flex-end;">
                <a href="{{ route('schedules.create') }}"
                    style="display: inline-block; padding: 10px 20px; background-color: #4F46E5; color: white; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px;">
                    + Add Schedule
                </a>
            </div>

            {{-- Filters --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('schedules.index') }}" class="flex gap-4 flex-wrap items-end">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Day</label>
                        <select name="day" class="border-gray-300 rounded">
                            <option value="">All Days</option>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Faculty</label>
                        <select name="faculty_id" class="border-gray-300 rounded">
                            <option value="">All Faculty</option>
                            @foreach($faculties as $f)
                                <option value="{{ $f->id }}" {{ request('faculty_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                        Filter
                    </button>
                    <a href="{{ route('schedules.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Reset
                    </a>
                </form>
            </div>

            {{-- Schedules Table --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs text-gray-500 uppercase">
                            <th class="px-4 py-3">Day</th>
                            <th class="px-4 py-3">Time</th>
                            <th class="px-4 py-3">Subject</th>
                            <th class="px-4 py-3">Section</th>
                            <th class="px-4 py-3">Faculty</th>
                            <th class="px-4 py-3">Room</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $s)
                            <tr class="border-t text-sm">
                                <td class="px-4 py-3">{{ $s->day }}</td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}
                                </td>
                                <td class="px-4 py-3 font-medium">{{ $s->subject }}</td>
                                <td class="px-4 py-3">{{ $s->section }}</td>
                                <td class="px-4 py-3">{{ $s->faculty->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $s->room->room_number ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('schedules.edit', $s) }}"
                                        class="text-indigo-600 hover:underline mr-3">Edit</a>
                                    <form action="{{ route('schedules.destroy', $s) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete this schedule?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    No schedules found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $schedules->links() }}
            </div>

        </div>
    </div>
</x-app-layout>