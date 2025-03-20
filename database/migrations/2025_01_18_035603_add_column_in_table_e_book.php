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
        Schema::table('e_book', function (Blueprint $table) {
            $table->renameColumn('created_by', 'author');
            $table->renameColumn('file', 'url_file');
            $table->string('tumbnail')->nullable();
            $table->dropColumn('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_book', function (Blueprint $table) {
            $table->renameColumn('author', 'created_by');
            $table->renameColumn('url_file', 'file');
            $table->dropColumn('tumbnail');
            $table->string('updated_by');
        });
    }
};
