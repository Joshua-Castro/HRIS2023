<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryGrade extends Model
{
    use HasFactory;
    protected $table = 'salary_grades';
    protected $fillable = [
        'description',
        'value',
        'hourly_rate',
        'weekly_rate',
    ];
}
