<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $fillable = ['id_pasar', 'id_jenis_fasilitas', 'status_ketersediaan'];

    // Relasi untuk menarik nama fasilitas dari tabel master
    public function jenisFasilitas()
    {
        // belongsTo karena 1 baris fasilitas merujuk ke 1 jenis fasilitas
        return $this->belongsTo(JenisFasilitas::class, 'id_jenis_fasilitas');
    }
}