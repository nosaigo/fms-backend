<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('schedules', ScheduleController::class);
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::resource('faculties', FacultyController::class);
    Route::resource('rooms', RoomController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';