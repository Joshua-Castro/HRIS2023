<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'activity',
        'creator_name',
        'message',
        'description',
        'action',
        'created_by',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
