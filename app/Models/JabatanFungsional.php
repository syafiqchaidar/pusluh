<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanFungsional extends Model
{
    use HasFactory;
    public $table = 'jf_penyuluh'; 
    protected $fillable = [
        'id',
        'kategori_jf_id',
        'jenjang_jabat',
        'batas_usia',
    ];
    public $timestamps = false;
    public function kategorijf()
    {
        return $this->belongsTo(KategoriJabatanFungsional::class,'kategori_jf_id');
    }
}
