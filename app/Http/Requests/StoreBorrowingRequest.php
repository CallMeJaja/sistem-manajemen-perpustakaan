<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id'   => ['required', 'exists:members,id'],
            'book_id'     => ['required', 'exists:books,id'],
            'borrow_date' => ['required', 'date'],
            'due_date'    => ['required', 'date', 'after:borrow_date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'member_id'   => 'anggota',
            'book_id'     => 'buku',
            'borrow_date' => 'tanggal pinjam',
            'due_date'    => 'tanggal jatuh tempo',
        ];
    }
}
