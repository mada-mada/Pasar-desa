<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;

class FasilitasController extends Controller
{
    public function index()
    {
        // Mengambil semua fasilitas beserta relasi pasar desa dan jenis fasilitasnya
        $fasilitas = Fasilitas::with(['pasarDesa', 'jenisFasilitas'])->latest()->get();
        return view('superadmin.fasilitas.index', compact('fasilitas'));
    }

    public function show($id)
    {
        $fasilitas = Fasilitas::with(['pasarDesa', 'jenisFasilitas'])->findOrFail($id);
        return view('superadmin.fasilitas.show', compact('fasilitas'));
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        return redirect()->route('superadmin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus oleh Super Admin.');
    }
}