<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_soal extends Model
{
    use HasFactory;
    protected $table = 'type_soal';
    protected $guarded = ['id'];

    public function quiz()
    {
        return $this->belongsTo(quiz::class);
    }

    public function soal_quiz()
    {
        return $this->hasMany(soal_quiz::class);
    }
}
