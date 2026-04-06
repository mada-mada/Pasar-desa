<?php

namespace App\Http\Controllers;

use App\Models\PasarDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PasarController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan semua daftar pasar desa
     * ALUR: Ambil semua data pasar -> Urutkan berdasarkan nama -> Tampilkan di view
     */
    public function index()
    {
        // Query untuk mendapatkan semua pasar dengan data relasi jika diperlukan di view
        $pasar = PasarDesa::orderBy('nama_pasar')
                          ->get();

        // Return ke view dengan data pasar
        return view('pasar.index', compact('pasar'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat pasar baru
     * ALUR: Tampilkan form create kosong siap untuk input data pasar baru
     */
    public function create()
    {
        // Return form create ke view
        return view('pasar.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data pasar baru ke database
     * ALUR: Validasi input -> Upload foto jika ada -> Simpan ke database -> Redirect dengan pesan sukses
     */
    public function store(Request $request)
    {
        // Validasi data input sesuai requirement migration
        $validated = $request->validate([
            'nama_pasar' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'deskripsi' => 'required|string',
            'hari_pasaran' => 'required|string|max:50',
            'jam_operasional' => 'required|string|max:50',
            'foto_pasar' => 'nullable|image|max:2048', // Photo opsional, max 2MB
        ]);

        // Jika ada file foto, simpan ke storage
        if ($request->hasFile('foto_pasar')) {
            $validated['foto_pasar'] = $request->file('foto_pasar')->store('pasar', 'public');
        }

        // Buat record pasar baru di database
        PasarDesa::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pasar.index')->with('success', 'Pasar berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail pasar yang dipilih beserta fasilitas dan lokasi GIS
     * ALUR: Cari pasar by ID -> Include semua relasi (fasilitas, lokasi) -> Tampilkan detail
     */
    public function show(string $id)
    {
        // Cari pasar berdasarkan ID dengan relasi fasilitas dan lokasi GIS
        // jika tidak ditemukan throw 404
        $pasar = PasarDesa::with(['fasilitas', 'lokasiGis'])
                         ->findOrFail($id);

        // Return ke view dengan data pasar detail lengkap
        return view('pasar.show', compact('pasar'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk edit pasar yang sudah ada
     * ALUR: Cari pasar by ID -> Tampilkan form dengan data pasar yang existing
     */
    public function edit(string $id)
    {
        // Cari pasar berdasarkan ID
        $pasar = PasarDesa::findOrFail($id);

        // Return form edit dengan data pasar yang sudah ada
        return view('pasar.edit', compact('pasar'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate data pasar yang sudah ada
     * ALUR: Validasi input -> Upload foto jika ada -> Update database -> Redirect dengan pesan sukses
     */
    public function update(Request $request, string $id)
    {
        // Cari pasar berdasarkan ID
        $pasar = PasarDesa::findOrFail($id);

        // Validasi data input
        $validated = $request->validate([
            'nama_pasar' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'deskripsi' => 'required|string',
            'hari_pasaran' => 'required|string|max:50',
            'jam_operasional' => 'required|string|max:50',
            'foto_pasar' => 'nullable|image|max:2048',
        ]);

        // Jika ada file foto baru, simpan dan hapus foto lama
        if ($request->hasFile('foto_pasar')) {
            // Hapus foto lama jika ada
            if ($pasar->foto_pasar) {
                Storage::disk('public')->delete($pasar->foto_pasar);
            }
            $validated['foto_pasar'] = $request->file('foto_pasar')->store('pasar', 'public');
        }

        // Update record pasar di database
        $pasar->update($validated);

        // Redirect ke halaman show dengan pesan sukses
        return redirect()->route('pasar.show', $pasar->id)->with('success', 'Pasar berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus pasar dari database
     * ALUR: Cari pasar by ID -> Hapus foto jika ada -> Hapus record dari database -> Redirect
     * NOTE: Fasilitas yang linked ke pasar ini otomatis terhapus karena cascade on delete
     */
    public function destroy(string $id)
    {
        // Cari pasar berdasarkan ID
        $pasar = PasarDesa::findOrFail($id);

        // Hapus file foto jika ada
        if ($pasar->foto_pasar) {
            Storage::disk('public')->delete($pasar->foto_pasar);
        }

        // Hapus record pasar dari database
        // Note: Fasilitas yang terhubung akan otomatis terhapus karena onDelete('cascade')
        $pasar->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pasar.index')->with('success', 'Pasar berhasil dihapus!');
    }
}
