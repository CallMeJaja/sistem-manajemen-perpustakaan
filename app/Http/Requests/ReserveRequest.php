<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ReserveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isMember();
    }

    public function rules(): array
    {
        // Tidak ada input dari form; semua data berasal dari route + user login.
        return [];
    }

    /**
     * Aturan bisnis reservasi: stok tersedia & tidak ada reservasi/pinjaman
     * aktif yang duplikat untuk buku yang sama.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $book = $this->route('book');

            if (! $book || $book->available_stock < 1) {
                $validator->errors()->add('book', 'Stok buku sedang tidak tersedia.');
                return;
            }

            $member = optional($this->user())->member;

            if (! $member) {
                $validator->errors()->add('book', 'Akun Anda belum terhubung dengan data anggota.');
                return;
            }

            $duplicate = $member->borrowings()
                ->where('book_id', $book->id)
                ->whereIn('status', ['pending', 'borrowed'])
                ->exists();

            if ($duplicate) {
                $validator->errors()->add('book', 'Anda sudah memiliki reservasi atau peminjaman aktif untuk buku ini.');
            }
        });
    }
}
