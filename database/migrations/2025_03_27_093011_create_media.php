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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_materi');
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('url_video')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();

            // Foreign key constraint with CASCADE on delete
            $table->foreign('id_materi')
                  ->references('id')
                  ->on('materi')
                  ->onDelete('cascade')
                  ->onUpdate('restrict');

            // Optional: Add index for better performance
            $table->index('id_materi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};