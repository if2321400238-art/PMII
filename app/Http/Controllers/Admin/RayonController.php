<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rayon;
use App\Models\Korwil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RayonController extends Controller
{
    public function index(Request $request)
    {
        $query = Rayon::with('korwil');

        $korwilId = $this->currentKorwilId();
        if ($korwilId) {
            $query->where('korwil_id', $korwilId);
        }

        if (!$korwilId && $request->has('korwil') && $request->korwil) {
            $query->where('korwil_id', $request->korwil);
        }

        $rayons = $query->latest()->paginate(15);
        $korwils = $korwilId ? Korwil::whereKey($korwilId)->get() : Korwil::all();

        return view('admin.rayon.index', compact('rayons', 'korwils'));
    }

    public function create()
    {
        $korwilId = $this->currentKorwilId();
        $korwils = $korwilId ? Korwil::whereKey($korwilId)->get() : Korwil::all();
        return view('admin.rayon.create', compact('korwils'));
    }

    public function store(Request $request)
    {
        $korwilId = $this->currentKorwilId();
        if ($korwilId) {
            $request->merge(['korwil_id' => $korwilId]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'korwil_id' => 'required|exists:korwils,id',
            'email' => 'required|email|unique:rayons,email',
            'password' => 'required|min:8',
            'nomor_sk' => 'nullable|string',
            'tanggal_sk' => 'nullable|date',
            'description' => 'nullable|string',
            'contact' => 'nullable|string',
        ]);

        Rayon::create($validated);

        return redirect()->route('admin.rayon.index')->with('success', 'Rayon berhasil ditambahkan');
    }

    public function edit(Rayon $rayon)
    {
        $korwilId = $this->currentKorwilId();
        if ($korwilId && $rayon->korwil_id !== $korwilId) {
            abort(403);
        }

        $korwils = $korwilId ? Korwil::whereKey($korwilId)->get() : Korwil::all();
        return view('admin.rayon.edit', compact('rayon', 'korwils'));
    }

    public function update(Request $request, Rayon $rayon)
    {
        $korwilId = $this->currentKorwilId();
        if ($korwilId && $rayon->korwil_id !== $korwilId) {
            abort(403);
        }

        if ($korwilId) {
            $request->merge(['korwil_id' => $korwilId]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'korwil_id' => 'required|exists:korwils,id',
            'email' => 'required|email|unique:rayons,email,' . $rayon->id,
            'password' => 'nullable|min:8',
            'nomor_sk' => 'nullable|string',
            'tanggal_sk' => 'nullable|date',
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
        $korwilId = $this->currentKorwilId();
        if ($korwilId && $rayon->korwil_id !== $korwilId) {
            abort(403);
        }

        $rayon->delete();
        return redirect()->route('admin.rayon.index')->with('success', 'Rayon berhasil dihapus');
    }

    private function currentKorwilId(): ?int
    {
        if (Auth::guard('korwil')->check()) {
            return Auth::guard('korwil')->id();
        }

        return null;
    }

    /**
     * API sederhana untuk dropdown rayon berdasarkan korwil.
     */
    public function listByKorwil($korwilId)
    {
        $rayons = Rayon::where('korwil_id', $korwilId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($rayons);
    }
}
