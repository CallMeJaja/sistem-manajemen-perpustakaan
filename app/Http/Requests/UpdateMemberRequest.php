<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $memberId = $this->route('member')->id;

        return [
            'member_number' => ['required', 'string', 'max:20', Rule::unique('members')->ignore($memberId)],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', Rule::unique('members')->ignore($memberId)],
            'phone'         => ['nullable', 'string', 'max:20'],
            'address'       => ['nullable', 'string', 'max:500'],
            'join_date'     => ['required', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'member_number' => 'nomor anggota',
            'join_date'     => 'tanggal bergabung',
        ];
    }
}
