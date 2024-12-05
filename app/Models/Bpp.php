<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bpp extends Model
{
    use HasFactory;
    public $table = 'bpp'; 
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
        return $this->belongsTo(Provinsi::class,'provinsi_id');
    }
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class,'kabupaten_id');
    }
}
