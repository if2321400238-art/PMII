<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilOrganisasi;
use App\Services\MediaCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilOrganisasiController extends Controller
{
    public function __construct(private readonly MediaCompressionService $mediaCompressionService)
    {
    }

    public function edit()
    {
        $profil = ProfilOrganisasi::first();

        if (!$profil) {
            $profil = ProfilOrganisasi::create([
                'nama_organisasi' => 'PMII',
            ]);
        }

        return view('admin.profil-organisasi.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'hero_image_2' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'hero_image_3' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'struktur_organisasi' => 'nullable|string',
        ]);

        $profil = ProfilOrganisasi::first();

        if (!$profil) {
            $profil = new ProfilOrganisasi();
        }

        $profil->nama_organisasi = $request->nama_organisasi;
        $profil->sejarah = $request->sejarah;
        $profil->visi = $request->visi;
        $profil->misi = $request->misi;
        $profil->struktur_organisasi = $request->struktur_organisasi;

        // Handle logo upload
        if ($request->hasFile('logo_path')) {
            if ($profil->logo_path && Storage::disk('public')->exists($profil->logo_path)) {
                Storage::disk('public')->delete($profil->logo_path);
            }
            $profil->logo_path = $this->mediaCompressionService->storeCompressedImage(
                $request->file('logo_path'),
                'profil'
            );
        }

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            if ($profil->hero_image && Storage::disk('public')->exists($profil->hero_image)) {
                Storage::disk('public')->delete($profil->hero_image);
            }
            $profil->hero_image = $this->mediaCompressionService->storeCompressedImage(
                $request->file('hero_image'),
                'profil/hero'
            );
        }

        // Handle hero image 2 upload
        if ($request->hasFile('hero_image_2')) {
            if ($profil->hero_image_2 && Storage::disk('public')->exists($profil->hero_image_2)) {
                Storage::disk('public')->delete($profil->hero_image_2);
            }
            $profil->hero_image_2 = $this->mediaCompressionService->storeCompressedImage(
                $request->file('hero_image_2'),
                'profil/hero'
            );
        }

        // Handle hero image 3 upload
        if ($request->hasFile('hero_image_3')) {
            if ($profil->hero_image_3 && Storage::disk('public')->exists($profil->hero_image_3)) {
                Storage::disk('public')->delete($profil->hero_image_3);
            }
            $profil->hero_image_3 = $this->mediaCompressionService->storeCompressedImage(
                $request->file('hero_image_3'),
                'profil/hero'
            );
        }

        $profil->save();

        return redirect()->route('admin.profil-organisasi.edit')
            ->with('success', 'Profil organisasi berhasil diperbarui');
    }
}
