<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class soal_quiz extends Model
{
    use HasFactory;

    protected $table = 'soal_quiz';

    protected $guarded= ['id'];
}
