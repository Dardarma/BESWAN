<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\quiz;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        quiz::create([
            'materi_id' => 1,
            'level_id' => 1,
            'judul' => 'Quiz 1',
            'waktu_pengerjaan' => 60,
            'type' => 'posttest',
            'is_active' => 1,
        ]);
    }
}
