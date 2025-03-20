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
        Schema::create('quiz_user', function (Blueprint $table) {
            $table->id();
            $table->integer('nilai_user');
            $table->integer('jawaban_benar');
            $table->integer('jawaban_salah');

            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_user');
    }
};
