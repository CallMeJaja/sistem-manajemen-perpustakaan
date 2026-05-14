<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books'      => Book::count(),
            'available_books'  => Book::where('available_stock', '>', 0)->count(),
            'total_members'    => Member::count(),
            'active_borrowings' => Borrowing::where('status', 'borrowed')->count(),
            'returned_borrowings' => Borrowing::where('status', 'returned')->count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
