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
            $table->id();
            $table->string('judul');
            $table->integer('jumlah_soal');
            $table->integer('waktu_pengerjaan');
            $table->string('type_soal');
            $table->string('type_quiz');

            $table->unsignedBigInteger('materi_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();

            $table->foreign('materi_id')->references('id')->on('materi')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('level')->onDelete('cascade');
            $table->timestamps();
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
