<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookReturn;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $borrowings = [
            // Dikembalikan tepat waktu
            [
                'member_number' => 'MBR-00001',
                'book_title'    => 'Laskar Pelangi',
                'borrow_date'   => now()->subDays(30)->format('Y-m-d'),
                'due_date'      => now()->subDays(23)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(25)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
            // Dikembalikan tepat waktu
            [
                'member_number' => 'MBR-00002',
                'book_title'    => 'Filosofi Teras',
                'borrow_date'   => now()->subDays(25)->format('Y-m-d'),
                'due_date'      => now()->subDays(18)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(20)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
            // Dikembalikan terlambat
            [
                'member_number' => 'MBR-00003',
                'book_title'    => 'Atomic Habits',
                'borrow_date'   => now()->subDays(20)->format('Y-m-d'),
                'due_date'      => now()->subDays(13)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(10)->format('Y-m-d'),
                'late_days'     => 3,
                'fine_amount'   => 3000,
            ],
            // Dikembalikan terlambat
            [
                'member_number' => 'MBR-00004',
                'book_title'    => 'Rich Dad Poor Dad',
                'borrow_date'   => now()->subDays(15)->format('Y-m-d'),
                'due_date'      => now()->subDays(8)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(5)->format('Y-m-d'),
                'late_days'     => 3,
                'fine_amount'   => 3000,
            ],
            // Masih dipinjam - tepat waktu
            [
                'member_number' => 'MBR-00005',
                'book_title'    => 'Sapiens: A Brief History of Humankind',
                'borrow_date'   => now()->subDays(5)->format('Y-m-d'),
                'due_date'      => now()->addDays(2)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            // Masih dipinjam - tepat waktu
            [
                'member_number' => 'MBR-00006',
                'book_title'    => 'Negeri 5 Menara',
                'borrow_date'   => now()->subDays(3)->format('Y-m-d'),
                'due_date'      => now()->addDays(4)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            // Masih dipinjam - TERLAMBAT
            [
                'member_number' => 'MBR-00007',
                'book_title'    => 'Laskar Pelangi',
                'borrow_date'   => now()->subDays(15)->format('Y-m-d'),
                'due_date'      => now()->subDays(5)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            // Masih dipinjam - TERLAMBAT
            [
                'member_number' => 'MBR-00008',
                'book_title'    => 'Perahu Kertas',
                'borrow_date'   => now()->subDays(20)->format('Y-m-d'),
                'due_date'      => now()->subDays(8)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            // Masih dipinjam - tepat waktu
            [
                'member_number' => 'MBR-00009',
                'book_title'    => 'The Psychology of Money',
                'borrow_date'   => now()->subDays(2)->format('Y-m-d'),
                'due_date'      => now()->addDays(5)->format('Y-m-d'),
                'status'        => 'borrowed',
            ],
            // Dikembalikan tepat waktu
            [
                'member_number' => 'MBR-00010',
                'book_title'    => 'Pemrograman Web dengan PHP & MySQL',
                'borrow_date'   => now()->subDays(35)->format('Y-m-d'),
                'due_date'      => now()->subDays(28)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subDays(29)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
            // Bulan lalu untuk data grafik
            [
                'member_number' => 'MBR-00001',
                'book_title'    => 'Clean Code',
                'borrow_date'   => now()->subMonths(1)->subDays(10)->format('Y-m-d'),
                'due_date'      => now()->subMonths(1)->subDays(3)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subMonths(1)->subDays(4)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
            [
                'member_number' => 'MBR-00002',
                'book_title'    => 'The 7 Habits of Highly Effective People',
                'borrow_date'   => now()->subMonths(2)->subDays(5)->format('Y-m-d'),
                'due_date'      => now()->subMonths(2)->addDays(2)->format('Y-m-d'),
                'status'        => 'returned',
                'return_date'   => now()->subMonths(2)->format('Y-m-d'),
                'late_days'     => 0,
                'fine_amount'   => 0,
            ],
        ];

        foreach ($borrowings as $index => $data) {
            $member = Member::where('member_number', $data['member_number'])->first();
            $book   = Book::where('title', $data['book_title'])->first();

            if (!$member || !$book) {
                continue;
            }

            $borrowNumber = 'BRW-' . now()->subDays(30 - $index)->format('Ymd') . '-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT);

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
    }
}
