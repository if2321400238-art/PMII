<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SKPengajuan;
use App\Models\Korwil;
use App\Models\Rayon;
use Illuminate\Http\Request;

class SKPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = SKPengajuan::with('submittedBy', 'approvedBy', 'korwil', 'rayon');

        // Filter berdasarkan role user
        $userRole = auth()->user()->role?->slug;

        if ($userRole === 'bph_korwil') {
            // BPH Korwil hanya lihat SK korwil yang dia submit
            $query->where('submitted_by', auth()->id());
        } elseif ($userRole === 'bph_rayon') {
            // BPH Rayon hanya lihat SK rayon yang dia submit
            $query->where('submitted_by', auth()->id());
        }
        // BPH PB bisa lihat semua

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('tipe') && $request->tipe) {
            $query->where('tipe', $request->tipe);
        }

        $pengajuan = $query->latest()->paginate(15);

        return view('admin.sk-pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        $user = auth()->user();
        $userRole = $user->role?->slug;

        // Ambil data korwil/rayon dari user yang login
        $korwil = $user->korwil;
        $rayon = $user->rayon;

        return view('admin.sk-pengajuan.create', compact('korwil', 'rayon', 'userRole'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $userRole = $user->role?->slug;

        // Tentukan tipe dan ID berdasarkan user
        if ($userRole === 'bph_korwil') {
            $tipe = 'korwil';
            $korwilId = $user->korwil_id;
            $rayonId = null;
        } elseif ($userRole === 'bph_rayon') {
            $tipe = 'rayon';
            $korwilId = null;
            $rayonId = $user->rayon_id;
        } else {
            return back()->withErrors(['error' => 'Anda tidak memiliki akses untuk mengajukan SK']);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dokumen' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('sk-pengajuan', 'public');
        }

        $validated['tipe'] = $tipe;
        $validated['korwil_id'] = $korwilId;
        $validated['rayon_id'] = $rayonId;
        $validated['submitted_by'] = auth()->id();
        $validated['status'] = 'pending';

        SKPengajuan::create($validated);

        return redirect()->route('admin.sk-pengajuan.index')->with('success', 'Pengajuan SK berhasil dikirim');
    }

    public function show(SKPengajuan $pengajuan)
    {
        return view('admin.sk-pengajuan.show', compact('pengajuan'));
    }

    public function approve(Request $request, SKPengajuan $pengajuan)
    {
        $pengajuan->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Update nomor SK ke korwil/rayon
        if ($pengajuan->tipe === 'korwil') {
            $pengajuan->korwil->update([
                'nomor_sk' => $pengajuan->nama,
                'tanggal_sk' => now()->toDateString(),
            ]);
        } else {
            $pengajuan->rayon->update([
                'nomor_sk' => $pengajuan->nama,
                'tanggal_sk' => now()->toDateString(),
            ]);
        }

        return redirect()->back()->with('success', 'SK berhasil disetujui');
    }

    public function revise(Request $request, SKPengajuan $pengajuan)
    {
        $validated = $request->validate([
            'catatan_revisi' => 'required|string',
        ]);

        $pengajuan->update([
            'status' => 'revised',
            'catatan_revisi' => $validated['catatan_revisi'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Revisi berhasil dikirim');
    }

    public function reject(Request $request, SKPengajuan $pengajuan)
    {
        $validated = $request->validate([
            'catatan_revisi' => 'required|string',
        ]);

        $pengajuan->update([
            'status' => 'rejected',
            'catatan_revisi' => $validated['catatan_revisi'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan ditolak');
    }
}
