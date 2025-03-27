<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Hapus kolom yang tidak diperlukan
            $table->dropColumn('file');
            $table->dropColumn('Alt');
            $table->dropColumn('type');

            // Tambahkan kolom video_id
            $table->string('url_video')->nullable();
            $table->string('deskripsi')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Tambahkan kembali kolom yang dihapus
            $table->string('file');
            $table->string('Alt');
            $table->string('type');
            $table->dropColumn('url_video');
            $table->dropColumn('deskripsi');

        });
    }
};
