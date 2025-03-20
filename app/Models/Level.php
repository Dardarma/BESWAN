<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'level';
    
    protected $fillable = [
        'nama_level',
        'deskripsi_level',
        'urutan_level'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'level_murid', 'id_level', 'id_siswa')
                ->withPivot('id');
    }
}
