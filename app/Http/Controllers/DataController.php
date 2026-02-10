<?php

namespace App\Http\Controllers;

use App\Models\Rayon;

class DataController extends Controller
{
    public function index()
    {
        $rayonCount = Rayon::count();

        return view('frontend.data', compact('rayonCount'));
    }
}
