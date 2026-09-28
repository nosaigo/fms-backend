<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Faculty;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['faculty', 'schedule.room']);

        // Filter by date
        $date = $request->filled('date') ? $request->date : Carbon::now()->format('Y-m-d');
        $query->where('date', $date);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by faculty
        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        // Filter by source (online/offline)
        if ($request->filled('source')) {
            if ($request->source === 'offline') {
                $query->where('is_offline_record', true);
            } else {
                $query->where('is_offline_record', false);
            }
        }

        $attendances = $query
            ->orderBy('recorded_time', 'desc')
            ->paginate(25);

        $faculties = Faculty::orderBy('name')->get();

        // Stats for the selected date
        $stats = [
            'total' => Attendance::where('date', $date)->count(),
            'present' => Attendance::where('date', $date)->where('status', 'present')->count(),
            'absent' => Attendance::where('date', $date)->where('status', 'absent')->count(),
            'on_leave' => Attendance::where('date', $date)->where('status', 'on_leave')->count(),
        ];

        return view('attendance.index', compact('attendances', 'faculties', 'date', 'stats'));
    }
}