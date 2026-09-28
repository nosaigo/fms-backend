<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Schedule::with(['faculty', 'room'])->get()
        ]);
    }

    // Get schedules that are happening RIGHT NOW (based on current day + time)
    public function current()
    {
        $now = Carbon::now();
        $day = $now->format('l');
        $time = $now->format('H:i:s');

        $schedules = Schedule::with(['faculty', 'room'])
            ->where('day', $day)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->get();

        return response()->json([
            'success' => true,
            'current_time' => $time,
            'current_day' => $day,
            'count' => $schedules->count(),
            'data' => $schedules
        ]);
    }

    // Get all schedules for TODAY (current day)
    public function getToday()
    {
        $day = Carbon::now()->format('l');

        $schedules = Schedule::with(['faculty', 'room'])
            ->where('day', $day)
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'success' => true,
            'day' => $day,
            'count' => $schedules->count(),
            'data' => $schedules
        ]);
    }

    public function getByFaculty($facultyId)
    {
        $schedules = Schedule::with(['faculty', 'room'])
            ->where('faculty_id', $facultyId)
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $schedules
        ]);
    }

    public function getByRoom($roomId)
    {
        $schedules = Schedule::with(['faculty', 'room'])
            ->where('room_id', $roomId)
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $schedules
        ]);
    }
}