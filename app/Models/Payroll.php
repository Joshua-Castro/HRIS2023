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
        'user_id',
        'employee_id',
        'basic_salary',
        'overtime_hours',
        'bonuses',
        'deductions',
        'allowances',
        'net_salary',
        'payment_date',
        'payment_method',
    ];
}
