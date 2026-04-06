<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan semua artikel dengan informasi admin penulis
     * ALUR: Ambil semua data dari tabel artikel, urutkan dari terbaru, include admin info
     */
    public function index()
    {
        // Query untuk mendapatkan semua artikel dengan relasi penulis (admin)
        $artikel = Artikel::with('penulis')
                    ->orderBy('tanggal_rilis', 'desc') // Urutkan dari artikel terbaru
                    ->get();

        // Return ke view dengan data artikel
        return view('artikel.index', compact('artikel'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat artikel baru
     * ALUR: Tampilkan form create kosong siap untuk input
     */
    public function create()
    {
        // Return form create ke view
        return view('artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data artikel baru ke database
     * ALUR: Validasi input -> Simpan ke database -> Redirect dengan pesan sukses
     */
    public function store(Request $request)
    {
        // Validasi data input sesuai requirement
        $validated = $request->validate([
            'id_admin' => 'required|exists:users,id',
            'judul_artikel' => 'required|string|max:255',
            'isi_konten' => 'required|string',
            'gambar_sampul' => 'nullable|image|max:2048', // File gambar opsional, max 2MB
        ]);

        // Jika ada file gambar, simpan ke storage
        if ($request->hasFile('gambar_sampul')) {
            $validated['gambar_sampul'] = $request->file('gambar_sampul')->store('artikel', 'public');
        }

        // Buat record artikel baru di database
        Artikel::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail artikel yang dipilih
     * ALUR: Cari artikel by ID -> Include relasi penulis -> Tampilkan detail
     */
    public function show(string $id)
    {
        // Cari artikel berdasarkan ID, jika tidak ditemukan throw 404
        $artikel = Artikel::with('penulis')->findOrFail($id);

        // Return ke view dengan data artikel detail
        return view('artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk edit artikel yang sudah ada
     * ALUR: Cari artikel by ID -> Tampilkan form dengan data artikel yang ada
     */
    public function edit(string $id)
    {
        // Cari artikel berdasarkan ID
        $artikel = Artikel::findOrFail($id);

        // Return form edit dengan data artikel yang sudah ada
        return view('artikel.edit', compact('artikel'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate data artikel yang sudah ada
     * ALUR: Validasi input -> Update database -> Redirect dengan pesan sukses
     */
    public function update(Request $request, string $id)
    {
        // Cari artikel berdasarkan ID
        $artikel = Artikel::findOrFail($id);

        // Validasi data input
        $validated = $request->validate([
            'id_admin' => 'required|exists:users,id',
            'judul_artikel' => 'required|string|max:255',
            'isi_konten' => 'required|string',
            'gambar_sampul' => 'nullable|image|max:2048',
        ]);

        // Jika ada file gambar baru, simpan dan hapus gambar lama
        if ($request->hasFile('gambar_sampul')) {
            // Hapus gambar lama jika ada
            if ($artikel->gambar_sampul) {
                Storage::disk('public')->delete($artikel->gambar_sampul);
            }
            $validated['gambar_sampul'] = $request->file('gambar_sampul')->store('artikel', 'public');
        }

        // Update record artikel di database
        $artikel->update($validated);

        // Redirect ke halaman show dengan pesan sukses
        return redirect()->route('artikel.show', $artikel->id)->with('success', 'Artikel berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus artikel dari database
     * ALUR: Cari artikel by ID -> Hapus gambar jika ada -> Hapus record dari database -> Redirect
     */
    public function destroy(string $id)
    {
        // Cari artikel berdasarkan ID
        $artikel = Artikel::findOrFail($id);

        // Hapus file gambar jika ada
        if ($artikel->gambar_sampul) {
            Storage::disk('public')->delete($artikel->gambar_sampul);
        }

        // Hapus record artikel dari database
        $artikel->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
