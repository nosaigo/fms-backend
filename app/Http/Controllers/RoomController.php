<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::withCount('schedules')
            ->orderBy('room_number')
            ->paginate(20);

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:50|unique:rooms,room_number',
            'building' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1|max:500',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room added successfully.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:50|unique:rooms,room_number,' . $room->id,
            'building' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1|max:500',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}