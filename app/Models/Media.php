<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';
    protected $guarded = ['id'];
    public function materi(){
        return $this->belongsTo(Materi::class, 'id_materi', 'id');
    }

}
