<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'tanggal_lahir',
        'tanggal_masuk',
        'alamat',
        'foto_profil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'id'=> 'integer',
    ];

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'level_murid', 'id_siswa', 'id_level')
                    ->withPivot('id');
    }
 

    public function daily_activity()
    {
        return $this->hasMany(DailyActivity::class, 'id_user', 'id');
    }

    public function comment_materi()
    {
        return $this->hasMany(Comment_materi::class, 'user_id', 'id');
    }
    
    /**
     * Get the latest level for regular users with color and order data
     */
    public function getLatestUserLevel()
    {
        if ($this->role !== 'user') {
            return null;
        }
        
        return $this->levels()
                    ->select('level.id', 'level.nama_level', 'level.urutan_level', 'level.warna')
                    ->orderBy('level_murid.created_at', 'desc')
                    ->first();
    }

}
