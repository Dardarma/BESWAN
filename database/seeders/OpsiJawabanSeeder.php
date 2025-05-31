<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\opsi_jawaban;

class OpsiJawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        opsi_jawaban::create([
            'soal_quiz_id' => 1,
            'opsi' => 'aaaaaa',
            'is_true' => 1
        ]);
        opsi_jawaban::create([
            'soal_quiz_id' => 1,
            'opsi' => 'bbbbbb',
            'is_true' => 0
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 2,
            'opsi' => 'cccccc',
            'is_true' => 1
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 2,
            'opsi' => 'dddddd',
            'is_true' => 0
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 3,
            'opsi' => 'eeeeee',
            'is_true' => 1
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 3,
            'opsi' => 'ffffff',
            'is_true' => 0
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 10,
            'opsi' => 'gggggg',
            'is_true' => 1
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 10,
            'opsi' => 'hhhhhh',
            'is_true' => 0
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 11,
            'opsi' => 'iiiiii',
            'is_true' => 1
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 11,
            'opsi' => 'jjjjjj',
            'is_true' => 0
        ]);


        opsi_jawaban::create([
            'soal_quiz_id' => 12,
            'opsi' => 'kkkkkk',
            'is_true' => 1
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 12,
            'opsi' => 'llllll',
            'is_true' => 0
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 13,
            'opsi' => 'mmmmmm',
            'is_true' => 1
        ]);

        opsi_jawaban::create([
            'soal_quiz_id' => 13,
            'opsi' => 'nnnnnn',
            'is_true' => 0
        ]);

    }
}
