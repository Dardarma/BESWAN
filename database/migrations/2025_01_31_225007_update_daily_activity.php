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
        Schema::table('daily_activity', function (Blueprint $table) {
            $table->dropColumn(('tanggal_pengerjaan'));
            $table->dropColumn(('status'));
            $table->dropColumn(('id_user'));
            $table->dropColumn(('created_by'));
            $table->dropColumn(('updated_by'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_activity', function (Blueprint $table) {
            $table->date('tanggal_pengerjaan');
            $table->string('status');
            $table->unsignedBigInteger('id_user');
            $table->string('created_by');
            $table->string('updated_by');
        });
    }
};
