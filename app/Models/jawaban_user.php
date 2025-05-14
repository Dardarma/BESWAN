<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jawaban_user extends Model
{
    use HasFactory;

    protected $table = 'jawaban_user';
    protected $guarded = ['id'];

    public function soal_quiz()
    {
        return $this->belongsTo(soal_quiz::class, 'id_soal_quiz', 'id');
    }

    public function opsi_jawaban()
    {
        return $this->belongsTo(opsi_jawaban::class, 'id_opsi_jawaban', 'id');
    }

    
}
