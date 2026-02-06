<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\AuthHelper;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('uploadedBy', 'approvedBy');

        // Get current user from any guard
        $currentUser = AuthHelper::user();
        $userType = AuthHelper::userType();

        // Filter: non-admin hanya lihat galeri sendiri
        if ($userType !== 'user' || $currentUser->role !== 'admin') {
            $query->where('uploaded_by', $currentUser->id)
                  ->where('uploader_type', get_class($currentUser));
        }

        if ($request->has('approval_status') && $request->approval_status) {
            $query->where('approval_status', $request->approval_status);
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        $galleries = $query->latest()->paginate(15);

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:photo,video',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:50000',
            'embed_url' => 'nullable|url',
            'kegiatan' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);

        if ($validated['type'] === 'photo' && $request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('galleries/photos', 'public');
        } elseif ($validated['type'] === 'video' && $request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('galleries/videos', 'public');
        }

        // Set uploader dengan polymorphic relation
        $currentUser = AuthHelper::user();
        $validated['uploaded_by'] = $currentUser->id;
        $validated['uploader_type'] = get_class($currentUser);

        // Set approval status: admin langsung approved, lainnya pending
        $userType = AuthHelper::userType();
        $isAdmin = $userType === 'user' && $currentUser->role === 'admin';

        if ($isAdmin) {
            $validated['approval_status'] = 'approved';
            $validated['approved_by'] = $currentUser->id;
            $validated['approved_at'] = now();
        } else {
            $validated['approval_status'] = 'pending';
        }

        Gallery::create($validated);

        $message = $validated['approval_status'] === 'pending'
            ? 'Galeri berhasil dibuat dan menunggu persetujuan admin/PB'
            : 'Galeri berhasil dibuat';

        return redirect()->route('admin.gallery.index')->with('success', $message);
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'type' => 'required|in:photo,video',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:50000',
            'embed_url' => 'nullable|url',
            'kegiatan' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('galleries/' . $validated['type'] . 's', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil dihapus');
    }

    public function approve(Gallery $gallery)
    {
        $gallery->update([
            'approval_status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Galeri berhasil disetujui');
    }

    public function reject(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $gallery->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->back()->with('success', 'Galeri berhasil ditolak');
    }
}
