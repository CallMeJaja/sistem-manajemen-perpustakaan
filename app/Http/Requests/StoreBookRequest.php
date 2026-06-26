<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Akses sudah dibatasi middleware 'admin' di route.
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'publisher'   => ['required', 'string', 'max:255'],
            'isbn'        => ['nullable', 'string', 'max:20', 'unique:books,isbn'],
            'category'    => ['required', 'string', 'max:100'],
            'year'        => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'total_stock' => ['required', 'integer', 'min:1'],
            'location'    => ['nullable', 'string', 'max:100'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'total_stock' => 'jumlah stok',
            'cover_image' => 'sampul',
        ];
    }
}
