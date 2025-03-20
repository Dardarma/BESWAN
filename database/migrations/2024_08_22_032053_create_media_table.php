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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('Alt');
            $table->string('file');
            $table->string('type');

            $table->unsignedBigInteger('id_materi');
            $table->foreign('id_materi')->references('id')->on('materi')->onDelete('cascade');
            
            $table->string('created_by');
            $table->string('updated_by')->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
