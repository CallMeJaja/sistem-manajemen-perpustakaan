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
        $sortOptions = [
            'newest'        => ['column' => 'created_at', 'direction' => 'desc'],
            'oldest'        => ['column' => 'created_at', 'direction' => 'asc'],
            'due_soonest'   => ['column' => 'due_date', 'direction' => 'asc'],
            'due_latest'    => ['column' => 'due_date', 'direction' => 'desc'],
            'borrow_newest' => ['column' => 'borrow_date', 'direction' => 'desc'],
            'borrow_oldest' => ['column' => 'borrow_date', 'direction' => 'asc'],
        ];

        $sort = $request->input('sort', 'newest');
        if (isset($sortOptions[$sort])) {
            $query->orderBy($sortOptions[$sort]['column'], $sortOptions[$sort]['direction']);
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