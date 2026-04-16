<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PasarDesa;
use App\Models\Artikel; // Tambahkan ini

class PasarController extends Controller
{
    public function index(Request $request)
    {
        $query = PasarDesa::with(['lokasiGis', 'fasilitas']);
        
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_pasar', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat_lengkap', 'like', '%' . $request->search . '%');
        }
        
        $Pasar = $query->get();
        // Fetch 3 latest articles
        $artikel = Artikel::latest()->take(3)->get();
        
        return view('index', compact('Pasar', 'artikel'));
    }

    public function show($id)
    {
        $pasar = PasarDesa::with(['fasilitas', 'lokasiGis'])->findOrFail($id);

        return view('user.pasar.show', compact('pasar'));
    }
}
