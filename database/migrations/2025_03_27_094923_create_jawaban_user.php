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
            $table->id(); // BIGINT auto-increment primary key
            $table->string('status'); // Answer status (correct/wrong/etc)
            $table->text('jawaban'); // Changed to text for longer answers
            $table->unsignedBigInteger('soal_id'); // Foreign key to question
            $table->unsignedBigInteger('user_id'); // Foreign key to user
            $table->unsignedBigInteger('opsi_jawaban_id')->nullable(); // Foreign key to answer option
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints with CASCADE on delete
            $table->foreign('soal_id')
                ->references('id')
                ->on('soal_quiz')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('opsi_jawaban_id')
                ->references('id')
                ->on('opsi_jawaban')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            // Composite index for better performance
            $table->index(['user_id', 'soal_id']);
            $table->index('status');
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