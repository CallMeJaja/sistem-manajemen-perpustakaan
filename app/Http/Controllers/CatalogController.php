<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CatalogController extends Controller
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

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('available_stock', '>', 0);
            } else {
                $query->where('available_stock', 0);
            }
        }

        // Pagination limit
        $perPage = $request->integer('per_page', 12);
        $allowed = [10, 15, 20, 25, 50, 100];
        $perPage = in_array($perPage, $allowed) ? $perPage : 12;

        $books      = $query->latest()->paginate($perPage)->withQueryString();
        $categories = Book::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('catalog.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        return view('catalog.show', compact('book'));
    }
}
