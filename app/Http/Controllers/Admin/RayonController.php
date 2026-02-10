<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rayon;
use Illuminate\Http\Request;

class RayonController extends Controller
{
    public function index(Request $request)
    {
        $rayons = Rayon::latest()->paginate(15);

        return view('admin.rayon.index', compact('rayons'));
    }

    public function create()
    {
        return view('admin.rayon.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:rayons,email',
            'password' => 'required|min:8',
            'description' => 'nullable|string',
            'contact' => 'nullable|string',
        ]);

        Rayon::create($validated);

        return redirect()->route('admin.rayon.index')->with('success', 'Rayon berhasil ditambahkan');
    }

    public function edit(Rayon $rayon)
    {
        return view('admin.rayon.edit', compact('rayon'));
    }

    public function update(Request $request, Rayon $rayon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:rayons,email,' . $rayon->id,
            'password' => 'nullable|min:8',
            'description' => 'nullable|string',
            'contact' => 'nullable|string',
        ]);

        // Remove password from validated if not provided
        if (!$request->filled('password')) {
            unset($validated['password']);
        }

        $rayon->update($validated);

        return redirect()->route('admin.rayon.index')->with('success', 'Rayon berhasil diperbarui');
    }

    public function destroy(Rayon $rayon)
    {
        $rayon->delete();
        return redirect()->route('admin.rayon.index')->with('success', 'Rayon berhasil dihapus');
    }
}
