<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $fillable = [
        'id_admin',
        'judul_artikel',
        'isi_konten',
        'tanggal_rilis',
        'gambar_sampul',
    ];

    // Memastikan format tanggal otomatis terbaca sebagai instance Carbon di Laravel
    protected $casts = [
        'tanggal_rilis' => 'datetime',
    ];

    // Relasi Many-to-One (Inverse): Artikel ini ditulis oleh suatu Admin
    public function penulis()
    {
        // Penamaan fungsi diubah menjadi 'penulis' agar lebih logis saat dipanggil (misal: $artikel->penulis->nama_lengkap)
        return $this->belongsTo(User::class, 'id_admin', 'id');
    }
}