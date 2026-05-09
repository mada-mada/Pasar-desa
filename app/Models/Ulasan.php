<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $fillable = [
        'ulasanable_id',
        'ulasanable_type',
        'nama_pengunjung',
        'kontak',
        'rating',
        'komentar',
        'is_approved',
    ];

    public function ulasanable()
    {
        return $this->morphTo();
    }
}
