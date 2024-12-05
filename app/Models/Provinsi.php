<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    public $table = 'provinsi'; 
    protected $casts = [
        'path' => 'json',
    ];
    protected $fillable = [
        'id',
        'kode',
        'nama',
        'latitude',
        'longitude',
        'path'
    ];
    public $timestamps = false;
    public function kabupaten()
    {
        return $this->hasMany(Kabupaten::class);
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
