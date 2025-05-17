<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Level::create([
        'nama_level' => 'beginner',
        'deskripsi_level' => 'Level pemula',
        'urutan_level' => 1,
        'warna' => '#22d4f0'
      ]);

        Level::create([
            'nama_level' => 'intermediate',
            'deskripsi_level' => 'Level menengah',
            'urutan_level' => 2,
            'warna' => '#f0d422'
        ]);
    }
}
