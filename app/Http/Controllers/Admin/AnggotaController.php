<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Rayon;
use App\Services\KTAGeneratorService;
use App\Services\MediaCompressionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function __construct(private readonly MediaCompressionService $mediaCompressionService)
    {
    }

    public function index(Request $request)
    {
        $query = Anggota::with('rayon');

        if (Auth::guard('rayon')->check()) {
            $query->where('rayon_id', Auth::guard('rayon')->id());
        }

        if (!Auth::guard('rayon')->check() && $request->has('rayon') && $request->rayon) {
            $query->where('rayon_id', $request->rayon);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($builder) use ($search) {
                $builder->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nomor_anggota', 'like', '%' . $search . '%');
            });
        }

        $anggota = $query->latest()->paginate(15);

        return view('admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        $rayonCurrent = Auth::guard('rayon')->check()
            ? Rayon::find(Auth::guard('rayon')->id())
            : null;

        $rayons = $rayonCurrent
            ? collect([$rayonCurrent])
            : Rayon::orderBy('name')->get();

        return view('admin.anggota.create', compact('rayonCurrent', 'rayons'));
    }

    public function store(Request $request)
    {
        $rayonId = Auth::guard('rayon')->check() ? Auth::guard('rayon')->id() : null;

        if ($rayonId) {
            $request->merge(['rayon_id' => $rayonId]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_anggota' => 'required|unique:anggota|string',
            'alamat' => 'nullable|string',
            'pondok' => 'nullable|string|max:255',
            'rayon_id' => 'required|exists:rayons,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->mediaCompressionService->storeCompressedImage(
                $request->file('foto'),
                'anggota'
            );
        }

        $anggota = Anggota::create($validated);

        // Generate KTA
        // TODO: Implement KTA generation

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function edit(Anggota $anggota)
    {
        if (Auth::guard('rayon')->check() && $anggota->rayon_id !== Auth::guard('rayon')->id()) {
            abort(403, 'Unauthorized access');
        }

        $rayonCurrent = Auth::guard('rayon')->check()
            ? Rayon::find(Auth::guard('rayon')->id())
            : null;

        $rayons = $rayonCurrent
            ? collect([$rayonCurrent])
            : Rayon::orderBy('name')->get();
        return view('admin.anggota.edit', compact('anggota', 'rayonCurrent', 'rayons'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        if (Auth::guard('rayon')->check() && $anggota->rayon_id !== Auth::guard('rayon')->id()) {
            abort(403, 'Unauthorized access');
        }

        $rayonId = Auth::guard('rayon')->check() ? Auth::guard('rayon')->id() : null;

        if ($rayonId) {
            $request->merge(['rayon_id' => $rayonId]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_anggota' => 'required|unique:anggota,nomor_anggota,' . $anggota->id . '|string',
            'alamat' => 'nullable|string',
            'pondok' => 'nullable|string|max:255',
            'rayon_id' => 'required|exists:rayons,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->mediaCompressionService->storeCompressedImage(
                $request->file('foto'),
                'anggota'
            );
        }

        $anggota->update($validated);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil diperbarui');
    }

    public function destroy(Anggota $anggota)
    {
        if (Auth::guard('rayon')->check() && $anggota->rayon_id !== Auth::guard('rayon')->id()) {
            abort(403, 'Unauthorized access');
        }

        $anggota->delete();
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus');
    }

    public function downloadKTA(Anggota $anggota, KTAGeneratorService $ktaGenerator)
    {
        if (Auth::guard('rayon')->check() && $anggota->rayon_id !== Auth::guard('rayon')->id()) {
            abort(403, 'Unauthorized access');
        }

        try {
            // Load relationships
            $anggota->load(['rayon']);

            // Generate KTA using the service
            $tempFile = $ktaGenerator->generate($anggota);

            if (!$tempFile || !file_exists($tempFile)) {
                return back()->with('error', 'Gagal generate KTA');
            }

            // Return as download
            $filename = 'KTA_' . $anggota->nomor_anggota . '.png';
            $response = response()->file($tempFile, ['Content-Disposition' => 'attachment; filename="' . $filename . '"']);

            // Clean up after send
            register_shutdown_function(function() use ($tempFile) {
                if (file_exists($tempFile)) {
                    unlink($tempFile);
                }
            });

            return $response;

        } catch (\Exception $e) {
            \Log::error('KTA Download Error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine(), [
                'anggota_id' => $anggota->id,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
