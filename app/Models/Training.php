<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'cost',
        'title',
        'status',
        'end_time',
        'duration',
        'start_time',
        'location',
        'description',
        'end_date_time',
        'start_date_time',
        'trainer_instructor',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
