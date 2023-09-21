<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
