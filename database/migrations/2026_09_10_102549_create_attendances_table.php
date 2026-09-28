<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->enum('status', ['present', 'absent', 'on_leave']);
            $table->date('date');
            $table->time('recorded_time');
            $table->boolean('is_offline_record')->default(false);
            $table->timestamp('original_timestamp')->nullable();
            $table->timestamps();

            // Prevent duplicate entries for same schedule on same date
            $table->unique(['schedule_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};