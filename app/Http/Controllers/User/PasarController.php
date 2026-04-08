<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasarDesa;

class PasarController extends Controller
{
   
    public function index()
    {
        $Pasar = PasarDesa::all();
        return view('pasar.index', compact('Pasar'));
    }

   
    public function show( $id)
    {
        $pasar = PasarDesa::with(['fasilitas', 'lokasiGis'])->findOrFail($id);

        return view('front.pasar.show', compact('pasar'));
    }

}
