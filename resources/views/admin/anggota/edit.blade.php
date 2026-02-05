@extends('layouts.admin')

@section('title', 'Edit Anggota - Admin ISKAB')
@section('page_title', 'Edit Anggota')

@section('content')
<div class="max-w-2xl mx-auto">
    <form method="POST" action="{{ route('admin.anggota.update', $anggota) }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-8">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $anggota->nama) }}" placeholder="Masukkan nama lengkap" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('nama') border-red-500 @enderror">
            @error('nama')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Nomor Anggota</label>
            <input type="text" name="nomor_anggota" value="{{ old('nomor_anggota', $anggota->nomor_anggota) }}" placeholder="Cth: ISKAB-2024-001" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('nomor_anggota') border-red-500 @enderror">
            @error('nomor_anggota')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Korwil</label>
            @if(auth()->user()->role === 'korwil_admin')
                <input type="hidden" name="korwil_id" value="{{ $anggota->korwil_id }}">
                <div class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                    {{ $anggota->korwil->name }}
                </div>
            @elseif(auth()->user()->role === 'rayon_admin')
                <input type="hidden" name="korwil_id" value="{{ $anggota->korwil_id }}">
                <div class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                    {{ $anggota->korwil->name }}
                </div>
            @else
                <select name="korwil_id" id="korwil_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('korwil_id') border-red-500 @enderror">
                    <option value="">Pilih Korwil</option>
                    @foreach($korwils as $k)
                        <option value="{{ $k->id }}" {{ old('korwil_id', $anggota->korwil_id) == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                    @endforeach
                </select>
            @endif
            @error('korwil_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Rayon</label>
            @if(auth()->user()->role === 'rayon_admin')
                <input type="hidden" name="rayon_id" value="{{ $anggota->rayon_id }}">
                <div class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                    {{ $anggota->rayon->name }}
                </div>
            @else
                <select name="rayon_id" id="rayon_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('rayon_id') border-red-500 @enderror">
                    <option value="">Pilih Rayon</option>
                    @foreach($rayons as $r)
                        <option value="{{ $r->id }}" {{ old('rayon_id', $anggota->rayon_id) == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                    @endforeach
                </select>
            @endif
            @error('rayon_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Pondok</label>
            <input type="text" name="pondok" value="{{ old('pondok', $anggota->pondok) }}" placeholder="Nama pondok pesantren" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Alamat</label>
            <textarea name="alamat" rows="3" placeholder="Alamat lengkap" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('alamat', $anggota->alamat) }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Foto</label>
            @if($anggota->foto && file_exists(public_path($anggota->foto)))
                <div class="mb-3">
                    <img src="{{ asset($anggota->foto) }}" alt="Foto {{ $anggota->nama }}" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                </div>
                <label class="block text-xs font-semibold text-gray-600 mb-2">Ganti foto (biarkan kosong jika tidak ingin mengubah)</label>
            @endif
            <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <p class="text-gray-600 text-sm mt-1">Format: JPG, PNG (max 2MB)</p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Template KTA</label>
            <select name="kta_template_id" id="kta_template_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">-- Gunakan Template Default --</option>
                @foreach($ktaTemplates as $template)
                    <option value="{{ $template->id }}" {{ old('kta_template_id', $anggota->kta_template_id) == $template->id ? 'selected' : '' }}>
                        {{ $template->name }} {{ $template->is_active ? '(Aktif)' : '' }}
                    </option>
                @endforeach
            </select>
            <p class="text-gray-600 text-sm mt-1">Pilih template KTA yang akan digunakan untuk download KTA</p>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.anggota.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const korwilSelect = document.getElementById('korwil_id');
    const rayonSelect = document.getElementById('rayon_id');

    if (!korwilSelect) return;

    const fetchRayons = (korwilId, selectedId = null) => {
        if (!korwilId) {
            rayonSelect.innerHTML = '<option value="">Pilih Rayon</option>';
            return;
        }
        fetch(`/admin/rayon/by-korwil/${korwilId}`)
            .then(response => response.json())
            .then(data => {
                rayonSelect.innerHTML = '<option value="">Pilih Rayon</option>';
                data.forEach(rayon => {
                    const isSelected = selectedId && Number(selectedId) === Number(rayon.id) ? 'selected' : '';
                    rayonSelect.innerHTML += `<option value="${rayon.id}" ${isSelected}>${rayon.name}</option>`;
                });
            });
    };

    // initial load
    const initialKorwil = korwilSelect.value;
    const initialRayon = '{{ old('rayon_id', $anggota->rayon_id) }}';
    if (initialKorwil) {
        fetchRayons(initialKorwil, initialRayon);
    }

    korwilSelect.addEventListener('change', function() {
        fetchRayons(this.value);
    });
});
</script>
@endsection
