<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('available_stock', '>', 0);
            } else {
                $query->where('available_stock', 0);
            }
        }

        // Sorting
        $sortOptions = [
            'newest'     => ['column' => 'created_at', 'direction' => 'desc'],
            'oldest'     => ['column' => 'created_at', 'direction' => 'asc'],
            'title_az'   => ['column' => 'title', 'direction' => 'asc'],
            'title_za'   => ['column' => 'title', 'direction' => 'desc'],
            'author_az'  => ['column' => 'author', 'direction' => 'asc'],
            'author_za'  => ['column' => 'author', 'direction' => 'desc'],
            'stock_most' => ['column' => 'available_stock', 'direction' => 'desc'],
            'stock_least'=> ['column' => 'available_stock', 'direction' => 'asc'],
        ];

        $sort = $request->input('sort', 'newest');
        if (isset($sortOptions[$sort])) {
            $query->orderBy($sortOptions[$sort]['column'], $sortOptions[$sort]['direction']);
        } else {
            $query->latest();
        }

        $books = $query->paginate(10)->withQueryString();

        return view('books.index', compact('books'));
    }

    /**
     * API: Search books for autocomplete (multi-field: title, author, isbn, category).
     * Only returns books with available stock > 0.
     */
    public function search(Request $request)
    {
        $q = $request->input('q', '');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $books = Book::where('available_stock', '>', 0)
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('author', 'like', "%{$q}%")
                      ->orWhere('isbn', 'like', "%{$q}%")
                      ->orWhere('category', 'like', "%{$q}%");
            })->limit(10)
              ->get(['id', 'title', 'author', 'isbn', 'category', 'available_stock']);

        return response()->json($books);
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        $validated['available_stock'] = $validated['total_stock'];

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        return redirect()->route('books.edit', $book);
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        $stockDiff = $validated['total_stock'] - $book->total_stock;
        $validated['available_stock'] = max(0, $book->available_stock + $stockDiff);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->borrowings()->where('status', 'borrowed')->exists()) {
            return redirect()->route('books.index')
                ->with('error', 'Buku tidak dapat dihapus karena masih dalam status peminjaman aktif.');
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
