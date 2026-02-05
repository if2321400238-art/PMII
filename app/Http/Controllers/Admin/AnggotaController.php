<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\KTATemplate;
use App\Models\Korwil;
use App\Models\Rayon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::with('rayon', 'korwil');

        if (Auth::guard('korwil')->check()) {
            $query->where('korwil_id', Auth::guard('korwil')->id());
        }

        if (Auth::guard('rayon')->check()) {
            $query->where('rayon_id', Auth::guard('rayon')->id());
        }

        if (!Auth::guard('korwil')->check() && !Auth::guard('rayon')->check() && $request->has('korwil') && $request->korwil) {
            $query->where('korwil_id', $request->korwil);
        }

        if (!Auth::guard('rayon')->check() && $request->has('rayon') && $request->rayon) {
            $query->where('rayon_id', $request->rayon);
        }

        $anggota = $query->latest()->paginate(15);
        $korwils = Auth::guard('korwil')->check()
            ? Korwil::whereKey(Auth::guard('korwil')->id())->get()
            : Korwil::all();

        return view('admin.anggota.index', compact('anggota', 'korwils'));
    }

    public function create()
    {
        $korwilCurrent = Auth::guard('korwil')->check()
            ? Korwil::find(Auth::guard('korwil')->id())
            : null;

        $rayonCurrent = Auth::guard('rayon')->check()
            ? Rayon::with('korwil')->find(Auth::guard('rayon')->id())
            : null;

        $korwils = $korwilCurrent
            ? Korwil::whereKey($korwilCurrent->id)->get()
            : Korwil::all();

        $rayons = $korwilCurrent
            ? Rayon::where('korwil_id', $korwilCurrent->id)->orderBy('name')->get()
            : collect();

        $ktaTemplates = KTATemplate::all();

        return view('admin.anggota.create', compact('korwils', 'korwilCurrent', 'rayonCurrent', 'rayons', 'ktaTemplates'));
    }

    public function store(Request $request)
    {
        $korwilId = Auth::guard('korwil')->check() ? Auth::guard('korwil')->id() : null;
        $rayonId = Auth::guard('rayon')->check() ? Auth::guard('rayon')->id() : null;

        if ($korwilId) {
            $request->merge(['korwil_id' => $korwilId]);
        }

        if ($rayonId) {
            $request->merge(['rayon_id' => $rayonId]);
            $request->merge(['korwil_id' => Auth::guard('rayon')->user()->korwil_id]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_anggota' => 'required|unique:anggota|string',
            'alamat' => 'nullable|string',
            'pondok' => 'nullable|string|max:255',
            'korwil_id' => ['required', 'exists:korwils,id'],
            'rayon_id' => [
                'required',
                Rule::exists('rayons', 'id')->when($korwilId || $rayonId, function ($query) use ($korwilId, $rayonId) {
                    if ($rayonId) {
                        $query->where('id', $rayonId);
                    } elseif ($korwilId) {
                        $query->where('korwil_id', $korwilId);
                    }
                }),
            ],
            'foto' => 'nullable|image|max:2048',
            'kta_template_id' => 'nullable|exists:k_t_a_templates,id',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('anggota', 'public');
        }

        $anggota = Anggota::create($validated);

        // Generate KTA
        // TODO: Implement KTA generation

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function edit(Anggota $anggota)
    {
        $korwils = Korwil::all();
        $rayons = Rayon::where('korwil_id', $anggota->korwil_id)->get();
        $ktaTemplates = KTATemplate::all();

        return view('admin.anggota.edit', compact('anggota', 'korwils', 'rayons', 'ktaTemplates'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_anggota' => 'required|unique:anggota,nomor_anggota,' . $anggota->id . '|string',
            'alamat' => 'nullable|string',
            'pondok' => 'nullable|string|max:255',
            'korwil_id' => 'required|exists:korwils,id',
            'rayon_id' => 'required|exists:rayons,id',
            'foto' => 'nullable|image|max:2048',
            'kta_template_id' => 'nullable|exists:k_t_a_templates,id',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('anggota', 'public');
        }

        $anggota->update($validated);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil diperbarui');
    }

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus');
    }

    public function downloadKTA(Anggota $anggota)
    {
        try {
            // Gunakan default template atau template yang dipilih
            $template = $anggota->ktaTemplate ?? \App\Models\KTATemplate::where('is_active', true)->first();

            if (!$template) {
                return back()->with('error', 'KTA template tidak ditemukan. Silakan upload template terlebih dahulu.');
            }

            // Get path to template image (public disk)
            $templatePath = Storage::disk('public')->path($template->image_path);

            if (!file_exists($templatePath)) {
                return back()->with('error', 'File template KTA tidak ditemukan');
            }

            // Create image dari template
            $image = @imagecreatefrompng($templatePath) ?? @imagecreatefromjpeg($templatePath);

            if (!$image) {
                return back()->with('error', 'Gagal membaca template image. Format harus PNG atau JPEG.');
            }

            // Warna text (hitam)
            $textColor = imagecolorallocate($image, 0, 0, 0);
            $fontPath = base_path('public/fonts/arial.ttf');

            if (!file_exists($fontPath)) {
                return back()->with('error', 'Font file tidak ditemukan');
            }

            // Get field positions dari template (atau gunakan default)
            $positions = $template->field_positions ?? [
                'nama' => ['x' => 50, 'y' => 100, 'size' => 12],
                'nomor_anggota' => ['x' => 50, 'y' => 130, 'size' => 14],
                'rayon' => ['x' => 50, 'y' => 160, 'size' => 10],
                'korwil' => ['x' => 50, 'y' => 190, 'size' => 10],
                'foto' => ['x' => 200, 'y' => 50, 'width' => 60, 'height' => 80],
            ];

            // Add text fields
            if (isset($positions['nama']) && $anggota->nama) {
                $pos = $positions['nama'];
                imagettftext($image, $pos['size'], 0, $pos['x'], $pos['y'], $textColor, $fontPath, $anggota->nama);
            }

            if (isset($positions['nomor_anggota']) && $anggota->nomor_anggota) {
                $pos = $positions['nomor_anggota'];
                imagettftext($image, $pos['size'], 0, $pos['x'], $pos['y'], $textColor, $fontPath, 'No. ' . $anggota->nomor_anggota);
            }

            if (isset($positions['rayon']) && $anggota->rayon) {
                $pos = $positions['rayon'];
                imagettftext($image, $pos['size'], 0, $pos['x'], $pos['y'], $textColor, $fontPath, 'Rayon: ' . $anggota->rayon->nama);
            }

            if (isset($positions['korwil']) && $anggota->korwil) {
                $pos = $positions['korwil'];
                imagettftext($image, $pos['size'], 0, $pos['x'], $pos['y'], $textColor, $fontPath, 'Korwil: ' . $anggota->korwil->nama);
            }

            // Add photo jika ada
            if (isset($positions['foto']) && $anggota->foto && file_exists(public_path($anggota->foto))) {
                $pos = $positions['foto'];
                $photoImage = @imagecreatefromjpeg(public_path($anggota->foto)) ?? @imagecreatefrompng(public_path($anggota->foto));

                if ($photoImage) {
                    imagecopyresampled(
                        $image, $photoImage,
                        $pos['x'], $pos['y'],
                        0, 0,
                        $pos['width'], $pos['height'],
                        imagesx($photoImage), imagesy($photoImage)
                    );
                    imagedestroy($photoImage);
                }
            }

            // Save to temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'kta_');
            imagepng($image, $tempFile);
            imagedestroy($image);

            if (!file_exists($tempFile)) {
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
                'anggota_id' => $anggota->id
            ]);
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
