<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $guarded = ['id'];

    public function level(){
        return $this->belongsTo(Level::class, 'id_level', 'id');
    }

    public function media(){
        return $this->hasMany(Media::class, 'id_materi', 'id');
    }

    public function comment_materi(){
        return $this->hasMany(Comment_materi::class, 'materi_id', 'id');
    }
}
