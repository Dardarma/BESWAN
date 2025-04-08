<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment primary key
            $table->string('judul'); // VARCHAR(255)
            $table->integer('jumlah_soal'); // INT equivalent to int4
            $table->integer('waktu_pengerjaan'); // INT (minutes/seconds)
            $table->string('type_soal'); // Question type
            $table->string('type_quiz'); // Quiz type
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('id_materi')->nullable();
            $table->timestamps(); // created_at and updated_at
            
            // Foreign key constraint with CASCADE on delete
            $table->foreign('level_id')
                ->references('id')
                ->on('level')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('id_materi')
                ->references('id')
                ->on('materi')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            // Indexes for better performance
            $table->index('level_id');
            $table->index('id_materi');
            $table->index('type_quiz');
            $table->index('type_soal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};