<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::approved();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('kegiatan') && $request->kegiatan) {
            $query->where('kegiatan', $request->kegiatan);
        }

        if ($request->has('tahun') && $request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        $galleries = $query->latest()->paginate(12);
        $kegiatan = Gallery::approved()->distinct()->pluck('kegiatan')->filter();
        $tahun = Gallery::approved()->distinct()->pluck('tahun')->filter()->sort();

        return view('frontend.galeri', compact('galleries', 'kegiatan', 'tahun'));
    }

    public function show(Gallery $gallery)
    {
        if ($gallery->approval_status !== 'approved') {
            abort(404);
        }

        $related = Gallery::approved()
            ->where('kegiatan', $gallery->kegiatan)
            ->where('id', '!=', $gallery->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.gallery.show', compact('gallery', 'related'));
    }
}
