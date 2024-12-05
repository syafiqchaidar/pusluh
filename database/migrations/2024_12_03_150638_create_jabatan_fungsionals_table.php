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
        Schema::create('jf_penyuluh', function (Blueprint $table) {
            $table->id();
            $table->text('kategori_jf_id');
            $table->text('jenjang_jabat')->nullable();
            $table->text('batas_usia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jf_penyuluh');
    }
};
