<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $artikel = Artikel::with('penulis')
                          ->orderBy('tanggal_rilis', 'desc')
                            ->get();

        return view('user.artikel.index', compact('artikel'));
    }


    public function show(string $id)
    {
        $artikel = Artikel::with('penulis')
                          ->where('id', $id)
                          ->findOrFail($id);

        return view('user.artikel.show', compact('artikel'));
    }


}
