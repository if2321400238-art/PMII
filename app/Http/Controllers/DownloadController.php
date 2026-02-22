<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::latest()->paginate(15);
        $fileAvailability = $this->buildFileAvailabilityMap($downloads);
        $kategoris = Download::distinct()->pluck('kategori');

        return view('frontend.download', compact('downloads', 'kategoris', 'fileAvailability'));
    }

    private function buildFileAvailabilityMap(LengthAwarePaginator $downloads): array
    {
        $availability = [];

        foreach ($downloads->items() as $download) {
            $availability[$download->id] = Storage::disk('public')->exists($download->file_path);
        }

        return $availability;
    }

    public function show(Download $download)
    {
        if (!$download->fileExists()) {
            return redirect()->route('download.index')->with('error', 'File tidak ditemukan.');
        }

        $extension = pathinfo($download->file_path, PATHINFO_EXTENSION);
        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
        $isPdf = strtolower($extension) === 'pdf';

        return view('frontend.download-show', compact('download', 'extension', 'isImage', 'isPdf'));
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
