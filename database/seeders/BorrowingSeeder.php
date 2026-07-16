<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookReturn;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    public function run(): void
    {
        $year = now()->format('Y');

        $borrowings = [
            // === RETURNED (10 data: 5 tepat waktu + 5 terlambat) ===
            [
                'member_number' => "AGT-{$year}-0001",
                'book_title'    => 'Laskar Pelangi',
                'borrow_date'   => now()->subDays(45)->format('Y-m-d'),
                'due_date'      => now()->subDays(38)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(40)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
            [
                'member_number' => "AGT-{$year}-0002",
                'book_title'    => 'The Daily Stoic',
                'borrow_date'   => now()->subDays(40)->format('Y-m-d'),
                'due_date'      => now()->subDays(33)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(35)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
            [
                'member_number' => "AGT-{$year}-0010",
                'book_title'    => 'PHP & MySQL',
                'borrow_date'   => now()->subDays(50)->format('Y-m-d'),
                'due_date'      => now()->subDays(43)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(44)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
            [
                'member_number' => "AGT-{$year}-0011",
                'book_title'    => 'Clean Code',
                'borrow_date'   => now()->subMonths(1)->subDays(10)->format('Y-m-d'),
                'due_date'      => now()->subMonths(1)->subDays(3)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subMonths(1)->subDays(4)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
            [
                'member_number' => "AGT-{$year}-0012",
                'book_title'    => 'The 7 Habits of Highly Effective People',
                'borrow_date'   => now()->subMonths(2)->subDays(5)->format('Y-m-d'),
                'due_date'      => now()->subMonths(2)->addDays(2)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subMonths(2)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
            // Returned terlambat
            [
                'member_number' => "AGT-{$year}-0003",
                'book_title'    => 'Atomic Habits',
                'borrow_date'   => now()->subDays(25)->format('Y-m-d'),
                'due_date'      => now()->subDays(18)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(15)->format('Y-m-d'),
                'late_days'     => 3,
                'fine_amount'   => 3000,
            ],
            [
                'member_number' => "AGT-{$year}-0004",
                'book_title'    => 'Rich Dad, Poor Dad',
                'borrow_date'   => now()->subDays(20)->format('Y-m-d'),
                'due_date'      => now()->subDays(13)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(10)->format('Y-m-d'),
                'late_days'     => 3,
                'fine_amount'   => 3000,
            ],
            [
                'member_number' => "AGT-{$year}-0020",
                'book_title'    => 'Sapiens',
                'borrow_date'   => now()->subDays(30)->format('Y-m-d'),
                'due_date'      => now()->subDays(23)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(18)->format('Y-m-d'),
                'late_days'     => 5,
                'fine_amount'   => 5000,
            ],
            [
                'member_number' => "AGT-{$year}-0018",
                'book_title'    => 'Cosmos',
                'borrow_date'   => now()->subDays(28)->format('Y-m-d'),
                'due_date'      => now()->subDays(21)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(19)->format('Y-m-d'),
                'late_days'     => 2,
                'fine_amount'   => 2000,
            ],
            [
                'member_number' => "AGT-{$year}-0024",
                'book_title'    => 'Pulang',
                'borrow_date'   => now()->subDays(15)->format('Y-m-d'),
                'due_date'      => now()->subDays(8)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(8)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],

            // === BORROWED (8 data: 4 tepat waktu + 4 terlambat) ===
            [
                'member_number' => "AGT-{$year}-0005",
                'book_title'    => 'Bumi Manusia',
                'borrow_date'   => now()->subDays(5)->format('Y-m-d'),
                'due_date'      => now()->addDays(2)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            [
                'member_number' => "AGT-{$year}-0006",
                'book_title'    => 'Negeri 5 Menara',
                'borrow_date'   => now()->subDays(3)->format('Y-m-d'),
                'due_date'      => now()->addDays(4)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            [
                'member_number' => "AGT-{$year}-0013",
                'book_title'    => 'Brief Answers to the Big Questions',
                'borrow_date'   => now()->subDays(4)->format('Y-m-d'),
                'due_date'      => now()->addDays(3)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            [
                'member_number' => "AGT-{$year}-0021",
                'book_title'    => 'The China Study',
                'borrow_date'   => now()->subDays(2)->format('Y-m-d'),
                'due_date'      => now()->addDays(5)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            // Borrowed terlambat
            [
                'member_number' => "AGT-{$year}-0007",
                'book_title'    => 'Laskar Pelangi',
                'borrow_date'   => now()->subDays(15)->format('Y-m-d'),
                'due_date'      => now()->subDays(5)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            [
                'member_number' => "AGT-{$year}-0008",
                'book_title'    => 'Perahu Kertas',
                'borrow_date'   => now()->subDays(20)->format('Y-m-d'),
                'due_date'      => now()->subDays(8)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            [
                'member_number' => "AGT-{$year}-0015",
                'book_title'    => 'Python Crash Course',
                'borrow_date'   => now()->subDays(12)->format('Y-m-d'),
                'due_date'      => now()->subDays(3)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            [
                'member_number' => "AGT-{$year}-0022",
                'book_title'    => 'The Psychology of Money',
                'borrow_date'   => now()->subDays(14)->format('Y-m-d'),
                'due_date'      => now()->subDays(2)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],

            // === PENDING (4 data) ===
            [
                'member_number' => "AGT-{$year}-0016",
                'book_title'    => 'A Brief History of Time',
                'borrow_date'   => now()->format('Y-m-d'),
                'due_date'      => now()->addDays(7)->format('Y-m-d'),
                'status'        => 'pending',
            ],
            [
                'member_number' => "AGT-{$year}-0017",
                'book_title'    => 'How Children Learn',
                'borrow_date'   => now()->format('Y-m-d'),
                'due_date'      => now()->addDays(7)->format('Y-m-d'),
                'status'        => 'pending',
            ],
            [
                'member_number' => "AGT-{$year}-0014",
                'book_title'    => 'The Pragmatic Programmer',
                'borrow_date'   => now()->format('Y-m-d'),
                'due_date'      => now()->addDays(7)->format('Y-m-d'),
                'status'        => 'pending',
            ],
            [
                'member_number' => "AGT-{$year}-0023",
                'book_title'    => 'Fenomena Intrinsik Cerita Anak Indonesia',
                'borrow_date'   => now()->format('Y-m-d'),
                'due_date'      => now()->addDays(7)->format('Y-m-d'),
                'status'        => 'pending',
            ],

            // === REJECTED (3 data) ===
            [
                'member_number' => "AGT-{$year}-0019",
                'book_title'    => 'Algoritma & Pemrograman',
                'borrow_date'   => now()->subDays(3)->format('Y-m-d'),
                'due_date'      => now()->addDays(4)->format('Y-m-d'),
                'status'        => 'rejected',
            ],
            [
                'member_number' => "AGT-{$year}-0009",
                'book_title'    => 'Guns, Germs, and Steel',
                'borrow_date'   => now()->subDays(5)->format('Y-m-d'),
                'due_date'      => now()->addDays(2)->format('Y-m-d'),
                'status'        => 'rejected',
            ],
            [
                'member_number' => "AGT-{$year}-0018",
                'book_title'    => 'A History of Modern Indonesia Since c. 1200',
                'borrow_date'   => now()->subDays(2)->format('Y-m-d'),
                'due_date'      => now()->addDays(5)->format('Y-m-d'),
                'status'        => 'rejected',
            ],
        ];

        foreach ($borrowings as $index => $data) {
            $member = Member::where('member_number', $data['member_number'])->first();
            $book   = Book::where('title', $data['book_title'])->first();

            if (!$member || !$book) {
                continue;
            }

            $borrowDate = \Carbon\Carbon::parse($data['borrow_date']);
            $borrowNumber = 'PJ/' . $borrowDate->format('Ymd') . '/' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            $borrowing = Borrowing::create([
                'borrow_number' => $borrowNumber,
                'member_id'     => $member->id,
                'book_id'       => $book->id,
                'borrow_date'   => $data['borrow_date'],
                'due_date'      => $data['due_date'],
                'status'        => $data['status'],
            ]);

            if ($data['status'] === 'returned') {
                BookReturn::create([
                    'borrowing_id' => $borrowing->id,
                    'return_date'  => $data['return_date'],
                    'late_days'    => $data['late_days'],
                    'fine_amount'  => $data['fine_amount'],
                    'notes'        => null,
                ]);
            }
        }

        // Hitung ulang available_stock berdasarkan transaksi aktif
        $books = Book::all();
        foreach ($books as $book) {
            $borrowedCount = $book->borrowings()->where('status', 'borrowed')->count();
            $pendingCount = $book->borrowings()->where('status', 'pending')->count();
            $book->update([
                'available_stock' => max(0, $book->total_stock - $borrowedCount - $pendingCount)
            ]);
        }
    }
}