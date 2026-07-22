<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'return_date' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:2000-01-01'],
            'notes'       => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'return_date' => 'tanggal pengembalian',
            'notes'       => 'catatan',
        ];
    }
}
