<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;

    protected $table = 'daily_activity';

    protected $guarded = ['id'];

    public function user_activity()
    {
        return $this->hasMany(User_activity::class, 'id_daily_activity', 'id');
    }
}
