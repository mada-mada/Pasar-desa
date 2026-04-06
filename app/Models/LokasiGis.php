<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiGis extends Model
{
    use HasFactory;

    protected $table = 'lokasi_gis';

    protected $fillable = [
        'id_pasar',
        'latitude',
        'longitude',
    ];

    // Relasi One-to-One (Inverse): Titik lokasi ini milik suatu Pasar
    public function pasarDesa()
    {
        return $this->belongsTo(PasarDesa::class, 'id_pasar', 'id');
    }
}