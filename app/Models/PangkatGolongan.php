<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PangkatGolongan extends Model
{
    use HasFactory;
    public $table = 'panggol'; 
    protected $fillable = [
        'id',
        'nama',
        'jf_penyuluh_id',
        'status_penyuluh_id',
    ];
    public $timestamps = false;
    public function jf()
    {
        return $this->belongsTo(JabatanFungsional::class,'jf_penyuluh_id');
    }
    public function status()
    {
        return $this->belongsTo(StatusPenyuluh::class,'status_penyuluh_id');
    }
}
