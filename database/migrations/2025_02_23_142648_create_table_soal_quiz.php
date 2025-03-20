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
        Schema::create('soal_quiz', function (Blueprint $table) {
            $table->id();
            $table->string('soal');
            $table->string('type_soal');

            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_quiz');
    }
};
