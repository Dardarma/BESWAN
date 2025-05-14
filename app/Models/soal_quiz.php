<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class soal_quiz extends Model
{
    use HasFactory;

    protected $table = 'soal_quiz';
    protected $guarded = ['id'];

    public function quiz()
    {
        return $this->belongsTo(quiz::class, 'id_quiz', 'id');
    }

    public function type_quiz()
    {
        return $this->belongsTo(type_quiz::class, 'id_type_quiz', 'id');
    }

    public function opsi_jawaban()
    {
        return $this->hasMany(opsi_jawaban::class, 'id_soal_quiz', 'id');
    }

    public function jawaban_user()
    {
        return $this->hasMany(jawaban_user::class, 'id_soal_quiz', 'id');
    }
}
