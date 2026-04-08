<?php

namespace App\Http\Controllers;

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

        return view('artikel.index', compact('artikel'));
    }

   
    public function create()
    {
        // Return form create ke view
        return view('artikel.create');
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
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil disimpan!');
    }

   
    public function show(string $id)
    {
        
        $artikel = Artikel::with('penulis')->findOrFail($id);

        
        return view('artikel.show', compact('artikel'));
    }

    
    public function edit(string $id)
    {
       
        $artikel = Artikel::findOrFail($id);

        
        return view('artikel.edit', compact('artikel'));
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
        return redirect()->route('artikel.show', $artikel->id)->with('success', 'Artikel berhasil diupdate!');
    }

   
    public function destroy(string $id)
    {
       
        $artikel = Artikel::findOrFail($id);

        
        if ($artikel->gambar_sampul) {
            Storage::disk('public')->delete($artikel->gambar_sampul);
        }

        
        $artikel->delete();

      
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
