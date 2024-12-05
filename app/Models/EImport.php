<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EImport extends Model
{
    use HasFactory;
    public $table = 'e_import'; 
    protected $casts = [
        'error_messages' => 'json',
        'imported_data' => 'json',
    ];
    protected $fillable = [
        'id',
        'user_id',
        'error_messages',
        'imported_data',
        'modul',
    ];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
