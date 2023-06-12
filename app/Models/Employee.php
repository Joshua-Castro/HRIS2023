<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'maiden_name',
        'position',
        'last_promotion',
        'station_code',
        'control_no',
        'employee_no',
        'school_code',
        'item_number',
        'employment_status',
        'salary_grade',
        'date_hired',
        'sss',
        'pag_ibig',
        'phil_health',
    ];
}
