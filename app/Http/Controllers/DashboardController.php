<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Faculty;
use App\Models\Room;
use App\Models\Schedule;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $todayName = Carbon::now()->format('l');
        $currentTime = Carbon::now()->format('h:i A');

        // Stats
        $stats = [
            'faculty_count' => Faculty::count(),
            'room_count' => Room::count(),
            'schedule_count' => Schedule::count(),
            'today_schedule_count' => Schedule::where('day', $todayName)->count(),
            'attendance_today' => Attendance::where('date', $today)->count(),
            'present_today' => Attendance::where('date', $today)->where('status', 'present')->count(),
            'absent_today' => Attendance::where('date', $today)->where('status', 'absent')->count(),
            'on_leave_today' => Attendance::where('date', $today)->where('status', 'on_leave')->count(),
            'offline_records' => Attendance::where('is_offline_record', true)->count(),
        ];

        // Currently ongoing classes
        $currentSchedules = Schedule::with(['faculty', 'room'])
            ->where('day', $todayName)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->get();

        // Recent attendance (last 10)
        $recentAttendance = Attendance::with(['faculty', 'schedule.room'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'stats',
            'currentSchedules',
            'recentAttendance',
            'todayName',
            'currentTime'
        ));
    }
}