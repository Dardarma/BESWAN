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
        Schema::create('media_soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soal_id')->constrained('soal_quiz')->onDelete('cascade');
            $table->string('media')->nullable();
            $table->enum('type_media', ['audio', 'video', 'image'])->default('audio');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_soal');
    }
};
