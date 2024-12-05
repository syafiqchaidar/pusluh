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
        Schema::create('kabupaten', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 255);
            $table->text('nama');
            $table->text('latitude');
            $table->text('longitude');
            $table->unsignedBigInteger('provinsi_id');
            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('cascade');
            $table->index('provinsi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kabupaten');
    }
};
