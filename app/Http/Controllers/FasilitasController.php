<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\PasarDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan semua fasilitas dengan informasi pasar yang dimiliki
     * ALUR: Ambil semua fasilitas, include relasi pasar, urutkan per pasar
     */
    public function index()
    {
        // Query untuk mendapatkan semua fasilitas dengan relasi pasar yang dimiliki
        $fasilitas = Fasilitas::with('pasarDesa')
                       ->orderBy('id_pasar') // Urutkan berdasarkan pasar
                       ->get();

        // Return ke view dengan data fasilitas
        return view('fasilitas.index', compact('fasilitas'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat fasilitas baru
     * ALUR: Ambil daftar pasar -> Tampilkan form dengan dropdown pasar
     */
    public function create()
    {
        // Ambil semua pasar untuk dropdown di form
        $pasar = PasarDesa::all();

        // Return form create ke view
        return view('fasilitas.create', compact('pasar'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data fasilitas baru ke database
     * ALUR: Validasi input -> Simpan ke database -> Redirect dengan pesan sukses
     */
    public function store(Request $request)
    {
        // Validasi data input sesuai requirement migration
        $validated = $request->validate([
            'id_pasar' => 'required|exists:pasar_desa,id', // id_pasar harus ada di tabel pasar_desa
            'nama_fasilitas' => 'required|string|max:100',
            'status_ketersediaan' => 'required|in:Tersedia,Tidak Ada,Rusak', // Hanya enum values
        ]);

        // Buat record fasilitas baru di database
        Fasilitas::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail fasilitas yang dipilih
     * ALUR: Cari fasilitas by ID -> Include relasi pasar -> Tampilkan detail
     */
    public function show(string $id)
    {
        // Cari fasilitas berdasarkan ID, jika tidak ditemukan throw 404
        $fasilitas = Fasilitas::with('pasarDesa')->findOrFail($id);

        // Return ke view dengan data fasilitas detail
        return view('fasilitas.show', compact('fasilitas'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk edit fasilitas yang sudah ada
     * ALUR: Cari fasilitas by ID -> Ambil daftar pasar -> Tampilkan form dengan data existing
     */
    public function edit(string $id)
    {
        // Cari fasilitas berdasarkan ID
        $fasilitas = Fasilitas::findOrFail($id);

        // Ambil semua pasar untuk dropdown di form edit
        $pasar = PasarDesa::all();

        // Return form edit dengan data fasilitas yang sudah ada
        return view('fasilitas.edit', compact('fasilitas', 'pasar'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate data fasilitas yang sudah ada
     * ALUR: Validasi input -> Update database -> Redirect dengan pesan sukses
     */
    public function update(Request $request, string $id)
    {
        // Cari fasilitas berdasarkan ID
        $fasilitas = Fasilitas::findOrFail($id);

        // Validasi data input
        $validated = $request->validate([
            'id_pasar' => 'required|exists:pasar_desa,id',
            'nama_fasilitas' => 'required|string|max:100',
            'status_ketersediaan' => 'required|in:Tersedia,Tidak Ada,Rusak',
        ]);

        // Update record fasilitas di database
        $fasilitas->update($validated);

        // Redirect ke halaman show dengan pesan sukses
        return redirect()->route('fasilitas.show', $fasilitas->id)->with('success', 'Fasilitas berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus fasilitas dari database
     * ALUR: Cari fasilitas by ID -> Hapus record dari database -> Redirect
     */
    public function destroy(string $id)
    {
        // Cari fasilitas berdasarkan ID
        $fasilitas = Fasilitas::findOrFail($id);

        // Hapus record fasilitas dari database
        $fasilitas->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil dihapus!');
    }
}
