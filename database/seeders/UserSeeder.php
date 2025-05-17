<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
   
    public function run(): void
    {
        User::create([
            'name' => 'Kiki',
            'email' => 'kiki@kiki.com',
            'password' => '123456',
            'role' => 'superadmin',
            'no_hp' => '99999999999',
            'tanggal_lahir' => '2020-08-30 12:00:00',
            'tanggal_masuk' => '2024-08-30 12:00:00',
            'alamat' => 'Jl sigala-gala pati'
        ]);

        User::create([
            'name' => 'user1',
            'email' => 'user1@user.com',
            'password' => '12345678',
            'role' => 'user',
            'no_hp' => '99999999999',
            'tanggal_lahir' => '2020-08-30 12:00:00',
            'tanggal_masuk' => '2024-08-30 12:00:00',
            'alamat' => 'Jl sigala-gala pati'
        ]);
      
    }
}
