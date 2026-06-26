<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReturnRequest;
use App\Models\BookReturn;
use App\Models\Borrowing;

class BookReturnController extends Controller
{
    public function create(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Hanya peminjaman aktif yang dapat dikembalikan.');
        }

        $returnDate = now()->toDateString();
        $dueDate    = $borrowing->due_date->startOfDay();
        $lateDays   = max(0, $dueDate->diffInDays(now()->startOfDay(), false));
        $fineAmount = $lateDays * 1000;

        return view('returns.create', compact('borrowing', 'returnDate', 'lateDays', 'fineAmount'));
    }

    public function store(StoreReturnRequest $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return redirect()->route('borrowings.index')
                ->with('error', 'Hanya peminjaman aktif yang dapat dikembalikan.');
        }

        $returnDate = \Carbon\Carbon::parse($request->return_date)->startOfDay();
        $dueDate    = $borrowing->due_date->startOfDay();
        $lateDays   = max(0, $dueDate->diffInDays($returnDate, false));
        $fineAmount = $lateDays * 1000;

        BookReturn::create([
            'borrowing_id' => $borrowing->id,
            'return_date'  => $request->return_date,
            'late_days'    => $lateDays,
            'fine_amount'  => $fineAmount,
            'notes'        => $request->notes,
        ]);

        $borrowing->update(['status' => 'returned']);
        $borrowing->book->increment('available_stock');

        return redirect()->route('borrowings.index')
            ->with('success', 'Pengembalian buku berhasil dicatat.' . ($fineAmount > 0 ? " Denda: Rp " . number_format($fineAmount, 0, ',', '.') : ''));
    }
}
