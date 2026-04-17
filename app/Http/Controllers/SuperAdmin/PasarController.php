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
        return view('superadmin.pasar.index', compact('pasar'));
    }

    public function show($id)
    {
        return redirect()->route('pasar.show', $id);
    }

    public function destroy($id)
    {
        $pasar = PasarDesa::findOrFail($id);
        $pasar->delete();

        return redirect()->route('superadmin.pasar.index')->with('success', 'Berhasil menghapus data pasar');
    }
}