<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowingRequest;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['member', 'book']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('borrow_number', 'like', "%{$search}%")
                  ->orWhereHas('member', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('book', fn($q) => $q->where('title', 'like', "%{$search}%"));
            });
        }

        $borrowings = $query->latest()->paginate(10)->withQueryString();

        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $members = Member::orderBy('name')->get();
        $books   = Book::where('available_stock', '>', 0)->orderBy('title')->get();

        return view('borrowings.create', compact('members', 'books'));
    }

    public function store(StoreBorrowingRequest $request)
    {
        $book = Book::findOrFail($request->book_id);

        if ($book->available_stock < 1) {
            return back()->withErrors(['book_id' => 'Stok buku tidak tersedia.'])->withInput();
        }

        $borrowNumber = Borrowing::generateBorrowNumber();

        Borrowing::create([
            'borrow_number' => $borrowNumber,
            'member_id'     => $request->member_id,
            'book_id'       => $request->book_id,
            'borrow_date'   => $request->borrow_date,
            'due_date'      => $request->due_date,
            'status'        => 'borrowed',
        ]);

        $book->decrement('available_stock');

        return redirect()->route('borrowings.index')->with('success', "Peminjaman {$borrowNumber} berhasil dicatat.");
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['member', 'book', 'return']);
        return view('borrowings.show', compact('borrowing'));
    }

    public function printReceipt(Borrowing $borrowing)
    {
        $borrowing->load(['member', 'book', 'return']);
        return view('borrowings.print', compact('borrowing'));
    }

    public function edit(Borrowing $borrowing)
    {
        return redirect()->route('borrowings.index');
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        return redirect()->route('borrowings.index');
    }

    public function destroy(Borrowing $borrowing)
    {
        if ($borrowing->status === 'borrowed') {
            $borrowing->book->increment('available_stock');
        }

        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Transaksi peminjaman berhasil dihapus.');
    }

    /**
     * Setujui reservasi anggota: status -> borrowed, stok dikurangi.
     */
    public function approve(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Hanya reservasi yang masih menunggu yang bisa disetujui.');
        }

        $book = $borrowing->book;

        if ($book->available_stock < 1) {
            return back()->with('error', 'Stok buku habis, reservasi tidak dapat disetujui.');
        }

        $borrowing->update([
            'status'      => 'borrowed',
            'borrow_date' => now()->toDateString(),
            'due_date'    => now()->addDays(7)->toDateString(),
        ]);

        $book->decrement('available_stock');

        return back()->with('success', "Reservasi {$borrowing->borrow_number} disetujui. Buku siap diambil anggota.");
    }

    /**
     * Tolak reservasi anggota: status -> rejected (stok tidak berubah).
     */
    public function reject(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Hanya reservasi yang masih menunggu yang bisa ditolak.');
        }

        $borrowing->update(['status' => 'rejected']);

        return back()->with('success', "Reservasi {$borrowing->borrow_number} ditolak.");
    }
}
