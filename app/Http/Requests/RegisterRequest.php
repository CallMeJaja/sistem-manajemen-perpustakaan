<?php

namespace App\Http\Requests;

use App\Rules\IndonesianPhone;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya tamu (belum login) yang boleh mendaftar — dibatasi middleware 'guest'.
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email', 'unique:members,email'],
            'phone'    => ['required', 'string', 'max:20', new IndonesianPhone],
            'address'  => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => 'nama',
            'email'    => 'email',
            'phone'    => 'nomor telepon',
            'password' => 'kata sandi',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email ini sudah terdaftar. Silakan login.',
            'phone.required' => 'Nomor telepon wajib diisi.',
        ];
    }
}
