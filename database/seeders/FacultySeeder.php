<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('faculties')->insert([
            ['name' => 'Dr. Juan Dela Cruz', 'email' => 'juan.delacruz@ksu.edu.ph', 'department' => 'CEIT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Prof. Maria Santos', 'email' => 'maria.santos@ksu.edu.ph', 'department' => 'CEIT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engr. Pedro Reyes', 'email' => 'pedro.reyes@ksu.edu.ph', 'department' => 'CEIT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Prof. Ana Torres', 'email' => 'ana.torres@ksu.edu.ph', 'department' => 'CEIT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dr. Carlos Mendoza', 'email' => 'carlos.mendoza@ksu.edu.ph', 'department' => 'CEIT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Prof. Lisa Bautista', 'email' => 'lisa.bautista@ksu.edu.ph', 'department' => 'CEIT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engr. Mark Villanueva', 'email' => 'mark.villanueva@ksu.edu.ph', 'department' => 'CEIT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Prof. Rosa Aquino', 'email' => 'rosa.aquino@ksu.edu.ph', 'department' => 'CEIT', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}