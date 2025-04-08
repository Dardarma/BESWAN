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
            $table->id(); // BIGINT auto-increment primary key
            $table->integer('nilai_user'); // User score
            $table->integer('jawaban_benar'); // Correct answers count
            $table->integer('jawaban_salah'); // Wrong answers count
            $table->unsignedBigInteger('quiz_id'); // Foreign key to quiz
            $table->unsignedBigInteger('user_id'); // Foreign key to user
            $table->timestamp('waktu_mulai'); // Start time
            $table->timestamp('waktu_selesai')->nullable(); // End time (nullable)
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints with CASCADE on delete
            $table->foreign('quiz_id')
                ->references('id')
                ->on('quiz')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            // Composite index for better performance
            $table->index(['user_id', 'quiz_id']);
            $table->index('waktu_selesai');
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