<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('subject');
            $table->string('section');
            $table->enum('day', [
                'Monday', 'Tuesday', 'Wednesday',
                'Thursday', 'Friday', 'Saturday', 'Sunday'
            ]);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};