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
        Schema::table('users', function (Blueprint $table) {
            
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id')->nullable();
            $table->unsignedBigInteger('bpp_id')->nullable();
            $table->tinyInteger('aktif')->nullable();
            $table->string('no_hp',30)->nullable();
            $table->text('username')->nullable();
            $table->string('nomor',255)->unique();
            $table->string('nik',255)->unique();
            $table->string('status_penyuluh',10)->nullable();
            $table->string('status_pendidikan',30)->nullable();
            $table->string('jenis_kelamin',10)->nullable();
            $table->text('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->json('wilbin')->nullable();
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

            $table->index('aktif');
            $table->index('provinsi_id');
            $table->index('kabupaten_id');
            $table->index('bpp_id');
            $table->index('nomor');
            $table->index('email');
            $table->index('nik');
            $table->index('username');
            $table->index('status_penyuluh');
            $table->index('status_pendidikan');
            $table->index('jenis_kelamin');
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
