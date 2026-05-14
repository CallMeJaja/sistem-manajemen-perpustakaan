<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'member_number' => 'MBR-00001',
                'name'          => 'Al Amani Abas',
                'email'         => 'al.amani.abas@email.com',
                'phone'         => '081234500001',
                'address'       => 'Jl. Merdeka No. 1, Purwakarta',
                'join_date'     => '2024-01-10',
            ],
            [
                'member_number' => 'MBR-00002',
                'name'          => 'Dhafi Ebsan Yurizal',
                'email'         => 'dhafi.ebsan.yurizal@email.com',
                'phone'         => '081234500002',
                'address'       => 'Jl. Pahlawan No. 2, Purwakarta',
                'join_date'     => '2024-01-12',
            ],
            [
                'member_number' => 'MBR-00003',
                'name'          => 'Diva Oryza Sativa',
                'email'         => 'diva.oryza.sativa@email.com',
                'phone'         => '081234500003',
                'address'       => 'Jl. Diponegoro No. 3, Purwakarta',
                'join_date'     => '2024-01-15',
            ],
            [
                'member_number' => 'MBR-00004',
                'name'          => 'Dyan Putri Agustin',
                'email'         => 'dyan.putri.agustin@email.com',
                'phone'         => '081234500004',
                'address'       => 'Jl. Sudirman No. 4, Purwakarta',
                'join_date'     => '2024-02-01',
            ],
            [
                'member_number' => 'MBR-00005',
                'name'          => 'Fikri Ramdani',
                'email'         => 'fikri.ramdani@email.com',
                'phone'         => '081234500005',
                'address'       => 'Jl. Gatot Subroto No. 5, Purwakarta',
                'join_date'     => '2024-02-05',
            ],
            [
                'member_number' => 'MBR-00006',
                'name'          => 'Helgi Nur Allamsyah',
                'email'         => 'helgi.nur.allamsyah@email.com',
                'phone'         => '081234500006',
                'address'       => 'Jl. Ahmad Yani No. 6, Purwakarta',
                'join_date'     => '2024-02-10',
            ],
            [
                'member_number' => 'MBR-00007',
                'name'          => 'Intan Sri Dayanti',
                'email'         => 'intan.sri.dayanti@email.com',
                'phone'         => '081234500007',
                'address'       => 'Jl. Veteran No. 7, Purwakarta',
                'join_date'     => '2024-02-15',
            ],
            [
                'member_number' => 'MBR-00008',
                'name'          => 'Jerry Sutisno',
                'email'         => 'jerry.sutisno@email.com',
                'phone'         => '081234500008',
                'address'       => 'Jl. Pemuda No. 8, Purwakarta',
                'join_date'     => '2024-03-01',
            ],
            [
                'member_number' => 'MBR-00009',
                'name'          => 'Josh Winston Imanuel',
                'email'         => 'josh.winston.imanuel@email.com',
                'phone'         => '081234500009',
                'address'       => 'Jl. Kartini No. 9, Purwakarta',
                'join_date'     => '2024-03-05',
            ],
            [
                'member_number' => 'MBR-00010',
                'name'          => 'Keisya Febri Sabila',
                'email'         => 'keisya.febri.sabila@email.com',
                'phone'         => '081234500010',
                'address'       => 'Jl. Rajawali No. 10, Purwakarta',
                'join_date'     => '2024-03-10',
            ],
            [
                'member_number' => 'MBR-00011',
                'name'          => 'Khaikal Iksanuddin',
                'email'         => 'khaikal.iksanuddin@email.com',
                'phone'         => '081234500011',
                'address'       => 'Jl. Cendrawasih No. 11, Purwakarta',
                'join_date'     => '2024-03-15',
            ],
            [
                'member_number' => 'MBR-00012',
                'name'          => 'Kirana Larasati Dewi',
                'email'         => 'kirana.larasati.dewi@email.com',
                'phone'         => '081234500012',
                'address'       => 'Jl. Anggrek No. 12, Purwakarta',
                'join_date'     => '2024-04-01',
            ],
            [
                'member_number' => 'MBR-00013',
                'name'          => 'Muhamad Gilang Ramadan',
                'email'         => 'muhamad.gilang.ramadan@email.com',
                'phone'         => '081234500013',
                'address'       => 'Jl. Melati No. 13, Purwakarta',
                'join_date'     => '2024-04-05',
            ],
            [
                'member_number' => 'MBR-00014',
                'name'          => 'Muhamad Sarwan Al Barizy',
                'email'         => 'muhamad.sarwan.al.barizy@email.com',
                'phone'         => '081234500014',
                'address'       => 'Jl. Mawar No. 14, Purwakarta',
                'join_date'     => '2024-04-10',
            ],
            [
                'member_number' => 'MBR-00015',
                'name'          => 'Muhammad Apiransyah Ramdhani',
                'email'         => 'muhammad.apiransyah.ramdhani@email.com',
                'phone'         => '081234500015',
                'address'       => 'Jl. Bougenville No. 15, Purwakarta',
                'join_date'     => '2024-04-15',
            ],
            [
                'member_number' => 'MBR-00016',
                'name'          => 'Reza Asriano Maulana',
                'email'         => 'reza.asriano.maulana@email.com',
                'phone'         => '081234500016',
                'address'       => 'Jl. Kenanga No. 16, Purwakarta',
                'join_date'     => '2024-05-01',
            ],
            [
                'member_number' => 'MBR-00017',
                'name'          => 'Salman Alfaridzi',
                'email'         => 'salman.alfaridzi@email.com',
                'phone'         => '081234500017',
                'address'       => 'Jl. Dahlia No. 17, Purwakarta',
                'join_date'     => '2024-05-05',
            ],
            [
                'member_number' => 'MBR-00018',
                'name'          => 'Satrio Ilham Syahputra',
                'email'         => 'satrio.ilham.syahputra@email.com',
                'phone'         => '081234500018',
                'address'       => 'Jl. Flamboyan No. 18, Purwakarta',
                'join_date'     => '2024-05-10',
            ],
            [
                'member_number' => 'MBR-00019',
                'name'          => 'Shevadina Aulia Rahma',
                'email'         => 'shevadina.aulia.rahma@email.com',
                'phone'         => '081234500019',
                'address'       => 'Jl. Seruni No. 19, Purwakarta',
                'join_date'     => '2024-06-01',
            ],
            [
                'member_number' => 'MBR-00020',
                'name'          => 'Siti Fatimatuzzahro',
                'email'         => 'siti.fatimatuzzahro@email.com',
                'phone'         => '081234500020',
                'address'       => 'Jl. Teratai No. 20, Purwakarta',
                'join_date'     => '2024-06-05',
            ],
            [
                'member_number' => 'MBR-00021',
                'name'          => 'Siti Romlah',
                'email'         => 'siti.romlah@email.com',
                'phone'         => '081234500021',
                'address'       => 'Jl. Tulip No. 21, Purwakarta',
                'join_date'     => '2024-06-10',
            ],
            [
                'member_number' => 'MBR-00022',
                'name'          => 'Subani Maulana',
                'email'         => 'subani.maulana@email.com',
                'phone'         => '081234500022',
                'address'       => 'Jl. Sakura No. 22, Purwakarta',
                'join_date'     => '2024-07-01',
            ],
            [
                'member_number' => 'MBR-00023',
                'name'          => 'Umar Maulana Sidiq',
                'email'         => 'umar.maulana.sidiq@email.com',
                'phone'         => '081234500023',
                'address'       => 'Jl. Lavender No. 23, Purwakarta',
                'join_date'     => '2024-07-05',
            ],
            [
                'member_number' => 'MBR-00024',
                'name'          => 'Zahra Ayu Trisna',
                'email'         => 'zahra.ayu.trisna@email.com',
                'phone'         => '081234500024',
                'address'       => 'Jl. Wijaya Kusuma No. 24, Purwakarta',
                'join_date'     => '2024-07-10',
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
