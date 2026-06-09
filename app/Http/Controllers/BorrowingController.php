<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $request->validate([
            'member_id'   => ['required', 'exists:members,id'],
            'book_id'     => ['required', 'exists:books,id'],
            'borrow_date' => ['required', 'date'],
            'due_date'    => ['required', 'date', 'after:borrow_date'],
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available_stock < 1) {
            return back()->withErrors(['book_id' => 'Stok buku tidak tersedia.'])->withInput();
        }

        $borrowNumber = 'BRW-' . now()->format('Ymd') . '-' . str_pad(Borrowing::count() + 1, 5, '0', STR_PAD_LEFT);

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
        return redirect()->route('borrowings.index');
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
        return redirect()->route('borrowings.index');
    }
}
