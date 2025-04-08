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
        Schema::create('opsi_jawaban', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment primary key
            $table->text('jawaban'); // Changed to text for longer answers
            $table->boolean('is_true')->default(false);
            $table->unsignedBigInteger('soal_id'); // Foreign key
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraint with CASCADE on delete
            $table->foreign('soal_id')
                ->references('id')
                ->on('soal_quiz')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            // Index for better performance
            $table->index('soal_id');
            $table->index('is_true');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opsi_jawaban');
    }
};