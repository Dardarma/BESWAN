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
        Schema::create('jawaban_user', function (Blueprint $table) {
            $table->id();
            $table->string('jawaban')->nullable();
            $table->boolean('is_true');
            $table->foreignId('soal_quiz_id')->constrained('soal_quiz')->onDelete('cascade');
            $table->foreignId('opsi_jawaban_id')->nullable()->constrained('opsi_jawaban')->onDelete('set null');
            $table->foreignId('quiz_user_id')->constrained('quiz_user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_user');
    }
};
