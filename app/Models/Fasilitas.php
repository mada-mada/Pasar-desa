<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $fillable = [
        'id_pasar',
        'nama_fasilitas',
        'status_ketersediaan',
    ];

    // Relasi Many-to-One (Inverse): Fasilitas ini milik suatu Pasar
    public function pasarDesa()
    {
        return $this->belongsTo(PasarDesa::class, 'id_pasar', 'id');
    }
}