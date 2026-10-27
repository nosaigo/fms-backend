<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Attendance Records') }}
            </h2>

            <!-- Print Button -->
            <button onclick="window.print()"
                style="background-color: #4F46E5 !important; color: white !important; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px;">
                🖨️ Print Official Logsheet
            </button>
        </div>
    </x-slot>

    <div style="padding: 32px;" class="no-print">
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
                        <button type="submit"
                            style="padding: 8px 16px; background-color: #1f2937; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                            Filter
                        </button>
                        <a href="{{ route('attendance.index') }}"
                            style="padding: 8px 16px; background: #e5e7eb; color: #374151; border-radius: 4px; text-decoration: none; font-weight: 600; margin-left: 4px;">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- On-Screen Table --}}
            <div
                style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f9fafb;">
                        <tr style="text-align: left; font-size: 12px; color: #6b7280; text-transform: uppercase;">
                            <th style="padding: 12px 16px;">Time</th>
                            <th style="padding: 12px 16px;">Faculty</th>
                            <th style="padding: 12px 16px;">Subject</th>
                            <th style="padding: 12px 16px;">Room</th>
                            <th style="padding: 12px 16px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $a)
                            <tr style="border-top: 1px solid #e5e7eb; font-size: 14px;">
                                <td style="padding: 12px 16px;">
                                    {{ \Carbon\Carbon::parse($a->recorded_time)->format('h:i A') }}</td>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 32px; text-align: center; color: #6b7280;">
                                    No attendance records found for this date.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 16px;" class="no-print">
                {{ $attendances->links() }}
            </div>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- OFFICIAL PRINT VIEW (HIDDEN ON SCREEN)     -->
    <!-- ========================================== -->
    <div class="print-only" style="display: none; padding: 20px;">

        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="font-size: 18px; font-weight: bold; margin: 0;">KALINGA STATE UNIVERSITY</h1>
            <h2 style="font-size: 14px; font-weight: bold; margin: 2px 0;">COLLEGE OF ENGINEERING & INFORMATION
                TECHNOLOGY (CEIT)</h2>
            <h3 style="font-size: 16px; font-weight: bold; margin: 10px 0;">DAILY FACULTY MONITORED ATTENDANCE LOGSHEET
            </h3>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 12px;">
            <tr>
                <td style="border: 1px solid #000; padding: 8px;"><strong>Date:</strong> {{ $date }}</td>
                <td style="border: 1px solid #000; padding: 8px;"><strong>Building/Wing:</strong> CEIT Main Building
                </td>
                <td style="border: 1px solid #000; padding: 8px;"><strong>Day:</strong>
                    {{ \Carbon\Carbon::parse($date)->format('l') }}</td>
                <td style="border: 1px solid #000; padding: 8px;"><strong>Assigned Clerk:</strong>
                    {{ Auth::user()->name }}</td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
            <thead>
                <tr style="background-color: #eee;">
                    <th style="border: 1px solid #000; padding: 6px; width: 40px;">#</th>
                    <th style="border: 1px solid #000; padding: 6px;">ROOM NO.</th>
                    <th style="border: 1px solid #000; padding: 6px;">SCHEDULED TIME</th>
                    <th style="border: 1px solid #000; padding: 6px;">SUBJECT & SECTION</th>
                    <th style="border: 1px solid #000; padding: 6px;">ASSIGNED FACULTY NAME</th>
                    <th style="border: 1px solid #000; padding: 6px; width: 60px;">STATUS (P/A/L)</th>
                    <th style="border: 1px solid #000; padding: 6px;">REMARKS / ACTUAL TIME CHECKED</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $index => $a)
                    <tr>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">
                            {{ $a->schedule->room->room_number ?? '-' }}</td>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">
                            {{ \Carbon\Carbon::parse($a->schedule->start_time)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($a->schedule->end_time)->format('h:i A') }}
                        </td>
                        <td style="border: 1px solid #000; padding: 6px;">{{ $a->schedule->subject ?? '-' }}
                            ({{ $a->schedule->section ?? '-' }})</td>
                        <td style="border: 1px solid #000; padding: 6px;">{{ $a->faculty->name ?? '-' }}</td>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold;">
                            @if($a->status === 'present') P
                            @elseif($a->status === 'absent') A
                            @else L
                            @endif
                        </td>
                        <td style="border: 1px solid #000; padding: 6px; text-align: center;">
                            {{ \Carbon\Carbon::parse($a->recorded_time)->format('h:i A') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="border: 1px solid #000; padding: 20px; text-align: center;">
                            No attendance records found for this date.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 15px; font-size: 11px; font-style: italic;">
            STATUS CODES: P = Present | A = Absent | L = On Official Leave /* Verification must be conducted physically
            during class hours.
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 50px; font-size: 12px;">
            <div style="text-align: center; width: 250px;">
                <div style="border-bottom: 1px solid #000; height: 30px;"></div>
                <div style="margin-top: 5px;">[Name & Signature of Monitoring Clerk]</div>
                <div>CEIT Monitoring Clerk</div>
            </div>
            <div style="text-align: center; width: 250px;">
                <div style="border-bottom: 1px solid #000; height: 30px;"></div>
                <div style="margin-top: 5px;">Noted & Approved By</div>
            </div>
        </div>
    </div>

</x-app-layout>