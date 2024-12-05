<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJabatanFungsional extends Model
{
    use HasFactory;
    public $table = 'kategori_jf'; 
    protected $fillable = [
        'id',
        'nama',
    ];
    public $timestamps = false;
}
