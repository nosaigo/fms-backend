<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id', 'room_id', 'subject', 'section',
        'day', 'start_time', 'end_time'
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}