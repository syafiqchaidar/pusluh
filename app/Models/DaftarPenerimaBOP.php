<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPenerimaBOP extends Model
{
    use HasFactory;
    public $table = 't_penyuluh'; 
    protected $casts = [
        'wilbin' => 'json',
    ];
    protected $fillable = [
        'id',
        'provinsi_id',
        'kabupaten_id',
        'bpp_id',
        'nomor',
        'nama',
        'nik',
        'email',
        'no_hp',
        'status_penyuluh',
        'status_pendidikan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'wilbin',
        'status',
        'status_aktif',
        'tahun',
        'jenis_user',
        'jf_penyuluh_id',
        'kategori_jf_id',
        'pangkat_golongans_id',
        'nama_rekening',
        'nomor_rekening',
        'bank_rekening',
        'kelompok',
        'tanggal_nonaktif',
        'dokumen_nonaktif',
        'ket_nonaktif',
    ];
    public $timestamps = true;
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class,'provinsi_id');
    }
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class,'kabupaten_id');
    }
    public function bpp()
    {
        return $this->belongsTo(Bpp::class,'bpp_id');
    }
    public function statuspendidikan()
    {
        return $this->belongsTo(StatusPendidikan::class,'status_pendidikan');
    }
    public function statuspenyuluh()
    {
        return $this->belongsTo(StatusPenyuluh::class,'status_penyuluh');
    }
    public function jabatanfungsional()
    {
        return $this->belongsTo(JabatanFungsional::class,'jf_penyuluh_id');
    }
    public function kategorijabatan()
    {
        return $this->belongsTo(KategoriJabatanFungsional::class,'kategori_jf_id');
    }
    public function golongan()
    {
        return $this->belongsTo(PangkatGolongan::class,'pangkat_golongans_id');
    }
}
