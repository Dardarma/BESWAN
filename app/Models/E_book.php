<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class E_book extends Model
{
    use HasFactory;
    protected $table = 'e_book';
    protected $fillable =[
        'judul',
        'deskripsi',
        'url_file',
        'author',
        'tumbnail',
        'created_by',
        'updated_by'
    ];
}
