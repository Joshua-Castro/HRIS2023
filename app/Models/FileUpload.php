<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'file_uploads';
    protected $fillable = [
        'file_path',
        'file_name',
        'file_unique_id'
    ];
}
