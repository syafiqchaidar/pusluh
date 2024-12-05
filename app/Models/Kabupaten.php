<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    public $table = 'kabupaten'; 
    protected $casts = [
        'path' => 'json',
    ];
    protected $fillable = [
        'id',
        'kode',
        'nama',
        'latitude',
        'longitude',
        'provinsi_id',
        'path'
    ];
    public $timestamps = false;
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class,'provinsi_id');
    }
    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }
    public function desa()
    {
        return $this->hasMany(Desa::class);
    }
}
