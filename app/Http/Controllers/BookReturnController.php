<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReturnRequest;
use App\Models\BookReturn;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BookReturnController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['member', 'book'])
            ->where('status', 'borrowed');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('borrow_number', 'like', "%{$search}%")
                  ->orWhereHas('member', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('book', fn($q) => $q->where('title', 'like', "%{$search}%"));
            });
        }

        $borrowings = $query->latest()->paginate(10)->withQueryString();

        return view('returns.index', compact('borrowings'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'borrow_number' => 'required|string',
        ]);

        $borrowing = Borrowing::where('borrow_number', $request->borrow_number)->first();

        if (!$borrowing || $borrowing->status !== 'borrowed') {
            return back()->with('error', 'Nomor peminjaman tidak ditemukan atau buku sudah dikembalikan/ditolak.');
        }

        return redirect()->route('returns.create', $borrowing);
    }

    public function create(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return redirect()->route('returns.index')
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
            return redirect()->route('returns.index')
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

        return redirect()->route('returns.index')
            ->with('success', 'Pengembalian buku berhasil dicatat.' . ($fineAmount > 0 ? " Denda: Rp " . number_format($fineAmount, 0, ',', '.') : ''));
    }
}
