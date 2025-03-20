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
        Schema::table('quiz_user', function (Blueprint $table) {
            $table->timestamp('Waktu_mulai')->nullable();
            $table->timestamp('Waktu_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_user', function (Blueprint $table) {
            $table->dropColumn('Waktu_mulai');
            $table->dropColumn('Waktu_selesai');
        });
    }
};
