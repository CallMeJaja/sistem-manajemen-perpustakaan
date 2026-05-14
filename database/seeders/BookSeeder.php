<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title'           => 'Laskar Pelangi',
                'author'          => 'Andrea Hirata',
                'publisher'       => 'Bentang Pustaka',
                'isbn'            => '978-979-1227-00-8',
                'category'        => 'Fiksi',
                'year'            => 2005,
                'total_stock'     => 5,
                'available_stock' => 3,
                'location'        => 'A-01',
            ],
            [
                'title'           => 'Bumi Manusia',
                'author'          => 'Pramoedya Ananta Toer',
                'publisher'       => 'Lentera Dipantara',
                'isbn'            => '978-979-97312-3-2',
                'category'        => 'Fiksi',
                'year'            => 1980,
                'total_stock'     => 4,
                'available_stock' => 4,
                'location'        => 'A-02',
            ],
            [
                'title'           => 'Negeri 5 Menara',
                'author'          => 'Ahmad Fuadi',
                'publisher'       => 'Gramedia Pustaka Utama',
                'isbn'            => '978-979-22-5079-9',
                'category'        => 'Fiksi',
                'year'            => 2009,
                'total_stock'     => 3,
                'available_stock' => 2,
                'location'        => 'A-03',
            ],
            [
                'title'           => 'Filosofi Teras',
                'author'          => 'Henry Manampiring',
                'publisher'       => 'Kompas',
                'isbn'            => '978-979-709-984-1',
                'category'        => 'Pengembangan Diri',
                'year'            => 2018,
                'total_stock'     => 6,
                'available_stock' => 5,
                'location'        => 'B-01',
            ],
            [
                'title'           => 'Atomic Habits',
                'author'          => 'James Clear',
                'publisher'       => 'Penguin Random House',
                'isbn'            => '978-0-7352-1129-2',
                'category'        => 'Pengembangan Diri',
                'year'            => 2018,
                'total_stock'     => 4,
                'available_stock' => 2,
                'location'        => 'B-02',
            ],
            [
                'title'           => 'Rich Dad Poor Dad',
                'author'          => 'Robert T. Kiyosaki',
                'publisher'       => 'Plata Publishing',
                'isbn'            => '978-1-61268-017-3',
                'category'        => 'Bisnis & Keuangan',
                'year'            => 1997,
                'total_stock'     => 5,
                'available_stock' => 3,
                'location'        => 'C-01',
            ],
            [
                'title'           => 'Sapiens: A Brief History of Humankind',
                'author'          => 'Yuval Noah Harari',
                'publisher'       => 'Harper',
                'isbn'            => '978-0-06-231609-7',
                'category'        => 'Sejarah',
                'year'            => 2011,
                'total_stock'     => 3,
                'available_stock' => 1,
                'location'        => 'D-01',
            ],
            [
                'title'           => 'Clean Code',
                'author'          => 'Robert C. Martin',
                'publisher'       => 'Prentice Hall',
                'isbn'            => '978-0-13-235088-4',
                'category'        => 'Teknologi',
                'year'            => 2008,
                'total_stock'     => 4,
                'available_stock' => 4,
                'location'        => 'E-01',
            ],
            [
                'title'           => 'Pemrograman Web dengan PHP & MySQL',
                'author'          => 'Budi Raharjo',
                'publisher'       => 'Informatika',
                'isbn'            => '978-602-1514-19-3',
                'category'        => 'Teknologi',
                'year'            => 2016,
                'total_stock'     => 5,
                'available_stock' => 3,
                'location'        => 'E-02',
            ],
            [
                'title'           => 'Algoritma dan Pemrograman',
                'author'          => 'Rinaldi Munir',
                'publisher'       => 'Informatika',
                'isbn'            => '978-979-3338-71-5',
                'category'        => 'Teknologi',
                'year'            => 2011,
                'total_stock'     => 6,
                'available_stock' => 5,
                'location'        => 'E-03',
            ],
            [
                'title'           => 'Perahu Kertas',
                'author'          => 'Dee Lestari',
                'publisher'       => 'Bentang Pustaka',
                'isbn'            => '978-979-1227-45-9',
                'category'        => 'Fiksi',
                'year'            => 2009,
                'total_stock'     => 3,
                'available_stock' => 0,
                'location'        => 'A-04',
            ],
            [
                'title'           => 'The Psychology of Money',
                'author'          => 'Morgan Housel',
                'publisher'       => 'Harriman House',
                'isbn'            => '978-0-85719-780-4',
                'category'        => 'Bisnis & Keuangan',
                'year'            => 2020,
                'total_stock'     => 4,
                'available_stock' => 2,
                'location'        => 'C-02',
            ],
            [
                'title'           => 'Sejarah Indonesia Modern 1200–2004',
                'author'          => 'M.C. Ricklefs',
                'publisher'       => 'Serambi',
                'isbn'            => '978-979-024-000-2',
                'category'        => 'Sejarah',
                'year'            => 2005,
                'total_stock'     => 3,
                'available_stock' => 3,
                'location'        => 'D-02',
            ],
            [
                'title'           => 'Pengantar Akuntansi',
                'author'          => 'Charles T. Horngren',
                'publisher'       => 'Erlangga',
                'isbn'            => '978-979-781-592-0',
                'category'        => 'Bisnis & Keuangan',
                'year'            => 2012,
                'total_stock'     => 5,
                'available_stock' => 4,
                'location'        => 'C-03',
            ],
            [
                'title'           => 'The 7 Habits of Highly Effective People',
                'author'          => 'Stephen R. Covey',
                'publisher'       => 'Free Press',
                'isbn'            => '978-0-7432-6951-3',
                'category'        => 'Pengembangan Diri',
                'year'            => 1989,
                'total_stock'     => 4,
                'available_stock' => 3,
                'location'        => 'B-03',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
