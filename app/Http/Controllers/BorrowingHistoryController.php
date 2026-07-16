<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['member', 'book', 'return'])
            ->whereIn('status', ['returned', 'rejected', 'cancelled']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('borrow_number', 'like', "%{$search}%")
                  ->orWhereHas('member', function ($qMember) use ($search) {
                      $qMember->where('name', 'like', "%{$search}%")
                              ->orWhere('member_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('book', function ($qBook) use ($search) {
                      $qBook->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $order = $request->input('order', 'desc');
        $allowedColumns = ['borrow_date', 'due_date', 'borrow_number', 'status', 'created_at'];
        $allowedOrder = ['asc', 'desc'];

        if (in_array($sortBy, $allowedColumns) && in_array($order, $allowedOrder)) {
            $query->orderBy($sortBy, $order);
        } else {
            $query->latest();
        }

        $borrowings = $query->paginate(10)->withQueryString();

        return view('borrowings.history', compact('borrowings'));
    }

    public function report()
    {
        $borrowings = Borrowing::with(['member', 'book', 'return'])
            ->whereIn('status', ['returned', 'rejected', 'cancelled'])
            ->latest()
            ->get();

        return view('borrowings.report', compact('borrowings'));
    }
}