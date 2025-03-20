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
        Schema::table('monthly_activity', function (Blueprint $table) {
            $table->integer('jumlah_aktivitas')->default(0);
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_activity')->references('id')->on('daily_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_activity', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_activity']);
            $table->dropColumn('jumlah_aktivitas');
        });
    }
};
