<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $ulasans = Ulasan::with('ulasanable')
            ->when($status === 'pending', function ($query) {
                return $query->where('is_approved', false);
            })
            ->when($status === 'approved', function ($query) {
                return $query->where('is_approved', true);
            })
            ->latest()
            ->paginate(15);

        return view('admin.ulasan.index', compact('ulasans', 'status'));
    }

    public function approve(Ulasan $ulasan)
    {
        $ulasan->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Ulasan berhasil disetujui dan dipublikasikan.');
    }

    public function destroy(Ulasan $ulasan)
    {
        $ulasan->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
