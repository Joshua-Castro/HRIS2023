<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;
    protected $table = 'payrolls';
    protected $fillable = [
        'employee_id',
        'basic_salary',
        'overtime_hours',
        'bonuses',
        'total_deductions',
        'sss',
        'pagibig',
        'philhealth',
        'absences',
        'tax',
        'allowances',
        'net_salary',
        'payment_date',
        'status',
        'payment_method',
        'hourly_rate',
        'payroll_date_from',
        'payroll_date_to'
    ];
}
