<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\AttendanceController;

Route::prefix('v1')->group(function () {

    // Faculty routes
    Route::get('/faculties', [FacultyController::class, 'index']);
    Route::get('/faculties/{id}', [FacultyController::class, 'show']);

    // Room routes
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/rooms/{id}', [RoomController::class, 'show']);

    // Schedule routes
    Route::get('/schedules', [ScheduleController::class, 'index']);
    Route::get('/schedules/current', [ScheduleController::class, 'current']);
    Route::get('/schedules/today', [ScheduleController::class, 'getToday']);
    Route::get('/schedules/faculty/{facultyId}', [ScheduleController::class, 'getByFaculty']);
    Route::get('/schedules/room/{roomId}', [ScheduleController::class, 'getByRoom']);

    // Attendance routes
    Route::get('/attendances', [AttendanceController::class, 'index']);
    Route::post('/attendances', [AttendanceController::class, 'store']);
    Route::post('/attendances/sync', [AttendanceController::class, 'syncOffline']);
    Route::get('/attendances/date/{date}', [AttendanceController::class, 'getByDate']);
    Route::get('/attendances/faculty/{facultyId}', [AttendanceController::class, 'getByFaculty']);
    Route::get('/room-status/today', [AttendanceController::class, 'getRoomStatusToday']);
});