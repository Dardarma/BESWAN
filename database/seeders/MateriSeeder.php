<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Materi;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materi::create([
            'judul' => 'Materi 1',
            'deskripsi' => 'Deskripsi Materi 1',
            'id_level' => 1,
            'konten' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

       
    }
}
