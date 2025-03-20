<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';
    protected $fillabel = [
        'Alt',
        'file',
        'type',
        'id_materi',
        'created_by',
        'updated_by'
    ];

    public function materi(){
        return $this->belongsTo(Materi::class, 'id_materi', 'id');
    }

}
