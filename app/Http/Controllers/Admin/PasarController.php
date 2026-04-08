<?php

namespace App\Http\Controllers;

use App\Models\PasarDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PasarController extends Controller
{
    
    public function index()
    {

        $pasar = PasarDesa::orderBy('nama_pasar')
                          ->get();

     
        return view('pasar.index', compact('pasar'));
    }

  
    public function create()
    {
        
        return view('pasar.create');
    }

    
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nama_pasar' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'deskripsi' => 'required|string',
            'hari_pasaran' => 'required|string|max:50',
            'jam_operasional' => 'required|string|max:50',
            'foto_pasar' => 'nullable|image|max:2048', // Photo opsional, max 2MB
        ]);

    
        if ($request->hasFile('foto_pasar')) {
            $validated['foto_pasar'] = $request->file('foto_pasar')->store('pasar', 'public');
        }

       
        PasarDesa::create($validated);

       
        return redirect()->route('pasar.index')->with('success', 'Pasar berhasil disimpan!');
    }

   
    public function show(string $id)
    {
        
        $pasar = PasarDesa::with(['fasilitas', 'lokasiGis'])
                         ->findOrFail($id);

      
        return view('pasar.show', compact('pasar'));
    }

    
    public function edit(string $id)
    {
        
        $pasar = PasarDesa::findOrFail($id);

        
        return view('pasar.edit', compact('pasar'));
    }

  
    public function update(Request $request, string $id)
    {
       
        $pasar = PasarDesa::findOrFail($id);

       
        $validated = $request->validate([
            'nama_pasar' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'deskripsi' => 'required|string',
            'hari_pasaran' => 'required|string|max:50',
            'jam_operasional' => 'required|string|max:50',
            'foto_pasar' => 'nullable|image|max:2048',
        ]);

       
        if ($request->hasFile('foto_pasar')) {
           
            if ($pasar->foto_pasar) {
                Storage::disk('public')->delete($pasar->foto_pasar);
            }
            $validated['foto_pasar'] = $request->file('foto_pasar')->store('pasar', 'public');
        }

       
        $pasar->update($validated);

        
        return redirect()->route('pasar.show', $pasar->id)->with('success', 'Pasar berhasil diupdate!');
    }

    
    public function destroy(string $id)
    {
       
        $pasar = PasarDesa::findOrFail($id);

        if ($pasar->foto_pasar) {
            Storage::disk('public')->delete($pasar->foto_pasar);
        }
        $pasar->delete();

        return redirect()->route('pasar.index')->with('success', 'Pasar berhasil dihapus!');
    }
}
