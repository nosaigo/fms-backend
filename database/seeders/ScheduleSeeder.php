<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $subjects = ['IT 101', 'IT 102', 'CS 201', 'CS 202', 'ENG 101', 'MATH 101', 'PE 101', 'NSTP 101'];
        $sections = ['A', 'B', 'C'];
        $timeSlots = [
            ['07:00:00', '08:30:00'],
            ['08:30:00', '10:00:00'],
            ['10:00:00', '11:30:00'],
            ['13:00:00', '14:30:00'],
            ['14:30:00', '16:00:00'],
            ['16:00:00', '17:30:00'],
        ];

        $schedules = [];
        $facultyCount = 8;
        $roomCount = 8;

        foreach ($days as $day) {
            foreach ($timeSlots as $slotIndex => $slot) {
                // Assign 3-4 classes per time slot per day
                $classCount = rand(3, 4);
                $usedFaculties = [];
                $usedRooms = [];

                for ($i = 0; $i < $classCount; $i++) {
                    $facultyId = rand(1, $facultyCount);
                    $roomId = rand(1, $roomCount);

                    // Avoid duplicate faculty/room in same time slot
                    while (in_array($facultyId, $usedFaculties)) {
                        $facultyId = rand(1, $facultyCount);
                    }
                    while (in_array($roomId, $usedRooms)) {
                        $roomId = rand(1, $roomCount);
                    }

                    $usedFaculties[] = $facultyId;
                    $usedRooms[] = $roomId;

                    $schedules[] = [
                        'faculty_id' => $facultyId,
                        'room_id' => $roomId,
                        'subject' => $subjects[array_rand($subjects)],
                        'section' => $sections[array_rand($sections)],
                        'day' => $day,
                        'start_time' => $slot[0],
                        'end_time' => $slot[1],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('schedules')->insert($schedules);
    }
}