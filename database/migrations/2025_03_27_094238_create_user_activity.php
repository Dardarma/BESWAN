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
        Schema::create('user_activity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_activity');
            $table->boolean('status')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->foreign('id_activity')
                  ->references('id')
                  ->on('daily_activity')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            // Composite unique index to prevent duplicate user-activity records
            $table->unique(['id_user', 'id_activity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activity');
    }
};