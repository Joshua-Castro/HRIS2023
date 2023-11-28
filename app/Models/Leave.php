<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'leaves';
    protected $fillable = [
        'reason',
        'user_id',
        'day_type',
        'leave_date',
        'leave_type',
        'employee_id',
    ];
}
