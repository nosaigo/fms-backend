<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::now()->format('Y-m-d');
        $todayName = Carbon::now()->format('l');
        $currentTime = Carbon::now()->format('H:i:s');

        // Get today's schedules that already started
        $schedules = DB::table('schedules')
            ->where('day', $todayName)
            ->where('start_time', '<=', $currentTime)
            ->get();

        $attendances = [];
        $statuses = ['present', 'present', 'present', 'absent', 'on_leave']; // Weighted toward present

        foreach ($schedules as $schedule) {
            $attendances[] = [
                'schedule_id' => $schedule->id,
                'faculty_id' => $schedule->faculty_id,
                'status' => $statuses[array_rand($statuses)],
                'date' => $today,
                'recorded_time' => $schedule->start_time,
                'is_offline_record' => false,
                'original_timestamp' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($attendances)) {
            DB::table('attendances')->insert($attendances);
        }

        $this->command->info('Created ' . count($attendances) . ' attendance records for today.');
    }
}