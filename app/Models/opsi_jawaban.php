<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class opsi_jawaban extends Model
{
    use HasFactory;

    protected $table = 'opsi_jawaban';
    protected $guarded = ['id'];

    public function soal_quiz()
    {
        return $this->belongsTo(soal_quiz::class, 'id_soal_quiz', 'id');
    }

    public function jawaban_user()
    {
        return $this->hasMany(jawaban_user::class, 'id_opsi_jawaban', 'id');
    }
}
