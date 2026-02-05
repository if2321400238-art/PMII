<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SKPengajuan;
use App\Models\Korwil;
use App\Models\Rayon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SKPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = SKPengajuan::with('korwil', 'rayon', 'approvedBy');
        $userRole = $this->currentRole();

        // Korwil hanya lihat pengajuan SKnya sendiri
        if ($userRole === 'korwil_admin') {
            $korwilId = Auth::guard('korwil')->id();
            $query->where('korwil_id', $korwilId);
        }
        // Rayon hanya lihat pengajuan SKnya sendiri
        elseif ($userRole === 'rayon_admin') {
            $rayonId = Auth::guard('rayon')->id();
            $query->where('rayon_id', $rayonId);
        }
        // Admin/PB bisa lihat semua

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
        $userRole = $this->currentRole();

        // Ambil data korwil/rayon dari guard aktif
        if (Auth::guard('korwil')->check()) {
            $korwil = Auth::guard('korwil')->user();
            $rayon = null;
        } elseif (Auth::guard('rayon')->check()) {
            $korwil = null;
            $rayon = Auth::guard('rayon')->user();
        } else {
            return redirect()->route('admin.sk-pengajuan.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengajukan SK');
        }

        return view('admin.sk-pengajuan.create', compact('korwil', 'rayon', 'userRole'));
    }

    public function store(Request $request)
    {
        $userRole = $this->currentRole();

        // Tentukan tipe dan ID berdasarkan guard yang aktif
        if ($userRole === 'korwil_admin') {
            $tipe = 'korwil';
            $korwilId = Auth::guard('korwil')->id();
            $rayonId = null;
        } elseif ($userRole === 'rayon_admin') {
            $tipe = 'rayon';
            $korwilId = null;
            $rayonId = Auth::guard('rayon')->id();
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

    private function currentRole(): ?string
    {
        if (Auth::guard('web')->check()) {
            $role = Auth::guard('web')->user()->role;
            return $role === 'pb' ? 'admin' : $role;
        }

        if (Auth::guard('korwil')->check()) {
            return 'korwil_admin';
        }

        if (Auth::guard('rayon')->check()) {
            return 'rayon_admin';
        }

        return null;
    }
}
