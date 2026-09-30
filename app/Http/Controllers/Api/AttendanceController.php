<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Attendance::with(['faculty', 'schedule.room'])->get()
        ]);
    }

    // Record new attendance (online)
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'faculty_id' => 'required|exists:faculties,id',
            'status' => 'required|in:present,absent,on_leave',
            'date' => 'required|date',
            'recorded_time' => 'required',
        ]);

        // Check for existing record (update instead of duplicate)
        $existing = Attendance::where('schedule_id', $request->schedule_id)
            ->where('date', $request->date)
            ->first();

        if ($existing) {
            $existing->update($request->only([
                'status', 'recorded_time', 'is_offline_record', 'original_timestamp'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Attendance updated',
                'data' => $existing
            ]);
        }

        $attendance = Attendance::create([
            'schedule_id' => $request->schedule_id,
            'faculty_id' => $request->faculty_id,
            'status' => $request->status,
            'date' => $request->date,
            'recorded_time' => $request->recorded_time,
            'is_offline_record' => $request->is_offline_record ?? false,
            'original_timestamp' => $request->original_timestamp ?? now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance recorded',
            'data' => $attendance
        ], 201);
    }

    // Sync offline records (batch upload)
    public function syncOffline(Request $request)
    {
        $request->validate([
            'records' => 'required|array|min:1',
            'records.*.schedule_id' => 'required|exists:schedules,id',
            'records.*.faculty_id' => 'required|exists:faculties,id',
            'records.*.status' => 'required|in:present,absent,on_leave',
            'records.*.date' => 'required|date',
            'records.*.recorded_time' => 'required',
            'records.*.original_timestamp' => 'required',
        ]);

        $synced = [];
        $skipped = 0;

        foreach ($request->records as $record) {
            $existing = Attendance::where('schedule_id', $record['schedule_id'])
                ->where('date', $record['date'])
                ->first();

            if ($existing) {
                $existing->update([
                    'status' => $record['status'],
                    'recorded_time' => $record['recorded_time'],
                    'is_offline_record' => true,
                    'original_timestamp' => $record['original_timestamp'],
                ]);
                $synced[] = $existing;
            } else {
                $synced[] = Attendance::create([
                    'schedule_id' => $record['schedule_id'],
                    'faculty_id' => $record['faculty_id'],
                    'status' => $record['status'],
                    'date' => $record['date'],
                    'recorded_time' => $record['recorded_time'],
                    'is_offline_record' => true,
                    'original_timestamp' => $record['original_timestamp'],
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Synced ' . count($synced) . ' records',
            'synced_count' => count($synced),
            'data' => $synced
        ]);
    }

    public function getByDate($date)
    {
        $attendances = Attendance::with(['faculty', 'schedule.room'])
            ->where('date', $date)
            ->get();

        return response()->json([
            'success' => true,
            'date' => $date,
            'count' => $attendances->count(),
            'data' => $attendances
        ]);
    }

    public function getByFaculty($facultyId)
    {
        $attendances = Attendance::with(['faculty', 'schedule.room'])
            ->where('faculty_id', $facultyId)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attendances
        ]);
    }

    // Get current room status (occupied/vacant) for all rooms
    public function getRoomStatusToday()
    {
        $today = Carbon::now()->format('Y-m-d');
        $day = Carbon::now()->format('l');
        $time = Carbon::now()->format('H:i:s');

        $activeSchedules = Schedule::with(['faculty', 'room'])
            ->where('day', $day)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->get();

        $rooms = \App\Models\Room::all();
        $result = [];

        foreach ($rooms as $room) {
            $activeSchedule = $activeSchedules->firstWhere('room_id', $room->id);

            if ($activeSchedule) {
                $attendance = Attendance::where('schedule_id', $activeSchedule->id)
                    ->where('date', $today)
                    ->first();

                $result[] = [
                    'room_id' => $room->id,
                    'room_number' => $room->room_number,
                    'building' => $room->building,
                    'status' => 'occupied',
                    'current_class' => [
                        'subject' => $activeSchedule->subject,
                        'section' => $activeSchedule->section,
                        'faculty' => $activeSchedule->faculty->name,
                        'start_time' => $activeSchedule->start_time,
                        'end_time' => $activeSchedule->end_time,
                        'attendance_status' => $attendance ? $attendance->status : 'not_recorded',
                    ]
                ];
            } else {
                $result[] = [
                    'room_id' => $room->id,
                    'room_number' => $room->room_number,
                    'building' => $room->building,
                    'status' => 'vacant',
                    'current_class' => null
                ];
            }
        }

        return response()->json([
            'success' => true,
            'current_time' => $time,
            'current_day' => $day,
            'data' => $result
        ]);
    }

    /**
     * NEW METHOD: Get rooms with their current OR next class + attendance status.
     */
    public function getRoomsWithCurrentClass()
    {
        $today = Carbon::now()->format('Y-m-d');
        $day = Carbon::now()->format('l');
        $currentTime = Carbon::now()->format('H:i:s');

        $rooms = \App\Models\Room::orderBy('room_number')->get();
        $result = [];

        foreach ($rooms as $room) {
            $todaySchedules = Schedule::with(['faculty'])
                ->where('room_id', $room->id)
                ->where('day', $day)
                ->orderBy('start_time')
                ->get();

            $currentClass = null;
            $nextClass = null;

            foreach ($todaySchedules as $schedule) {
                if ($schedule->start_time <= $currentTime
                    && $schedule->end_time >= $currentTime) {
                    $currentClass = $schedule;
                    break;
                }
                if ($schedule->start_time > $currentTime && $nextClass === null) {
                    $nextClass = $schedule;
                }
            }

            $displayClass = $currentClass ?? $nextClass;

            $classData = null;
            if ($displayClass) {
                $attendance = Attendance::where('schedule_id', $displayClass->id)
                    ->where('date', $today)
                    ->first();

                $classData = [
                    'schedule_id' => $displayClass->id,
                    'subject' => $displayClass->subject,
                    'section' => $displayClass->section,
                    'faculty' => $displayClass->faculty->name ?? 'Unknown',
                    'start_time' => $displayClass->start_time,
                    'end_time' => $displayClass->end_time,
                    'attendance_status' => $attendance ? $attendance->status : 'not_recorded',
                    'is_ongoing' => $currentClass !== null,
                ];
            }

            $result[] = [
                'room_id' => $room->id,
                'room_number' => $room->room_number,
                'building' => $room->building,
                'status' => $currentClass ? 'occupied' : 'vacant',
                'class' => $classData,
            ];
        }

        return response()->json([
            'success' => true,
            'current_time' => $currentTime,
            'current_day' => $day,
            'data' => $result,
        ]);
    }
}