<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Records') }}
        </h2>
    </x-slot>

    <div style="padding: 32px;">
        <div style="max-width: 1280px; margin: 0 auto;">

            {{-- Stats Cards --}}
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
                <div
                    style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #3b82f6; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="font-size: 14px; color: #6b7280;">Total</div>
                    <div style="font-size: 28px; font-weight: bold; color: #3b82f6;">{{ $stats['total'] }}</div>
                </div>
                <div
                    style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #10b981; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="font-size: 14px; color: #6b7280;">Present</div>
                    <div style="font-size: 28px; font-weight: bold; color: #10b981;">{{ $stats['present'] }}</div>
                </div>
                <div
                    style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #ef4444; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="font-size: 14px; color: #6b7280;">Absent</div>
                    <div style="font-size: 28px; font-weight: bold; color: #ef4444;">{{ $stats['absent'] }}</div>
                </div>
                <div
                    style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #f59e0b; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="font-size: 14px; color: #6b7280;">On Leave</div>
                    <div style="font-size: 28px; font-weight: bold; color: #f59e0b;">{{ $stats['on_leave'] }}</div>
                </div>
            </div>

            {{-- Filters --}}
            <div
                style="background: white; padding: 16px; border-radius: 8px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <form method="GET" action="{{ route('attendance.index') }}"
                    style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
                    <div>
                        <label style="display:block; font-size:14px; margin-bottom:4px;">Date</label>
                        <input type="date" name="date" value="{{ $date }}"
                            style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display:block; font-size:14px; margin-bottom:4px;">Faculty</label>
                        <select name="faculty_id" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="">All Faculty</option>
                            @foreach($faculties as $f)
                                <option value="{{ $f->id }}" {{ request('faculty_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:14px; margin-bottom:4px;">Status</label>
                        <select name="status" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="">All Statuses</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present
                            </option>
                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave
                            </option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:14px; margin-bottom:4px;">Source</label>
                        <select name="source" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="">All Sources</option>
                            <option value="online" {{ request('source') == 'online' ? 'selected' : '' }}>Online (API)
                            </option>
                            <option value="offline" {{ request('source') == 'offline' ? 'selected' : '' }}>Offline
                                (Synced)</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit"
                            style="padding: 8px 16px; background-color: #1f2937 !important; color: white !important; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; -webkit-appearance: none;">
                            Filter
                        </button>
                        <a href="{{ route('attendance.index') }}"
                            style="padding: 8px 16px; background: #e5e7eb; color: #374151; border-radius: 4px; text-decoration: none; font-weight: 600; margin-left: 4px;">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div
                style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f9fafb;">
                        <tr style="text-align: left; font-size: 12px; color: #6b7280; text-transform: uppercase;">
                            <th style="padding: 12px 16px;">Time</th>
                            <th style="padding: 12px 16px;">Date</th>
                            <th style="padding: 12px 16px;">Faculty</th>
                            <th style="padding: 12px 16px;">Subject</th>
                            <th style="padding: 12px 16px;">Room</th>
                            <th style="padding: 12px 16px;">Status</th>
                            <th style="padding: 12px 16px;">Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $a)
                            <tr style="border-top: 1px solid #e5e7eb; font-size: 14px;">
                                <td style="padding: 12px 16px;">
                                    {{ \Carbon\Carbon::parse($a->recorded_time)->format('h:i A') }}</td>
                                <td style="padding: 12px 16px;">{{ $a->date }}</td>
                                <td style="padding: 12px 16px; font-weight: 500;">{{ $a->faculty->name ?? '-' }}</td>
                                <td style="padding: 12px 16px;">{{ $a->schedule->subject ?? '-' }}</td>
                                <td style="padding: 12px 16px;">{{ $a->schedule->room->room_number ?? '-' }}</td>
                                <td style="padding: 12px 16px;">
                                    @if($a->status === 'present')
                                        <span
                                            style="padding: 4px 8px; background: #d1fae5; color: #065f46; border-radius: 4px; font-size: 12px; font-weight: 600;">Present</span>
                                    @elseif($a->status === 'absent')
                                        <span
                                            style="padding: 4px 8px; background: #fee2e2; color: #991b1b; border-radius: 4px; font-size: 12px; font-weight: 600;">Absent</span>
                                    @else
                                        <span
                                            style="padding: 4px 8px; background: #fed7aa; color: #9a3412; border-radius: 4px; font-size: 12px; font-weight: 600;">On
                                            Leave</span>
                                    @endif
                                </td>
                                <td style="padding: 12px 16px;">
                                    @if($a->is_offline_record)
                                        <span style="color: #ea580c; font-size: 12px;">📱 Offline</span>
                                    @else
                                        <span style="color: #16a34a; font-size: 12px;">🌐 Online</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 32px; text-align: center; color: #6b7280;">
                                    No attendance records found for this date.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 16px;">
                {{ $attendances->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
