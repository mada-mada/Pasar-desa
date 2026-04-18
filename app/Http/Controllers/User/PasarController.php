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
        
        $dataPeta = $Pasar->map(function($p) {
            return [
                'id' => $p->id,
                'nama_pasar' => $p->nama_pasar,
                'alamat_lengkap' => $p->alamat_lengkap,
                // Pastikan JSON di-decode agar tidak error di JavaScript
                'lokasi_gis' => $p->lokasiGis
            ];
        });
       
        $artikel = Artikel::latest()->take(3)->get();
       
        return view('index', compact('Pasar', 'artikel', 'dataPeta'));
    }

    public function list(Request $request)
    {
        $query = PasarDesa::with(['lokasiGis', 'fasilitas']);
        
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_pasar', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat_lengkap', 'like', '%' . $request->search . '%');
        }
        
        $pasarPage = $query->paginate(9);
        
        return view('user.pasar.list', compact('pasarPage'));
    }

    public function show($id)
    {
        // Cukup panggil 1 pasar beserta relasinya
        $pasar = PasarDesa::with(['fasilitas', 'lokasiGis'])->findOrFail($id);

        // Langsung lempar ke view, tidak perlu $dataPeta karena datanya cuma 1
        return view('user.pasar.show', compact('pasar'));
    }
}
