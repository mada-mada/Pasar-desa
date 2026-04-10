<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username'     => 'required|unique:users,username',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'role'         => 'required|in:Super Admin,Admin',
            'nama_lengkap' => 'required|string|max:255',
        ]);

        // 2. Simpan ke database
        // Karena kita sudah menambahkan 'hashed' di Model, 
        // password akan otomatis di-hash tanpa perlu menggunakan Hash::make()
        $user = User::create([
            'username'     => $request->username,
            'password'     => $request->password, 
            'role'         => $request->role,
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,

        ]);

        // 3. Kembalikan response JSON
        return response()->json([
            'message' => 'Berhasil membuat user ' . $user->role,
            'data'    => $user
        ], 201);
    }
}