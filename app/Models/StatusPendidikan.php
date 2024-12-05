<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPendidikan extends Model
{
    use HasFactory;
    public $table = 'status_pendidikan'; 
    protected $fillable = [
        'id',
        'nama',
    ];
    public $timestamps = false;
    public function penyuluh()
    {
        return $this->hasMany(User::class);
    }
}
