<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPenyuluh extends Model
{
    use HasFactory;
    public $table = 'status_penyuluh'; 
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
