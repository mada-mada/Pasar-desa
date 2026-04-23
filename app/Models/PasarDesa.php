<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function getFotoPasarUrlAttribute(): ?string
    {
        return $this->resolvePublicImageUrl($this->foto_pasar);
    }

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
