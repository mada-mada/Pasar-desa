<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::with('penulis')->latest()->get();
        return response()->json([
            'message' => 'berhasil mengambil data artikel',
            'data' => $artikels
        ], 200);
    }

    public function show($id)
    {
        $artikel = Artikel::with('penulis')->findOrFail($id);
        return response()->json([
            'message' => 'berhasil mengambil data artikel',
            'data' => $artikel
        ], 200);
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();

        return response()->json([
            'message' => 'Artikel berhasil dihapus oleh Super Admin.'
        ], 200);
    }
}
