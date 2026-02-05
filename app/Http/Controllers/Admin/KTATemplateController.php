<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KTATemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KTATemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = KTATemplate::all();
        return view('admin.kta-template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kta-template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        $imagePath = $request->file('image')->store('kta-templates', 'public');

        KTATemplate::create([
            'name' => $request->name,
            'image_path' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->route('admin.kta-template.index')->with('success', 'KTA template berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(KTATemplate $ktaTemplate)
    {
        return view('admin.kta-template.show', compact('ktaTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KTATemplate $ktaTemplate)
    {
        return view('admin.kta-template.edit', compact('ktaTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KTATemplate $ktaTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($ktaTemplate->image_path) {
                Storage::disk('public')->delete($ktaTemplate->image_path);
            }
            $imagePath = $request->file('image')->store('kta-templates', 'public');
            $ktaTemplate->image_path = $imagePath;
        }

        $ktaTemplate->update([
            'name' => $request->name,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.kta-template.index')->with('success', 'KTA template berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KTATemplate $ktaTemplate)
    {
        if ($ktaTemplate->image_path) {
            Storage::disk('public')->delete($ktaTemplate->image_path);
        }

        $ktaTemplate->delete();
        return redirect()->route('admin.kta-template.index')->with('success', 'KTA template berhasil dihapus');
    }
}

