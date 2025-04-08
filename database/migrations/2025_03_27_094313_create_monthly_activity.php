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
        Schema::create('monthly_activity', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment primary key
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_activity');
            $table->smallInteger('bulan'); // Equivalent to int2
            $table->integer('tahun'); // Equivalent to int4
            $table->integer('jumlah_aktivitas')->default(0);
            $table->timestamps(); // created_at and updated_at

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

            // Composite index for better query performance
            $table->index(['bulan', 'tahun']);
            $table->index(['id_user', 'id_activity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_activity');
    }
};