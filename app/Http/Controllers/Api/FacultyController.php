<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Faculty::all()
        ]);
    }

    public function show($id)
    {
        $faculty = Faculty::with(['schedules.room'])->find($id);

        if (!$faculty) {
            return response()->json([
                'success' => false,
                'message' => 'Faculty not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $faculty
        ]);
    }
}