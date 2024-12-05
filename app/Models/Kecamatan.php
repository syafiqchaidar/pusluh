<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    public $table = 'kecamatan'; 
    protected $fillable = [
        'id',
        'kode',
        'nama',
        'latitude',
        'longitude',
        'provinsi_id',
        'kabupaten_id',
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
    public function desa()
    {
        return $this->hasMany(Desa::class);
    }
}
