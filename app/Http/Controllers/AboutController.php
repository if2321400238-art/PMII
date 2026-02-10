<?php

namespace App\Http\Controllers;

use App\Models\ProfilOrganisasi;
use App\Models\Rayon;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function profil()
    {
        $profil = ProfilOrganisasi::first();
        return view('frontend.tentang-kami.profil', compact('profil'));
    }

    public function rayon(Request $request)
    {
        $rayons = Rayon::when($request->filled('q'), function ($query) use ($request) {
                $search = $request->q;
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('frontend.tentang-kami.rayon', compact('rayons'));
    }
}
