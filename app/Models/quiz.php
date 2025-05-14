<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quiz extends Model
{
    use HasFactory;
    protected $table = 'quiz';
    protected $guarded = ['id'];

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi', 'id');
    }

    public function type_soal()
    {
        return $this->hasMany(type_soal::class, 'id_quiz', 'id');
    }

    public function soal_quiz()
    {
        return $this->hasMany(soal_quiz::class, 'id_quiz', 'id');
    }

    public function quiz_user()
    {
        return $this->hasMany(quiz_user::class, 'id_quiz', 'id');
    }

   
}
