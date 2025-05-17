<?php

namespace Database\Seeders;

use App\Models\type_soal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class typeSoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        type_soal::create([
            'tipe_soal' => 'pilihan_ganda',
            'jumlah_soal' => 3,
            'jumlah_soal_now' =>3,
            'skor_per_soal'=>20,
            'total_skor'=>60,
            'quiz_id'=>1,
        ]);

        type_soal::create([
            'tipe_soal' => 'isian_singkat',
            'jumlah_soal' => 3,
            'jumlah_soal_now' =>3,
            'skor_per_soal'=>20,
            'total_skor'=>60,
            'quiz_id'=>1,
        ]);

        type_soal::create([
            'tipe_soal' => 'uraian',
            'jumlah_soal' => 3,
            'jumlah_soal_now' =>3,
            'skor_per_soal'=>20,
            'total_skor'=>60,
            'quiz_id'=>1,
        ]);
    }
}
