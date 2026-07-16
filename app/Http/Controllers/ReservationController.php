<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReserveRequest;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Anggota mengajukan reservasi buku (status pending).
     * Stok belum dikurangi — pengurangan terjadi saat admin menyetujui.
     */
    public function store(ReserveRequest $request, Book $book)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $member = $user->member;

        Borrowing::create([
            'borrow_number' => Borrowing::generateBorrowNumber(),
            'member_id'     => $member->id,
            'book_id'       => $book->id,
            'borrow_date'   => now()->toDateString(),
            'due_date'      => now()->addDays(7)->toDateString(),
            'status'        => 'pending',
        ]);

        return redirect()->route('member.borrowings')
            ->with('success', "Reservasi buku \"{$book->title}\" berhasil diajukan. Menunggu persetujuan petugas.");
    }

    /**
     * Anggota membatalkan reservasi miliknya yang masih menunggu.
     */
    public function cancel(Borrowing $borrowing)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $member = $user->member;

        abort_unless($member && $borrowing->member_id === $member->id, 403);

        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Hanya reservasi yang masih menunggu yang bisa dibatalkan.');
        }

        $borrowing->update(['status' => 'cancelled']);

        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
