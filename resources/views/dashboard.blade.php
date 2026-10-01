<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Faculty Monitoring Dashboard') }}
            </h2>
            <div class="text-sm text-gray-600">
                {{ $todayName }} • {{ $currentTime }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Faculty</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats['faculty_count'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Rooms</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats['room_count'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total Schedules</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats['schedule_count'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Today's Classes</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats['today_schedule_count'] }}</div>
                </div>
            </div>

            {{-- Today's Attendance --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm text-gray-500">Recorded Today</div>
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['attendance_today'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm text-gray-500">Present</div>
                    <div class="text-3xl font-bold text-green-600">{{ $stats['present_today'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-sm text-gray-500">Absent</div>
                    <div class="text-3xl font-bold text-red-600">{{ $stats['absent_today'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                    <div class="text-sm text-gray-500">On Leave</div>
                    <div class="text-3xl font-bold text-orange-600">{{ $stats['on_leave_today'] }}</div>
                </div>
            </div>

            {{-- Currently Ongoing Classes --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        🟢 Currently Ongoing ({{ $currentSchedules->count() }})
                    </h3>
                    @if($currentSchedules->isEmpty())
                        <p class="text-gray-500">No classes happening right now.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($currentSchedules as $s)
                                <div class="flex justify-between items-center border-b pb-2">
                                    <div>
                                        <span class="font-semibold">{{ $s->subject }}</span>
                                        <span class="text-gray-500">• {{ $s->faculty->name }} • {{ $s->section }}</span>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        Room {{ $s->room->room_number }} • 
                                        {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }} - 
                                        {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent Attendance --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        📋 Recent Attendance Records
                    </h3>
                    @if($recentAttendance->isEmpty())
                        <p class="text-gray-500">No attendance records yet.</p>
                    @else
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-sm text-gray-500 border-b">
                                    <th class="pb-2">Time</th>
                                    <th class="pb-2">Faculty</th>
                                    <th class="pb-2">Subject</th>
                                    <th class="pb-2">Room</th>
                                    <th class="pb-2">Status</th>
                                    <th class="pb-2">Source</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAttendance as $a)
                                    <tr class="border-b text-sm">
                                        <td class="py-2">{{ \Carbon\Carbon::parse($a->recorded_time)->format('h:i A') }}</td>
                                        <td class="py-2">{{ $a->faculty->name ?? 'Unknown' }}</td>
                                        <td class="py-2">{{ $a->schedule->subject ?? '-' }}</td>
                                        <td class="py-2">{{ $a->schedule->room->room_number ?? '-' }}</td>
                                        <td class="py-2">
                                            @if($a->status === 'present')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Present</span>
                                            @elseif($a->status === 'absent')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Absent</span>
                                            @else
                                                <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded text-xs font-semibold">On Leave</span>
                                            @endif
                                        </td>
                                        <td class="py-2">
                                            @if($a->is_offline_record)
                                                <span class="text-orange-600 text-xs">📱 Offline</span>
                                            @else
                                                <span class="text-green-600 text-xs">🌐 Online</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
