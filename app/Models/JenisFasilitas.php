<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisFasilitas extends Model
{
    protected $table = 'jenis_fasilitas';
    protected $fillable = ['nama_fasilitas', 'icon_fasilitas'];
}
