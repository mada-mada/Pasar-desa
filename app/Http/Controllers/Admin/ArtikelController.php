<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    
    public function index()
    {
       
        $artikel = Artikel::with('penulis')
                    ->orderBy('tanggal_rilis', 'desc')
                    ->get();

       return response()->json([
        'success' => true,
        'message' => 'Detail Data Artikel',
        'data'    => $artikel
    ], 200);    
    }

   
    public function create()
    {
        // Return form create ke view
        return view('admin.artikel.create');
    }

    
    public function store(Request $request)
    {
      
        $validated = $request->validate([
            'id_admin' => 'required|exists:users,id',
            'judul_artikel' => 'required|string|max:255',
            'isi_konten' => 'required|string',
            'gambar_sampul' => 'nullable|image|max:2048', 
        ]);

        
        if ($request->hasFile('gambar_sampul')) {
            $validated['gambar_sampul'] = $request->file('gambar_sampul')->store('artikel', 'public');
        }

       
        Artikel::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return response()->json([
        'message' => 'Berhasil menambahkan artikel',
        ], 200);
    }

   
    public function show(string $id)
    {
        
        $artikel = Artikel::with('penulis')->findOrFail($id);

        
        return response()->json([
        'success' => true,
        'message' => 'Detail Data Artikel',
        'data'    => $artikel
      ], 200);
    }

    
    public function edit(string $id)
    {
       
        $artikel = Artikel::findOrFail($id);

        
        return view('admin.artikel.edit', compact('artikel'));
    }

   
    public function update(Request $request, string $id)
    {
       
        $artikel = Artikel::findOrFail($id);

   
        $validated = $request->validate([
            'id_admin' => 'required|exists:users,id',
            'judul_artikel' => 'required|string|max:255',
            'isi_konten' => 'required|string',
            'gambar_sampul' => 'nullable|image|max:2048',
        ]);

        
        if ($request->hasFile('gambar_sampul')) {
            // Hapus gambar lama jika ada
            if ($artikel->gambar_sampul) {
                Storage::disk('public')->delete($artikel->gambar_sampul);
            }
            $validated['gambar_sampul'] = $request->file('gambar_sampul')->store('artikel', 'public');
        }

      
        $artikel->update($validated);

        // Redirect ke halaman show dengan pesan sukses
        return response()->json([
        'message' => 'Berhasil memperbarui artikel',
        ], 200);
    }

   
    public function destroy(string $id)
    {
       
        $artikel = Artikel::findOrFail($id);

        
        if ($artikel->gambar_sampul) {
            Storage::disk('public')->delete($artikel->gambar_sampul);
        }

        
        $artikel->delete();

      
        return response()->json([
        'message' => 'Berhasil menghapus artikel',
        ], 200);
    }
}
