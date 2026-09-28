<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id', 'faculty_id', 'status', 'date',
        'recorded_time', 'is_offline_record', 'original_timestamp'
    ];

    protected $casts = [
        'is_offline_record' => 'boolean',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}