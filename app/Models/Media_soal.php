<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media_soal extends Model
{
    use HasFactory;

    protected $table = 'media_soal';
    protected $guarded = ['id'];

    public function soal_quiz()
    {
        return $this->belongsTo(soal_quiz::class, 'soal_id', 'id');
    }
}
