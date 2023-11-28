<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'logs';
    protected $fillable = [
        'activity',
        'description',
        'message',
        'creator_name',
        'action',
        'user_id',
        'employee_id',
        'created_by',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
