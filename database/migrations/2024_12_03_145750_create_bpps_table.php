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
        Schema::create('bpp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id');
            $table->string('kode',255);
            $table->text('nama');
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('cascade');
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onDelete('cascade');
            $table->index('provinsi_id');
            $table->index('kabupaten_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpp');
    }
};
