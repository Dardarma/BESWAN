<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\soal_quiz;

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        soal_quiz::create([
            'quiz_id' => 1,
            'type_soal_id' => 1,
            'soal' => 'Apa itu Laravel?',
        ]);

        soal_quiz::create([
            'quiz_id' => 1,
            'type_soal_id' => 1,
            'soal' => 'Jelaskan apa itu Laravel?',
        ]);

        soal_quiz::create([
            'quiz_id' => 1,
            'type_soal_id' => 1,
            'soal' => 'Sebutkan fitur-fitur yang ada di Laravel?',
        ]);

        soal_quiz::create([
            'quiz_id' => 1,
            'type_soal_id' => 2,
            'soal' => 'Apa itu Eloquent?',
            'jawaban_benar' => 'Eloquent adalah ORM (Object Relational Mapping) yang digunakan di Laravel untuk berinteraksi dengan database.',
        ]);

        soal_quiz::create([
            'quiz_id' => 1,
            'type_soal_id' => 2,
            'soal' => 'Apa itu Route di Laravel?',
            'jawaban_benar' => 'Route adalah cara untuk mendefinisikan URL yang akan diakses oleh pengguna.',
        ]);

        soal_quiz::create([
            'quiz_id' => 1,
            'type_soal_id' => 2,
            'soal' => 'Apa itu Middleware di Laravel?',
            'jawaban_benar' => 'Middleware adalah cara untuk memfilter permintaan HTTP yang masuk ke aplikasi.',
        ]);

        soal_quiz::create([
            'quiz_id' => 1,
            'type_soal_id' => 3,
            'soal' => 'Jelaskan apa itu Service Provider di Laravel?',
        ]);

        soal_quiz::create([
            'quiz_id' => 1,
            'type_soal_id' => 3,
            'soal' => 'Jelaskan apa itu Facade di Laravel?',
        ]);

        soal_quiz::create([
            'quiz_id' => 1,
            'type_soal_id' => 3,
            'soal' => 'Jelaskan apa itu Dependency Injection di Laravel?',
        ]);

        

    }
}
