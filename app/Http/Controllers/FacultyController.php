<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::withCount(['schedules', 'attendances'])
            ->orderBy('name')
            ->paginate(20);

        return view('faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('faculties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:faculties,email',
            'department' => 'required|string|max:50',
        ]);

        Faculty::create($validated);

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty member added successfully.');
    }

    public function edit(Faculty $faculty)
    {
        return view('faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:faculties,email,' . $faculty->id,
            'department' => 'required|string|max:50',
        ]);

        $faculty->update($validated);

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty member updated successfully.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty member deleted successfully.');
    }
}