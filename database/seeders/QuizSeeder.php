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
            'jumlah_soal' => 9,
            'total_skor' => 180,
        ]);

        quiz::create([
            'level_id' => 1,
            'judul' => 'Pretest 1',
            'waktu_pengerjaan' => 60,
            'type' => 'pretest',
            'is_active' => 1,
            'jumlah_soal' => 5,
            'total_skor' => 100,
        ]);

        quiz::create([
            'level_id' => 2,
            'judul' => 'Pretest 2',
            'waktu_pengerjaan' => 60,
            'type' => 'pretest',
            'is_active' => 1,
            'jumlah_soal' => 5,
            'total_skor' => 100,
        ]);
    }
}
