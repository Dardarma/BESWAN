<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level;
use App\Models\User;

class Level_Murid extends Model
{
    use HasFactory;

    protected $table = 'level_murid';

    protected $fillable = [
        'id_siswa',
        'id_level'
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_siswa');
    }
}
