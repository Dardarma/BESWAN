<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $fillable = [
        'judul',
        'deskripsi',
        'konten',
        'id_level',
        'created_by',
        'updated_by'
    ];

    public function level(){
        return $this->belongsTo(Level::class, 'id_level', 'id');
    }
}
