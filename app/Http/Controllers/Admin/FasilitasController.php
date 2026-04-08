<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\PasarDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    
    public function index()
    {
        
        $fasilitas = Fasilitas::with('pasarDesa')
                       ->orderBy('id_pasar') // Urutkan berdasarkan pasar
                       ->get();

        return view('fasilitas.index', compact('fasilitas'));
    }

 
    public function create()
    {
     
        $pasar = PasarDesa::all();

        // Return form create ke view
        return view('fasilitas.create', compact('pasar'));
    }

   
    public function store(Request $request)
    {
        // Validasi data input sesuai requirement migration
        $validated = $request->validate([
            'id_pasar' => 'required|exists:pasar_desa,id', 
            'nama_fasilitas' => 'required|string|max:100',
            'status_ketersediaan' => 'required|in:Tersedia,Tidak Ada,Rusak', 
        ]);

        Fasilitas::create($validated);

        
        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil disimpan!');
    }

   
    public function show(string $id)
    {
      
        $fasilitas = Fasilitas::with('pasarDesa')->findOrFail($id);

        // Return ke view dengan data fasilitas detail
        return view('fasilitas.show', compact('fasilitas'));
    }

  
    public function edit(string $id)
    {
     
        $fasilitas = Fasilitas::findOrFail($id);

        
        $pasar = PasarDesa::all();

        
        return view('fasilitas.edit', compact('fasilitas', 'pasar'));
    }

 
    public function update(Request $request, string $id)
    {
        
        $fasilitas = Fasilitas::findOrFail($id);

      
        $validated = $request->validate([
            'id_pasar' => 'required|exists:pasar_desa,id',
            'nama_fasilitas' => 'required|string|max:100',
            'status_ketersediaan' => 'required|in:Tersedia,Tidak Ada,Rusak',
        ]);

        
        $fasilitas->update($validated);

       
        return redirect()->route('fasilitas.show', $fasilitas->id)->with('success', 'Fasilitas berhasil diupdate!');
    }

    public function destroy(string $id)
    {
       
        $fasilitas = Fasilitas::findOrFail($id);

      
        $fasilitas->delete();

       
        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil dihapus!');
    }
}
