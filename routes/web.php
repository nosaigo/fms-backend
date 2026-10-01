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

// ===== DEBUG ROUTES (temporary — remove after fixing) =====
Route::get('/debug-log', function () {
    $logFile = storage_path('logs/laravel.log');
    if (!file_exists($logFile)) {
        return response('<pre>No log file yet.</pre>');
    }
    $lines = array_slice(file($logFile), -80);
    return response('<pre>' . htmlspecialchars(implode('', $lines)) . '</pre>');
});

Route::get('/debug-config', function () {
    return response()->json([
        'app_key_set' => !empty(config('app.key')),
        'app_key_length' => strlen(config('app.key') ?? ''),
        'app_env' => config('app.env'),
        'app_debug' => config('app.debug'),
        'app_url' => config('app.url'),
        'app_timezone' => config('app.timezone'),
        'session_driver' => config('session.driver'),
        'db_connection' => config('database.default'),
        'db_host' => config('database.connections.mysql.host'),
        'db_database' => config('database.connections.mysql.database'),
        'log_channel' => config('logging.default'),
    ]);
});
// ===== END DEBUG =====

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