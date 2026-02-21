<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Determine which guard is active and get corresponding user/table
        $user = $this->user();
        $table = 'users';
        $isRayon = false;

        if (Auth::guard('rayon')->check()) {
            $user = Auth::guard('rayon')->user();
            $table = 'rayons';
            $isRayon = true;
        }

        // Base rules for all users
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique($table)->ignore($user->id),
            ],
        ];

        // Additional rules for Rayon
        if ($isRayon) {
            $rules['contact'] = ['nullable', 'string', 'max:50'];
            $rules['instagram'] = ['nullable', 'string', 'max:255'];
            $rules['tiktok'] = ['nullable', 'string', 'max:255'];
            $rules['description'] = ['nullable', 'string', 'max:1000'];
            $rules['logo_path'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'contact.max' => 'Kontak maksimal 50 karakter.',
            'instagram.max' => 'Akun Instagram maksimal 255 karakter.',
            'tiktok.max' => 'Akun TikTok maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'logo_path.image' => 'File logo harus berupa gambar.',
            'logo_path.mimes' => 'Format logo harus jpeg, jpg, png, atau webp.',
            'logo_path.max' => 'Ukuran logo maksimal 2MB.',
        ];
    }
}
