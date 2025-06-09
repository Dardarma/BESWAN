<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_materi extends Model
{
    use HasFactory;
    protected $table = 'comment_materi';
    protected $guarded = ['id'];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
