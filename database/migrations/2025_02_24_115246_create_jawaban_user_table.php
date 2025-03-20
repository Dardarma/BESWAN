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
            $table->string('status');
            $table->string('jawaban');
        
            $table->unsignedBigInteger('soal_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('opsi_jawaban_id')->nullable(); // Tambahkan nullable di sini
        
            $table->foreign('soal_id')->references('id')->on('soal_quiz')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('opsi_jawaban_id')->references('id')->on('opsi_jawaban')->onDelete('cascade');
        
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
