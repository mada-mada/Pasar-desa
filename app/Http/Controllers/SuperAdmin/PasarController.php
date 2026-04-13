<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PasarDesa;

class PasarController extends Controller
{
    public function index()
    {
        $pasar = PasarDesa::latest()->get();
       return response()->json([
        'message' => 'berhasil mengambil data pasar',
        'data' => $pasar
        ], 200);
    }

    public function show($id)
    {
        $pasar = PasarDesa::with(['fasilitas', 'lokasiGis'])->findOrFail($id);
       return response()->json([
            'success' => true,
            'message' => 'Detail Data Pasar',
            'data'    => $pasar
        ], 200);
    }

    public function destroy($id)
    {
        $pasar = PasarDesa::findOrFail($id);
        $pasar->delete();

        return response()->json([
            'success' => true,
            'message' => 'berhasil menghapus data pasar'
        ], 200);
    }
}