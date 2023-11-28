<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'attendances';
    protected $fillable = [
        'notes',
        'status',
        'user_id',
        'clock_in',
        'break_in',
        'clock_out',
        'break_out',
        'employee_id',
        'total_hours',
        'attendance_date',
        'total_overtime_hours',
    ];
}
