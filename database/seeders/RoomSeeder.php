<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rooms')->insert([
            ['room_number' => 'CEIT-101', 'building' => 'CEIT Building', 'capacity' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['room_number' => 'CEIT-102', 'building' => 'CEIT Building', 'capacity' => 35, 'created_at' => now(), 'updated_at' => now()],
            ['room_number' => 'CEIT-103', 'building' => 'CEIT Building', 'capacity' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['room_number' => 'CEIT-201', 'building' => 'CEIT Building', 'capacity' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['room_number' => 'CEIT-202', 'building' => 'CEIT Building', 'capacity' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['room_number' => 'CEIT-203', 'building' => 'CEIT Building', 'capacity' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['room_number' => 'CEIT-301', 'building' => 'CEIT Building', 'capacity' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['room_number' => 'CEIT-302', 'building' => 'CEIT Building', 'capacity' => 35, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}