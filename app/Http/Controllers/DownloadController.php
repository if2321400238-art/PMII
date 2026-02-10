<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::latest()->paginate(15);
        $kategoris = Download::distinct()->pluck('kategori');

        return view('frontend.download', compact('downloads', 'kategoris'));
    }

    public function download(Download $download)
    {
        // Use public disk to match storage:link path
        if (!Storage::disk('public')->exists($download->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan. Silakan hubungi administrator.');
        }

        $download->incrementDownloadCount();

        // Extract extension from file_path and append to nama_file
        $extension = pathinfo($download->file_path, PATHINFO_EXTENSION);
        // Remove any path separators from nama_file to prevent security issues
        $basename = pathinfo($download->nama_file, PATHINFO_BASENAME);
        $filename = $basename . '.' . $extension;

        return Storage::disk('public')->download($download->file_path, $filename);
    }
}
