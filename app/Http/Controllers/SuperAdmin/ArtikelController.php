<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::with('penulis')->latest()->get();
        return view('superadmin.artikel.index', compact('artikels'));
    }

    public function show($id)
    {
        $artikel = Artikel::with('penulis')->findOrFail($id);
        return view('superadmin.artikel.show', compact('artikel'));
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();

        return redirect()->route('superadmin.artikel.index')->with('success', 'Artikel berhasil dihapus oleh Super Admin.');
    }
}