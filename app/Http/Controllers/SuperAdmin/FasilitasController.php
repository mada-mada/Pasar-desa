<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\JenisFasilitas;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = JenisFasilitas::get();
        return view('superadmin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('superadmin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:100',
            'icon_fasilitas' => 'nullable|string|max:255',
        ]);

        JenisFasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'icon_fasilitas' => $request->icon_fasilitas,
        ]);

        return redirect()->route('superadmin.fasilitas.index')
                         ->with('success', 'Jenis Fasilitas berhasil ditambahkan!');
    }

    public function show($id)
    {
        // Tidak diperlukan implementasi spesifik jika tidak ada web page detail untuk referensi dictionary ini
        return redirect()->route('superadmin.fasilitas.index');
    }

    public function edit($id)
    {
        $fasilitas = JenisFasilitas::findOrFail($id);
        return view('superadmin.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, $id)
    {
        $fasilitas = JenisFasilitas::findOrFail($id);

        $request->validate([
            'nama_fasilitas' => 'required|string|max:100',
            'icon_fasilitas' => 'nullable|string|max:255',
        ]);

        $fasilitas->update([
            'nama_fasilitas' => $request->nama_fasilitas,
            'icon_fasilitas' => $request->icon_fasilitas,
        ]);

        return redirect()->route('superadmin.fasilitas.index')
                         ->with('success', 'Tipe Fasilitas berhasil diubah dan diperbarui!');
    }

    public function destroy($id)
    {
        $fasilitas = JenisFasilitas::findOrFail($id);
        $fasilitas->delete();

        return redirect()->route('superadmin.fasilitas.index')
                         ->with('success', 'Data Master Jenis Fasilitas berhasil dihapus sepenuhnya.');
    }
}