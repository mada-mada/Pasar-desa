<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\PasarDesa;
use App\Models\Fasilitas;
use App\Models\LokasiGis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class PasarController extends Controller
{
    
    public function index()
    {

        $pasar = PasarDesa::orderBy('nama_pasar')
                          ->get();

     
        return view('admin.pasar.index', compact('pasar'));
    }

  
    public function create()
    {
        $pasarExisting = PasarDesa::whereHas('lokasiGis')
                                  ->with('lokasiGis')
                                  ->get();
        return view('admin.pasar.create', compact('pasarExisting'));
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

            // Validasi Array Fasilitas
            'nama_fasilitas' => 'required|array|min:1', // Harus berupa array, minimal 1
            'nama_fasilitas.*' => 'required|string|max:100', // Setiap isi array harus string
            
            'status_ketersediaan' => 'required|array|min:1',
            'status_ketersediaan.*' => 'required|in:Tersedia,Tidak Ada,Rusak', // Sesuaikan enum
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_pasar')) {
            $fotoPath = $request->file('foto_pasar')->store('pasar', 'public');
            $validated['foto_pasar'] = $fotoPath;
        }

        // 2. Mulai Transaksi Database
        DB::beginTransaction();

        try {
            // A. Simpan data Pasar Desa
            $pasar = PasarDesa::create([
                'nama_pasar' => $validated['nama_pasar'],
                'alamat_lengkap' => $validated['alamat_lengkap'],
                'deskripsi' => $validated['deskripsi'],
                'hari_pasaran' => $validated['hari_pasaran'],
                'jam_operasional' => $validated['jam_operasional'],
                'foto_pasar' => $fotoPath,
            ]);

            // B. Simpan data Koordinat Map
            LokasiGis::create([
                'id_pasar' => $pasar->id, 
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            // C. Simpan Multi-Data Fasilitas menggunakan Looping
            // Karena nama_fasilitas dan status_ketersediaan adalah array dengan jumlah index yang sama
            foreach ($request->nama_fasilitas as $index => $nama) {
                Fasilitas::create([
                    'id_pasar' => $pasar->id,
                    'nama_fasilitas' => $nama,
                    // Ambil status pada index/urutan yang sama dengan nama fasilitasnya
                    'status_ketersediaan' => $request->status_ketersediaan[$index], 
                ]);
            }

            // Jika semua lancar, simpan permanen
            DB::commit();

            return redirect()->route('admin.pasar.index')
                             ->with('success', 'Pasar, Lokasi Peta, dan Semua Fasilitas berhasil disimpan!');

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
        
        $pasar = PasarDesa::with(['fasilitas', 'lokasiGis'])
                         ->findOrFail($id);

      
        return view('admin.pasar.show', compact('pasar'));
    }

    
    public function edit(string $id)
    {
        
        $pasar = PasarDesa::findOrFail($id);

        
        return view('admin.pasar.edit', compact('pasar'));
    }

  
    public function update(Request $request, string $id)
    {
        $pasar = PasarDesa::findOrFail($id);

        // 1. Tambahkan validasi untuk latitude dan longitude
        $validated = $request->validate([
            'nama_pasar' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'deskripsi' => 'required|string',
            'hari_pasaran' => 'required|string|max:50',
            'jam_operasional' => 'required|string|max:50',
            'foto_pasar' => 'nullable|image|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // 2. Siapkan variabel untuk foto baru
        $fotoBaruPath = null;
        if ($request->hasFile('foto_pasar')) {
            $fotoBaruPath = $request->file('foto_pasar')->store('pasar', 'public');
            $validated['foto_pasar'] = $fotoBaruPath;
        }

        // 3. Mulai Transaksi
        DB::beginTransaction();

        try {
            // A. Update Profil Pasar (hanya data pasar)
            $pasarData = collect($validated)->except(['latitude', 'longitude'])->toArray();
            $pasar->update($pasarData);

            // B. Update atau Create Lokasi GIS
            // Sesuaikan 'id_pasar' dengan foreign key di database Anda
            LokasiGis::updateOrCreate(
                ['id_pasar' => $pasar->id], // Cari berdasarkan ID Pasar
                [
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude']
                ] // Data yang diupdate/dibuat
            );

            // Jika semua database berhasil terupdate, hapus foto lama dari storage
            if ($fotoBaruPath && $pasar->getOriginal('foto_pasar')) {
                Storage::disk('public')->delete($pasar->getOriginal('foto_pasar'));
            }

            DB::commit();

            return redirect()->route('admin.pasar.show', $pasar->id)
                             ->with('success', 'Pasar dan lokasi berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();

            // Jika update gagal tapi admin telanjur upload foto baru, hapus foto baru tersebut
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
        
        // Simpan path foto untuk dihapus nanti jika transaksi berhasil
        $fotoPath = $pasar->foto_pasar; 

        DB::beginTransaction();

        try {
            // A. Hapus data lokasi GIS terlebih dahulu agar tidak terjadi error Foreign Key
            // Sesuaikan 'pasar_desa_id' dengan nama kolom di tabel lokasi_gis
            LokasiGis::where('pasar_desa_id', $pasar->id)->delete();

            // B. Hapus profil pasar
            $pasar->delete();

            DB::commit();

            // C. Hapus foto fisik dari server HANYA JIKA proses database di atas berhasil
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return redirect()->route('admin.pasar.index')
                             ->with('success', 'Pasar beserta lokasinya berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus pasar: ' . $e->getMessage());
        }
    }
}
