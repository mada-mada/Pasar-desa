<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasarDesa extends Model
{
    use HasFactory;

    protected $table = 'pasar_desa';

    protected $fillable = [
        'id',
        'nama_pasar',
        'alamat_lengkap',
        'deskripsi',
        'hari_pasaran',
        'jam_operasional',
        'foto_pasar',
    ];

    // Relasi One-to-Many: 1 Pasar memiliki banyak Fasilitas
    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'id_pasar', 'id');
    }

    // Relasi One-to-One: 1 Pasar memiliki 1 titik Lokasi GIS
    public function lokasiGis()
    {
        return $this->hasOne(LokasiGis::class, 'id_pasar', 'id');
    }
}