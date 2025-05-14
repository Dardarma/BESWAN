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
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('deskripsi');
            $table->text('konten');
            $table->unsignedBigInteger('id_level');
            $table->string('file_media')->nullable();   
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_level')
                  ->references('id')
                  ->on('level')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            // Optional: Add index for frequently queried columns
            $table->index('judul');
            $table->index('id_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};