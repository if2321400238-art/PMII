<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Korwil;
use Illuminate\Http\Request;

class KorwilController extends Controller
{
    public function index()
    {
        $korwils = Korwil::with('rayons')->latest()->paginate(15);
        return view('admin.korwil.index', compact('korwils'));
    }

    public function create()
    {
        return view('admin.korwil.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'wilayah' => 'required|string|max:255',
            'email' => 'required|email|unique:korwils,email',
            'password' => 'required|min:8',
            'description' => 'nullable|string',
            'contact' => 'nullable|string',
        ]);

        Korwil::create($validated);

        return redirect()->route('admin.korwil.index')->with('success', 'Korwil berhasil ditambahkan');
    }

    public function edit(Korwil $korwil)
    {
        return view('admin.korwil.edit', compact('korwil'));
    }

    public function update(Request $request, Korwil $korwil)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'wilayah' => 'required|string|max:255',
            'email' => 'required|email|unique:korwils,email,' . $korwil->id,
            'password' => 'nullable|min:8',
            'description' => 'nullable|string',
            'contact' => 'nullable|string',
        ]);

        // Remove password from validated if not provided
        if (!$request->filled('password')) {
            unset($validated['password']);
        }

        $korwil->update($validated);

        return redirect()->route('admin.korwil.index')->with('success', 'Korwil berhasil diperbarui');
    }

    public function destroy(Korwil $korwil)
    {
        $korwil->delete();
        return redirect()->route('admin.korwil.index')->with('success', 'Korwil berhasil dihapus');
    }
}
