<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory, SoftDeletes;
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
        'payment_method',
        'payroll_date_from',
        'payroll_date_to',
        'status'
    ];
}
