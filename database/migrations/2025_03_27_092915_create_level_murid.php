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
        Schema::create('level_murid', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_level');
            $table->integer('exp')->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_level')
                  ->references('id')
                  ->on('level')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
                 

            $table->foreign('id_siswa')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Optional: Add composite unique index to prevent duplicates
            $table->unique(['id_siswa', 'id_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_murid');
    }
};