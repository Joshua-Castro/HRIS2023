<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'leave_date',
        'leave_type',
        'day_type',
        'reason',
    ];
}
