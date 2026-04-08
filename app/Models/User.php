<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

   protected $table = 'users';

    // Kolom yang diizinkan untuk diisi
    protected $fillable = [
        'username',
        'password',
        'role',
        'nama_lengkap',
    ];

    // Menyembunyikan password agar tidak ikut terpanggil saat query data
    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Laravel akan otomatis menghash password
        ];
    }

    // Relasi One-to-Many: 1 Admin bisa menulis banyak Artikel
    public function artikels()
    {
        return $this->hasMany(Artikel::class, 'id_admin', 'id');
    }
}
