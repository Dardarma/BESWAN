<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call([
        UserSeeder::class,
        LevelSeeder::class,
        MateriSeeder::class,
        QuizSeeder::class,
        typeSoalSeeder::class,
        SoalSeeder::class,
        OpsiJawabanSeeder::class,
        LevelUser::class,
      ]);
    }
}
