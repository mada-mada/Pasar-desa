<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::with('penulis')->latest()->get();
        return view('superadmin.artikel.index', compact('artikel'));
    }

    public function show($id)
    {
        // Redirect super admin ke public artikel page
        return redirect()->route('artikel.show', $id);
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();

        return redirect()->route('superadmin.artikel.index')->with('success', 'Artikel berhasil dihapus permanen oleh Super Admin.');
    }
}
