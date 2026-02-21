@extends('layouts.admin')

@section('title', 'Edit Profil - Admin PMII')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit Profil</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola informasi akun dan keamanan Anda</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-900">Informasi Profil</h2>
            <p class="text-sm text-gray-600">
                @if($userType === 'rayon')
                    Perbarui informasi Rayon Anda
                @else
                    Perbarui nama dan alamat email akun Anda
                @endif
            </p>
        </div>
        <div class="p-6">
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field khusus Rayon --}}
                    @if($userType === 'rayon')
                        <div>
                            <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">Kontak (No. HP/WA)</label>
                            <input type="text" id="contact" name="contact" value="{{ old('contact', $user->contact) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                placeholder="Contoh: 081234567890">
                            @error('contact')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                {{-- Deskripsi untuk Rayon --}}
                @if($userType === 'rayon')
                    <div>
                        <label for="logo_path" class="block text-sm font-medium text-gray-700 mb-2">Logo Rayon</label>

                        @if($user->logo_path)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $user->logo_path) }}" alt="Logo {{ $user->name }}" class="h-20 w-20 object-contain rounded-lg border border-gray-200 p-2 bg-white">
                            </div>
                        @endif

                        <input type="file" id="logo_path" name="logo_path" accept="image/png,image/jpeg,image/jpg,image/webp"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors file:mr-4 file:py-2 file:px-3 file:rounded-md file:border-0 file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                        @error('logo_path')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">Akun Instagram</label>
                            <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $user->instagram) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                placeholder="Contoh: pmii_rayon_abc atau https://instagram.com/pmii_rayon_abc">
                            @error('instagram')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tiktok" class="block text-sm font-medium text-gray-700 mb-2">Akun TikTok</label>
                            <input type="text" id="tiktok" name="tiktok" value="{{ old('tiktok', $user->tiktok) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                placeholder="Contoh: pmii.rayon.abc atau https://tiktok.com/@pmii.rayon.abc">
                            @error('tiktok')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                            placeholder="Deskripsi singkat tentang Rayon Anda...">{{ old('description', $user->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div class="flex items-center gap-4">
                    <button type="submit" class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-all">
                        Simpan Perubahan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p class="text-sm text-green-600 font-medium" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                            ✓ Profil berhasil diperbarui
                        </p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-900">Ubah Password</h2>
            <p class="text-sm text-gray-600">Pastikan akun Anda menggunakan password yang kuat dan aman</p>
        </div>
        <div class="p-6">
            <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-xl">
                @csrf
                @method('put')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" autocomplete="current-password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    @error('current_password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" id="password" name="password" autocomplete="new-password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    @error('password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    @error('password_confirmation', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-all">
                        Ubah Password
                    </button>
                    @if (session('status') === 'password-updated')
                        <p class="text-sm text-green-600 font-medium" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                            ✓ Password berhasil diubah
                        </p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Danger Zone - Delete Account (Optional - hanya untuk admin biasa, bukan rayon) -->
    @if(auth()->guard('web')->check())
    <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-red-100 bg-red-50">
            <h2 class="text-lg font-semibold text-red-900">Zona Berbahaya</h2>
            <p class="text-sm text-red-600">Tindakan di bawah ini tidak dapat dibatalkan</p>
        </div>
        <div class="p-6">
            <div class="max-w-xl">
                <p class="text-sm text-gray-600 mb-4">
                    Setelah akun Anda dihapus, semua data dan informasi terkait akan dihapus secara permanen.
                    Sebelum menghapus akun, pastikan Anda sudah mengunduh data yang ingin disimpan.
                </p>
                <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                    class="px-6 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-all">
                    Hapus Akun
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="document.getElementById('deleteModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Konfirmasi Hapus Akun
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan dan semua data akan hilang secara permanen.
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2">Masukkan Password untuk Konfirmasi</label>
                                    <input type="password" id="delete_password" name="password" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                    @error('password', 'userDeletion')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Ya, Hapus Akun
                        </button>
                        <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
