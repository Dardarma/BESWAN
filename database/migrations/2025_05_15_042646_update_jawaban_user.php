<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jawaban_user', function (Blueprint $table) {
            // Drop kolom relasi lama
            $table->dropForeign(['soal_quiz_id']);
            $table->dropColumn('soal_quiz_id');

            $table->dropForeign(['quiz_user_id']);
            $table->dropColumn('quiz_user_id');

            // Tambahkan kolom baru
            $table->foreignId('soal_terpilih_id')
                  ->after('is_true')
                  ->constrained('soal_terpilih')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jawaban_user', function (Blueprint $table) {
            // Hapus kolom baru
            $table->dropForeign(['soal_terpilih_id']);
            $table->dropColumn('soal_terpilih_id');
            // Tambahkan kembali kolom lama
            $table->foreignId('soal_quiz_id')
                  ->after('is_true')
                  ->constrained('soal_quiz')
                  ->onDelete('cascade');

            $table->foreignId('quiz_user_id')
                  ->after('soal_quiz_id')
                  ->constrained('quiz_user')
                  ->onDelete('cascade');
        });
    }
};
