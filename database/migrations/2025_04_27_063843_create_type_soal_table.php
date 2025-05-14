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
        Schema::create('type_soal', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_soal');
            $table->integer('jumlah_soal');
            $table->integer('jumlah_soal_now');
            $table->integer('skor_per_soal');
            $table->integer('total_skor');
            $table->foreignId('quiz_id')->constrained('quiz')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_soal');
    }
};
