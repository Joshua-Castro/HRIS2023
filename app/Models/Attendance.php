<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'employee_id',
        'clock_in',
        'clock_out',
        'break_in',
        'break_out',
        'total_hours',
        'total_overtime_hours',
        'status',
        'notes'
    ];
}
