<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_feed extends Model
{
    use HasFactory;
    protected $table = 'activity_feed';
    protected $fillable =[
        'judul_activity',
        'deskripsi_activity',
        'file_media',
        'created_by',
        'updated_by'
    ];
}
