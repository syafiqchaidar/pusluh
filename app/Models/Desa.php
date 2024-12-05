<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    public $table = 'desa'; 
    protected $fillable = [
        'id',
        'kode',
        'nama',
        'latitude',
        'longitude',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
    ];
    public $timestamps = false;
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
