<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quiz_user extends Model
{
    use HasFactory;

    protected $table = 'quiz_user';
    protected $guarded = ['id'];

    public function quiz()
    {
        return $this->belongsTo(quiz::class, 'quiz_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
