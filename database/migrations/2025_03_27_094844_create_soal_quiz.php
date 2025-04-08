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
            $table->id(); // BIGINT auto-increment primary key
            $table->text('soal')->nullable(); // Changed to text and nullable
            $table->string('type_soal'); // Question type
            $table->unsignedBigInteger('quiz_id'); // Foreign key
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraint with CASCADE on delete
            $table->foreign('quiz_id')
                ->references('id')
                ->on('quiz')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            // Index for better performance
            $table->index('quiz_id');
            $table->index('type_soal');
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