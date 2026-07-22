<?php

namespace App\Http\Requests;

use App\Rules\IndonesianPhone;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_number' => ['required', 'string', 'max:20', 'unique:members,member_number'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:members,email'],
            'phone'         => ['required', 'string', 'max:20', new IndonesianPhone],
            'address'       => ['nullable', 'string', 'max:500'],
            'join_date'     => ['required', 'date', 'before_or_equal:today', 'after_or_equal:2000-01-01'],
        ];
    }

    public function attributes(): array
    {
        return [
            'member_number' => 'nomor anggota',
            'phone'         => 'nomor telepon',
            'join_date'     => 'tanggal bergabung',
        ];
    }
}
