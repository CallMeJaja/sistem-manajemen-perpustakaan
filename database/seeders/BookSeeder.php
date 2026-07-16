<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // ===== Fiksi (5) =====
            [
                'title'           => 'Laskar Pelangi',
                'cover_image'     => 'covers/laskar-pelangi.jpg',
                'author'          => 'Andrea Hirata',
                'publisher'       => 'Mizan Media Utama',
                'isbn'            => '9789793062792',
                'category'        => 'Fiksi',
                'year'            => 2005,
                'total_stock'     => 5,
                'location'        => 'A-01',
            ],
            [
                'title'           => 'Bumi Manusia',
                'cover_image'     => 'covers/bumi-manusia.jpg',
                'author'          => 'Pramoedya Ananta Toer',
                'publisher'       => 'Hasta Mitra',
                'isbn'            => '9780140256352',
                'category'        => 'Fiksi',
                'year'            => 1991,
                'total_stock'     => 4,
                'location'        => 'A-02',
            ],
            [
                'title'           => 'Negeri 5 Menara',
                'cover_image'     => 'covers/negeri-5-menara.jpg',
                'author'          => 'A. Fuadi',
                'publisher'       => 'Gramedia Pustaka Utama',
                'isbn'            => '9789792248616',
                'category'        => 'Fiksi',
                'year'            => 2009,
                'total_stock'     => 3,
                'location'        => 'A-03',
            ],
            [
                'title'           => 'Perahu Kertas',
                'cover_image'     => 'covers/perahu-kertas.jpg',
                'author'          => 'Dee',
                'publisher'       => 'Mizan Media Utama',
                'isbn'            => '9791227780',
                'category'        => 'Fiksi',
                'year'            => 2009,
                'total_stock'     => 3,
                'location'        => 'A-04',
            ],
            [
                'title'           => 'Pulang',
                'cover_image'     => 'covers/pulang.jpg',
                'author'          => 'Tere Liye',
                'publisher'       => 'Sabak Grip Nusantara',
                'isbn'            => '9786020822129',
                'category'        => 'Fiksi',
                'year'            => 2021,
                'total_stock'     => 4,
                'location'        => 'A-05',
            ],

            // ===== Pengembangan Diri (4) =====
            [
                'title'           => 'The Daily Stoic',
                'cover_image'     => 'covers/the-daily-stoic.jpg',
                'author'          => 'Ryan Holiday',
                'publisher'       => 'Portfolio',
                'isbn'            => '9780735211735',
                'category'        => 'Pengembangan Diri',
                'year'            => 2016,
                'total_stock'     => 4,
                'location'        => 'B-01',
            ],
            [
                'title'           => 'Atomic Habits',
                'cover_image'     => 'covers/atomic-habits.jpg',
                'author'          => 'James Clear',
                'publisher'       => 'Avery',
                'isbn'            => '9780735211292',
                'category'        => 'Pengembangan Diri',
                'year'            => 2018,
                'total_stock'     => 5,
                'location'        => 'B-02',
            ],
            [
                'title'           => 'The 7 Habits of Highly Effective People',
                'cover_image'     => 'covers/7-habits.jpg',
                'author'          => 'Stephen R. Covey',
                'publisher'       => 'Free Press',
                'isbn'            => '9780743269513',
                'category'        => 'Pengembangan Diri',
                'year'            => 1989,
                'total_stock'     => 4,
                'location'        => 'B-03',
            ],
            [
                'title'           => 'Sapiens',
                'cover_image'     => 'covers/sapiens.jpg',
                'author'          => 'Yuval Noah Harari',
                'publisher'       => 'Harper',
                'isbn'            => '9780062316097',
                'category'        => 'Pengembangan Diri',
                'year'            => 2016,
                'total_stock'     => 4,
                'location'        => 'B-04',
            ],

            // ===== Bisnis & Keuangan (3) =====
            [
                'title'           => 'Rich Dad, Poor Dad',
                'cover_image'     => 'covers/rich-dad-poor-dad.jpg',
                'author'          => 'Robert T. Kiyosaki',
                'publisher'       => 'Plata Publishing',
                'isbn'            => '9781612680173',
                'category'        => 'Bisnis & Keuangan',
                'year'            => 1997,
                'total_stock'     => 5,
                'location'        => 'C-01',
            ],
            [
                'title'           => 'The Psychology of Money',
                'cover_image'     => 'covers/psychology-of-money.jpg',
                'author'          => 'Morgan Housel',
                'publisher'       => 'Harriman House',
                'isbn'            => '9780857197804',
                'category'        => 'Bisnis & Keuangan',
                'year'            => 2020,
                'total_stock'     => 4,
                'location'        => 'C-02',
            ],
            [
                'title'           => 'Principles of Accounting',
                'cover_image'     => 'covers/principles-of-accounting.jpg',
                'author'          => 'Belverd E. Needles',
                'publisher'       => 'Houghton Mifflin',
                'isbn'            => '9780395295274',
                'category'        => 'Bisnis & Keuangan',
                'year'            => 1984,
                'total_stock'     => 3,
                'location'        => 'C-03',
            ],

            // ===== Sejarah (3) =====
            [
                'title'           => 'A History of Modern Indonesia Since c. 1200',
                'cover_image'     => 'covers/sejarah-indonesia-modern.jpg',
                'author'          => 'M.C. Ricklefs',
                'publisher'       => 'Stanford University Press',
                'isbn'            => '9780804761307',
                'category'        => 'Sejarah',
                'year'            => 2008,
                'total_stock'     => 3,
                'location'        => 'D-01',
            ],
            [
                'title'           => 'Guns, Germs, and Steel',
                'cover_image'     => 'covers/guns-germs-steel.jpg',
                'author'          => 'Jared Diamond',
                'publisher'       => 'W.W. Norton',
                'isbn'            => '9780393317558',
                'category'        => 'Sejarah',
                'year'            => 1997,
                'total_stock'     => 3,
                'location'        => 'D-02',
            ],
            [
                'title'           => 'A Brief History of Time',
                'cover_image'     => 'covers/brief-history-of-time.jpg',
                'author'          => 'Stephen Hawking',
                'publisher'       => 'Bantam Books',
                'isbn'            => '9780553380163',
                'category'        => 'Sejarah',
                'year'            => 1988,
                'total_stock'     => 4,
                'location'        => 'D-03',
            ],

            // ===== Teknologi (5) =====
            [
                'title'           => 'Clean Code',
                'cover_image'     => 'covers/clean-code.jpg',
                'author'          => 'Robert C. Martin',
                'publisher'       => 'Prentice Hall',
                'isbn'            => '9780132350884',
                'category'        => 'Teknologi',
                'year'            => 2008,
                'total_stock'     => 5,
                'location'        => 'E-01',
            ],
            [
                'title'           => 'PHP & MySQL',
                'cover_image'     => 'covers/php-mysql.jpg',
                'author'          => 'Jon Duckett',
                'publisher'       => 'Wiley',
                'isbn'            => '9781119149224',
                'category'        => 'Teknologi',
                'year'            => 2019,
                'total_stock'     => 4,
                'location'        => 'E-02',
            ],
            [
                'title'           => 'Algoritma & Pemrograman',
                'cover_image'     => 'covers/algoritma-pemrograman.jpg',
                'author'          => 'Rinaldi Munir',
                'publisher'       => 'Informatika',
                'isbn'            => '9786028758215',
                'category'        => 'Teknologi',
                'year'            => 2011,
                'total_stock'     => 6,
                'location'        => 'E-03',
            ],
            [
                'title'           => 'The Pragmatic Programmer',
                'cover_image'     => 'covers/pragmatic-programmer.jpg',
                'author'          => 'Andy Hunt',
                'publisher'       => 'Addison-Wesley',
                'isbn'            => '9780135956915',
                'category'        => 'Teknologi',
                'year'            => 2019,
                'total_stock'     => 3,
                'location'        => 'E-04',
            ],
            [
                'title'           => 'Python Crash Course',
                'cover_image'     => 'covers/python-crash-course.jpg',
                'author'          => 'Eric Matthes',
                'publisher'       => 'No Starch Press',
                'isbn'            => '9781593279288',
                'category'        => 'Teknologi',
                'year'            => 2019,
                'total_stock'     => 4,
                'location'        => 'E-05',
            ],

            // ===== Sains (2) =====
            [
                'title'           => 'Cosmos',
                'cover_image'     => 'covers/cosmos.jpg',
                'author'          => 'Carl Sagan',
                'publisher'       => 'Ballantine Books',
                'isbn'            => '9780345539434',
                'category'        => 'Sains',
                'year'            => 2013,
                'total_stock'     => 3,
                'location'        => 'F-01',
            ],
            [
                'title'           => 'Brief Answers to the Big Questions',
                'cover_image'     => 'covers/brief-answers.jpg',
                'author'          => 'Stephen Hawking',
                'publisher'       => 'Hodder & Stoughton',
                'isbn'            => '9781473699596',
                'category'        => 'Sains',
                'year'            => 2018,
                'total_stock'     => 3,
                'location'        => 'F-02',
            ],

            // ===== Anak & Pendidikan (2) =====
            [
                'title'           => 'How Children Learn',
                'cover_image'     => 'covers/how-children-learn.jpg',
                'author'          => 'John Holt',
                'publisher'       => 'Perseus Books',
                'isbn'            => '9780201484045',
                'category'        => 'Anak & Pendidikan',
                'year'            => 1995,
                'total_stock'     => 3,
                'location'        => 'G-01',
            ],
            [
                'title'           => 'Fenomena Intrinsik Cerita Anak Indonesia',
                'cover_image'     => 'covers/cerita-anak.jpg',
                'author'          => 'Bambang Trimansyah',
                'publisher'       => 'Nuansa',
                'isbn'            => '9789799551245',
                'category'        => 'Anak & Pendidikan',
                'year'            => 1999,
                'total_stock'     => 2,
                'location'        => 'G-02',
            ],

            // ===== Kesehatan (1) =====
            [
                'title'           => 'The China Study',
                'cover_image'     => 'covers/china-study.jpg',
                'author'          => 'T. Colin Campbell',
                'publisher'       => 'BenBella Books',
                'isbn'            => '9781935251002',
                'category'        => 'Kesehatan',
                'year'            => 2006,
                'total_stock'     => 3,
                'location'        => 'H-01',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Set available_stock = total_stock (belum ada transaksi)
        Book::query()->update(['available_stock' => \DB::raw('total_stock')]);
    }
}