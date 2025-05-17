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
        Schema::create('soal_terpilih', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('quiz_user_id')->constrained('quiz_user')->onDelete('cascade');
            $table->foreignId('type_soal_id')->constrained('type_soal')->onDelete('cascade');
            $table->foreignId('soal_id')->constrained('soal_quiz')->onDelete('cascade');
            $table->integer('urutan_soal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_terpilih');
    }
};
