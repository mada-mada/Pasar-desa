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
        return view('superadmin.admin.index', compact('admin'));
    }

    public function create()
    {
        return view('superadmin.admin.create');
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
            'password' => $request->password,
            'role' => 'Admin',
            'nama_lengkap' => $request->nama_lengkap,
        ]);

        return redirect()->route('superadmin.admin.index')->with('success', 'Akun Admin berhasil ditambahkan');
    }

    public function show($id)
    {
        // Not widely used for Admin account typically, but to satisfy interface
        return redirect()->route('superadmin.admin.index');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('superadmin.admin.edit', compact('admin'));
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
            // Password mutator on User model will hash it
            $admin->password = $request->password;
        }
        
        $admin->save();

        return redirect()->route('superadmin.admin.index')->with('success', 'Data Akun Admin berhasil diperbarui');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('superadmin.admin.index')->with('success', 'Akun Admin berhasil dihapus');
    }
}