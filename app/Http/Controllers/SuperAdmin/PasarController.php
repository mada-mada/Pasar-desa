<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PasarDesa;

class PasarController extends Controller
{
    public function index()
    {
        $pasars = PasarDesa::latest()->get();
        return view('superadmin.pasar.index', compact('pasars'));
    }

    public function show($id)
    {
        $pasar = PasarDesa::with(['fasilitas', 'lokasiGis'])->findOrFail($id);
        return view('superadmin.pasar.show', compact('pasar'));
    }

    public function destroy($id)
    {
        $pasar = PasarDesa::findOrFail($id);
        $pasar->delete();

        return redirect()->route('superadmin.pasar.index')->with('success', 'Profil Pasar Desa berhasil dihapus oleh Super Admin.');
    }
}