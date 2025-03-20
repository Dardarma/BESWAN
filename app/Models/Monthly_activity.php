<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Monthly_activity extends Model
{
    use HasFactory;
    protected $table = 'monthly_activity';
    protected $guarded =['id'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function daily_activity(){
        return $this->belongsTo(DailyActivity::class, 'id_daily_activity', 'id');
    }
}
