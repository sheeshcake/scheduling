<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'room_id',
        'subject_id',
        'schedule_day',
        'schedule_time_start',
        'schedule_time_end',
        'start_month',
        'end_month'
    ];
}
