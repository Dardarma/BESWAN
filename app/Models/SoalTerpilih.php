<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalTerpilih extends Model
{
    use HasFactory;
    protected $table = 'soal_terpilih';
    protected $guarded = ['id'];

    public function quiz()
    {
        return $this->belongsTo(quiz::class, 'quiz_id');
    }

    public function type_soal()
    {
        return $this->belongsTo(type_soal::class, 'type_soal_id');
    }

    public function quiz_user()
    {
        return $this->belongsTo(quiz_user::class, 'quiz_user_id');
    }
    
}
