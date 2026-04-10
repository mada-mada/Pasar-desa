<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasarDesa;
use App\Models\Fasilitas;
use App\Models\LokasiGis;
use App\Models\JenisFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PasarController extends Controller
{
    public function index()
    {
        // Menambahkan eager loading untuk mencegah N+1 Query Problem
        $pasar = PasarDesa::with(['lokasiGis', 'fasilitas'])->orderBy('nama_pasar')->get();
        return view('admin.pasar.index', compact('pasar'));
    }

    public function create()
    {
        $pasarExisting = PasarDesa::whereHas('lokasiGis')->with('lokasiGis')->get();
        $jenisFasilitas = JenisFasilitas::all();
                                          
        return view('admin.pasar.create', compact('pasarExisting', 'jenisFasilitas')); 
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'nama_pasar' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'deskripsi' => 'required|string',
            'hari_pasaran' => 'required|string|max:50',
            'jam_operasional' => 'required|string|max:50',
            'foto_pasar' => 'nullable|image|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'id_jenis_fasilitas' => 'required|array|min:1', 
            'id_jenis_fasilitas.*' => 'required|exists:jenis_fasilitas,id', 
            'status_ketersediaan' => 'required|array|min:1',
            'status_ketersediaan.*' => 'required|in:Tersedia,Tidak Ada,Rusak',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_pasar')) {
            $fotoPath = $request->file('foto_pasar')->store('pasar', 'public');
            $validated['foto_pasar'] = $fotoPath;
        }

        DB::beginTransaction();

        try {
            // A. Simpan data Pasar Desa
            $pasarData = collect($validated)->except(['latitude', 'longitude', 'id_jenis_fasilitas', 'status_ketersediaan'])->toArray();
            $pasar = PasarDesa::create($pasarData);

            // B. Simpan data Koordinat Map
            LokasiGis::create([
                'id_pasar' => $pasar->id, 
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            // C. Simpan Fasilitas
            foreach ($request->id_jenis_fasilitas as $index => $id_jenis) {
                Fasilitas::create([
                    'id_pasar' => $pasar->id,
                    'id_jenis_fasilitas' => $id_jenis,
                    'status_ketersediaan' => $request->status_ketersediaan[$index], 
                ]);
            }

            DB::commit();

            return redirect()->route('admin.pasar.index')
                             ->with('success', 'Pasar, Lokasi Peta, dan Fasilitas berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return back()->withInput()
                         ->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $pasar = PasarDesa::with(['fasilitas.jenisFasilitas', 'lokasiGis'])->findOrFail($id);
        return view('admin.pasar.show', compact('pasar'));
    }

    public function edit(string $id)
    {
        $pasar = PasarDesa::with(['lokasiGis', 'fasilitas'])->findOrFail($id);
        
        // Perlu memanggil JenisFasilitas agar bisa ditampilkan di form edit
        $jenisFasilitas = JenisFasilitas::all();
        
        // (Opsional) Jika form edit juga butuh menampilkan map marker pasar lain
        $pasarExisting = PasarDesa::whereHas('lokasiGis')->with('lokasiGis')->where('id', '!=', $id)->get();

        return view('admin.pasar.edit', compact('pasar', 'jenisFasilitas', 'pasarExisting'));
    }

    public function update(Request $request, string $id)
    {
        $pasar = PasarDesa::findOrFail($id);

        $validated = $request->validate([
            'nama_pasar' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'deskripsi' => 'required|string',
            'hari_pasaran' => 'required|string|max:50',
            'jam_operasional' => 'required|string|max:50',
            'foto_pasar' => 'nullable|image|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'id_jenis_fasilitas' => 'required|array|min:1', 
            'id_jenis_fasilitas.*' => 'required|exists:jenis_fasilitas,id',
            'status_ketersediaan' => 'required|array|min:1',
            'status_ketersediaan.*' => 'required|in:Tersedia,Tidak Ada,Rusak',
        ]);

        $fotoBaruPath = null;
        if ($request->hasFile('foto_pasar')) {
            $fotoBaruPath = $request->file('foto_pasar')->store('pasar', 'public');
            $validated['foto_pasar'] = $fotoBaruPath;
        }

        DB::beginTransaction();

        try {
            // A. Update Profil Pasar (kecuali relasi)
            $pasarData = collect($validated)->except(['latitude', 'longitude', 'id_jenis_fasilitas', 'status_ketersediaan'])->toArray();
            $pasar->update($pasarData);

            // B. Update Lokasi GIS
            LokasiGis::updateOrCreate(
                ['id_pasar' => $pasar->id],
                [
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude']
                ]
            );

            // C. Update Fasilitas (Hapus yang lama, insert yang baru dari form)
            Fasilitas::where('id_pasar', $pasar->id)->delete();
            
            foreach ($request->id_jenis_fasilitas as $index => $id_jenis) {
                Fasilitas::create([
                    'id_pasar' => $pasar->id,
                    'id_jenis_fasilitas' => $id_jenis,
                    'status_ketersediaan' => $request->status_ketersediaan[$index],
                ]);
            }

            // Jika berhasil dan ada foto baru, hapus foto lama dari storage
            if ($fotoBaruPath && $pasar->getOriginal('foto_pasar')) {
                Storage::disk('public')->delete($pasar->getOriginal('foto_pasar'));
            }

            DB::commit();

            return redirect()->route('admin.pasar.show', $pasar->id)
                             ->with('success', 'Pasar, Fasilitas, dan lokasi berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($fotoBaruPath && Storage::disk('public')->exists($fotoBaruPath)) {
                Storage::disk('public')->delete($fotoBaruPath);
            }

            return back()->withInput()
                         ->with('error', 'Terjadi kesalahan saat mengupdate: ' . $e->getMessage());
        }
    }

   public function destroy(string $id)
    {
        $pasar = PasarDesa::findOrFail($id);
        $fotoPath = $pasar->foto_pasar; 

        DB::beginTransaction();

        try {
            // A. Hapus Fasilitas terlebih dahulu (hindari error Foreign Key)
            Fasilitas::where('id_pasar', $pasar->id)->delete();

            // B. Hapus Lokasi GIS (Disamakan menggunakan id_pasar)
            LokasiGis::where('id_pasar', $pasar->id)->delete();

            // C. Hapus profil pasar
            $pasar->delete();

            DB::commit();

            // Hapus foto fisik dari server HANYA JIKA transaksi DB berhasil
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return redirect()->route('admin.pasar.index')
                             ->with('success', 'Pasar, Fasilitas, beserta lokasinya berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus pasar: ' . $e->getMessage());
        }
    }
}