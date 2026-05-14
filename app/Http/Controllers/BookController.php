<?php

namespace App\Http\Controllers;

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

        $books = $query->latest()->paginate(10)->withQueryString();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'publisher'   => ['required', 'string', 'max:255'],
            'isbn'        => ['nullable', 'string', 'max:20', 'unique:books,isbn'],
            'category'    => ['required', 'string', 'max:100'],
            'year'        => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'total_stock' => ['required', 'integer', 'min:1'],
            'location'    => ['nullable', 'string', 'max:100'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

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

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'publisher'   => ['required', 'string', 'max:255'],
            'isbn'        => ['nullable', 'string', 'max:20', 'unique:books,isbn,' . $book->id],
            'category'    => ['required', 'string', 'max:100'],
            'year'        => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'total_stock' => ['required', 'integer', 'min:1'],
            'location'    => ['nullable', 'string', 'max:100'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

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
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
