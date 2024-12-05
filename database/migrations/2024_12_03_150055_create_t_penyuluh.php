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
        Schema::create('t_penyuluh', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id')->nullable();
            $table->unsignedBigInteger('bpp_id')->nullable();
            $table->string('nomor',255)->unique();
            $table->text('nama')->nullable();
            $table->string('nik',255)->unique();
            $table->string('email',255)->unique();
            $table->string('no_hp',30)->nullable();
            $table->integer('status_penyuluh')->nullable();
            $table->string('status_pendidikan',30)->nullable();
            $table->string('jenis_kelamin',10)->nullable();
            $table->text('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->json('wilbin')->nullable();
            $table->tinyInteger('status')->default(false);
            $table->tinyInteger('status_aktif')->nullable();
            $table->string('tahun',30)->nullable();
            $table->string('jenis_user',30)->nullable();
            $table->integer('jf_penyuluh_id')->nullable();
            $table->integer('kategori_jf_id')->nullable();
            $table->integer('pangkat_golongans_id')->nullable();
            $table->text('nama_rekening')->nullable();
            $table->text('nomor_rekening')->nullable();
            $table->text('bank_rekening')->nullable();
            $table->longText('kelompok')->nullable();
            $table->date('tanggal_nonaktif')->nullable();
            $table->text('dokumen_nonaktif')->nullable();
            $table->text('ket_nonaktif')->nullable();
            $table->timestamps();

            $table->index('bpp_id');
            $table->index('nomor');
            $table->index('nama');
            $table->index('nik');
            $table->index('email');
            $table->index('status_penyuluh');
            $table->index('status_pendidikan');
            $table->index('jenis_kelamin');
            $table->index('status');
            $table->index('status_aktif');
            $table->index('jf_penyuluh_id');
            $table->index('kategori_jf_id');
            $table->index('pangkat_golongans_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_penyuluh');
    }
};
