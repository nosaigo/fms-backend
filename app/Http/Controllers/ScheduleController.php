<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['faculty', 'room']);

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        $schedules = $query
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->paginate(20);

        $faculties = Faculty::orderBy('name')->get();

        return view('schedules.index', compact('schedules', 'faculties'));
    }

    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        $rooms = Room::orderBy('room_number')->get();
        return view('schedules.create', compact('faculties', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'room_id' => 'required|exists:rooms,id',
            'subject' => 'required|string|max:100',
            'section' => 'required|string|max:20',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $faculties = Faculty::orderBy('name')->get();
        $rooms = Room::orderBy('room_number')->get();
        return view('schedules.edit', compact('schedule', 'faculties', 'rooms'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'room_id' => 'required|exists:rooms,id',
            'subject' => 'required|string|max:100',
            'section' => 'required|string|max:20',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}