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
        Schema::create('e_import', function (Blueprint $table) {
            $table->id();
            $table->text('user_id');
            $table->text('modul')->nullable();
            $table->text('error_messages')->nullable();
            $table->json('imported_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_import');
    }
};
