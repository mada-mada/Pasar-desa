<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

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

        return view('user.pasar.show', compact('pasar'));
    }

}
