<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\JenisFasilitas;

class FasilitasController extends Controller
{
    public function index()
    {
        // Mengambil semua fasilitas beserta relasi pasar desa dan jenis fasilitasnya
        $fasilitas = JenisFasilitas::get();
        return response()->json([
            'message' => 'berhasil mengambil data fasilitas',
            'data' => $fasilitas
        ], 200);
    }

    public function create()
    {
        return view('superadmin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:100',
            'icon_fasilitas' => 'nullable|string|max:255',
        ]);

        JenisFasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'icon_fasilitas' => $request->icon_fasilitas,
        ]);

        return response()->json([
            'message' => 'Fasilitas berhasil disimpan!',
        ], 201);
    }

    public function show($id)
    {
        $fasilitas = JenisFasilitas::jenisFasilitas()->findOrFail($id);
       return response()->json([
            'success' => true,
            'message' => 'Detail Data Fasilitas',
            'data'    => $fasilitas
        ], 200);
    }

    public function edit($id)
    {
        $fasilitas = JenisFasilitas::findOrFail($id);
        return response()->json([
            'message' => 'berhasil mengambil data fasilitas',
            'data' => $fasilitas
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $fasilitas = JenisFasilitas::findOrFail($id);

        $request->validate([
            'nama_fasilitas' => 'required|string|max:100',
            'icon_fasilitas' => 'nullable|string|max:255',
        ]);

        $fasilitas->update([
            'nama_fasilitas' => $request->nama_fasilitas,
            'icon_fasilitas' => $request->icon_fasilitas,
        ]);

        return response()->json([
            'message' => 'Fasilitas berhasil diperbarui!',
        ], 200);
    }

    public function destroy($id)
    {
        $fasilitas = JenisFasilitas::findOrFail($id);
        $fasilitas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas berhasil dihapus oleh Super Admin.'
        ], 200);
    }
}