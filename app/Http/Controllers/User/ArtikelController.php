<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->string('search')->toString());

        $artikel = Artikel::with('penulis')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('judul_artikel', 'like', '%' . $search . '%')
                        ->orWhere('isi_konten', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('tanggal_rilis')
            ->get()
            ->each(function (Artikel $article) {
                $article->reading_time = max(1, (int) ceil(str_word_count(strip_tags($article->isi_konten ?? '')) / 180));
                $article->excerpt = Str::limit(strip_tags($article->isi_konten ?? ''), 160);
            });

        return view('user.artikel.index', compact('artikel'));
    }


    public function show(string $id)
    {
        $artikel = Artikel::with('penulis')
            ->where('id', $id)
            ->findOrFail($id);

        $plainContent = trim(preg_replace('/\R+/', "\n", strip_tags($artikel->isi_konten ?? '')));
        $artikel->reading_time = max(1, (int) ceil(str_word_count(strip_tags($artikel->isi_konten ?? '')) / 180));
        $artikel->context_excerpt = Str::limit($plainContent, 220);

        $paragraphs = collect(preg_split('/\n\s*\n|\n/', $plainContent))
            ->map(fn ($paragraph) => trim($paragraph))
            ->filter();

        $artikel->context_points = $paragraphs
            ->filter(fn ($paragraph) => Str::length($paragraph) >= 40)
            ->take(3)
            ->values();

        $headings = collect();
        preg_match_all('/^\s*(.+)$/m', strip_tags($artikel->isi_konten ?? ''), $matches);
        if (! empty($matches[1])) {
            $headings = collect($matches[1])
                ->map(fn ($line) => trim($line))
                ->filter(fn ($line) => Str::length($line) >= 18)
                ->unique()
                ->take(6)
                ->values();
        }

        return view('user.artikel.show', [
            'artikel' => $artikel,
            'headings' => $headings,
        ]);
    }


}
