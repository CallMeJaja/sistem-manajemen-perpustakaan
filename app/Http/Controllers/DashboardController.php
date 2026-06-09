<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books'         => Book::count(),
            'available_books'     => Book::where('available_stock', '>', 0)->count(),
            'total_members'       => Member::count(),
            'active_borrowings'   => Borrowing::where('status', 'borrowed')->count(),
            'returned_borrowings' => Borrowing::where('status', 'returned')->count(),
            'late_borrowings'     => Borrowing::where('status', 'borrowed')
                                        ->whereDate('due_date', '<', now())
                                        ->count(),
        ];

        $borrowingsPerMonth = Borrowing::select(
                DB::raw('MONTH(borrow_date) as month'),
                DB::raw('YEAR(borrow_date) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->where('borrow_date', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $months     = [];
        $monthTotals = [];
        for ($i = 5; $i >= 0; $i--) {
            $date      = now()->subMonths($i);
            $label     = $date->translatedFormat('M Y');
            $months[]  = $label;
            $found     = $borrowingsPerMonth->first(
                fn($b) => $b->month == $date->month && $b->year == $date->year
            );
            $monthTotals[] = $found ? $found->total : 0;
        }

        $bookCategories = Book::select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $lateBorrowings = Borrowing::with(['member', 'book'])
            ->where('status', 'borrowed')
            ->whereDate('due_date', '<', now())
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        $recentBorrowings = Borrowing::with(['member', 'book'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'months',
            'monthTotals',
            'bookCategories',
            'lateBorrowings',
            'recentBorrowings'
        ));
    }
}
