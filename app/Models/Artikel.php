<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function getGambarSampulUrlAttribute(): ?string
    {
        return $this->resolvePublicImageUrl($this->gambar_sampul);
    }

    // Relasi Many-to-One (Inverse): Artikel ini ditulis oleh suatu Admin
    public function penulis()
    {
        // Penamaan fungsi diubah menjadi 'penulis' agar lebih logis saat dipanggil (misal: $artikel->penulis->nama_lengkap)
        return $this->belongsTo(User::class, 'id_admin', 'id');
    }

    private function resolvePublicImageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (Str::startsWith($path, ['/storage/', 'storage/'])) {
            return asset(ltrim($path, '/'));
        }

        return Storage::disk('public')->url($path);
    }
}
