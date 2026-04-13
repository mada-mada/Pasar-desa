<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admin = User::where('role', 'Admin')->get();
        return response()->json([
            'message' => 'berhasil mengambil data admin',
            'data' => $admin
        ], 200);
    }

    public function create()
    {
        return view('superadmin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string|max:100',
        ]);

        User::create([
            'username' => $request->username,
            'password' => $request->password, // Akan di-hash otomatis oleh model User
            'role' => 'Admin',
            'nama_lengkap' => $request->nama_lengkap,
        ]);

        return response()->json([
            'message' => 'Akun Admin berhasil ditambahkan',
            ], 201);
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return response()->json([
            'message' => 'berhasil mengambil data admin',
            'data' => $admin
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'nama_lengkap' => 'required|string|max:100',
            'password' => 'nullable|string|min:6',
        ]);

        $admin->username = $request->username;
        $admin->nama_lengkap = $request->nama_lengkap;
        
        if ($request->filled('password')) {
            $admin->password = $request->password;
        }
        
        $admin->save();

        return response()->json([
            'message' => 'Akun Admin berhasil diperbarui',
            'data' => $admin
        ], 200);
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return response()->json([
            'message' => 'Akun Admin berhasil dihapus'
        ], 200);
    }
}