<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'member_number' => '202404020',
                'name'          => 'Al Amani Abas',
                'email'         => 'al.amani.abas@email.com',
                'phone'         => '081234500001',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-01-10',
            ],
            [
                'member_number' => '202404018',
                'name'          => 'Dhafi Ebsan Yurizal',
                'email'         => 'dhafi.ebsan.yurizal@email.com',
                'phone'         => '081234500002',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-01-12',
            ],
            [
                'member_number' => '202404025',
                'name'          => 'Diva Oryza Sativa',
                'email'         => 'diva.oryza.sativa@email.com',
                'phone'         => '081234500003',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-01-15',
            ],
            [
                'member_number' => '202404002',
                'name'          => 'Dyan Putri Agustin',
                'email'         => 'dyan.putri.agustin@email.com',
                'phone'         => '081234500004',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-02-01',
            ],
            [
                'member_number' => '202404001',
                'name'          => 'Fikri Ramdani',
                'email'         => 'fikri.ramdani@email.com',
                'phone'         => '081234500005',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-02-05',
            ],
            [
                'member_number' => '202404010',
                'name'          => 'Helgi Nur Allamsyah',
                'email'         => 'helgi.nur.allamsyah@email.com',
                'phone'         => '081234500006',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-02-10',
            ],
            [
                'member_number' => '202404007',
                'name'          => 'Intan Sri Dayanti',
                'email'         => 'intan.sri.dayanti@email.com',
                'phone'         => '081234500007',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-02-15',
            ],
            [
                'member_number' => '202404026',
                'name'          => 'Jerry Sutisno',
                'email'         => 'jerry.sutisno@email.com',
                'phone'         => '081234500008',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-03-01',
            ],
            [
                'member_number' => '202404005',
                'name'          => 'Josh Winston Imanuel',
                'email'         => 'josh.winston.imanuel@email.com',
                'phone'         => '081234500009',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-03-05',
            ],
            [
                'member_number' => '202404017',
                'name'          => 'Keisya Febri Sabila',
                'email'         => 'keisya.febri.sabila@email.com',
                'phone'         => '081234500010',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-03-10',
            ],
            [
                'member_number' => '202404011',
                'name'          => 'Khaikal Iksanuddin',
                'email'         => 'khaikal.iksanuddin@email.com',
                'phone'         => '081234500011',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-03-15',
            ],
            [
                'member_number' => '202404009',
                'name'          => 'Kirana Larasati Dewi',
                'email'         => 'kirana.larasati.dewi@email.com',
                'phone'         => '081234500012',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-04-01',
            ],
            [
                'member_number' => '202404008',
                'name'          => 'Muhamad Gilang Ramadan',
                'email'         => 'muhamad.gilang.ramadan@email.com',
                'phone'         => '081234500013',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-04-05',
            ],
            [
                'member_number' => '202404013',
                'name'          => 'Muhamad Sarwan Al Barizy',
                'email'         => 'muhamad.sarwan.al.barizy@email.com',
                'phone'         => '081234500014',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-04-10',
            ],
            [
                'member_number' => '202404012',
                'name'          => 'Muhammad Apiransyah Ramdhani',
                'email'         => 'muhammad.apiransyah.ramdhani@email.com',
                'phone'         => '081234500015',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-04-15',
            ],
            [
                'member_number' => '202404021',
                'name'          => 'Reza Asriano Maulana',
                'email'         => 'reza.asriano.maulana@email.com',
                'phone'         => '081234500016',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-05-01',
            ],
            [
                'member_number' => '202404004',
                'name'          => 'Salman Alfaridzi',
                'email'         => 'salman.alfaridzi@email.com',
                'phone'         => '081234500017',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-05-05',
            ],
            [
                'member_number' => '202404022',
                'name'          => 'Satrio Ilham Syahputra',
                'email'         => 'satrio.ilham.syahputra@email.com',
                'phone'         => '081234500018',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-05-10',
            ],
            [
                'member_number' => '202404024',
                'name'          => 'Shevadina Aulia Rahma',
                'email'         => 'shevadina.aulia.rahma@email.com',
                'phone'         => '081234500019',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-06-01',
            ],
            [
                'member_number' => '202404014',
                'name'          => 'Siti Fatimatuzzahro',
                'email'         => 'siti.fatimatuzzahro@email.com',
                'phone'         => '081234500020',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-06-05',
            ],
            [
                'member_number' => '202404027',
                'name'          => 'Siti Romlah',
                'email'         => 'siti.romlah@email.com',
                'phone'         => '081234500021',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-06-10',
            ],
            [
                'member_number' => '202404023',
                'name'          => 'Subani Maulana',
                'email'         => 'subani.maulana@email.com',
                'phone'         => '081234500022',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-07-01',
            ],
            [
                'member_number' => '202404016',
                'name'          => 'Umar Maulana Sidiq',
                'email'         => 'umar.maulana.sidiq@email.com',
                'phone'         => '081234500023',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-07-05',
            ],
            [
                'member_number' => '202404019',
                'name'          => 'Zahra Ayu Trisna',
                'email'         => 'zahra.ayu.trisna@email.com',
                'phone'         => '081234500024',
                'address'       => 'Jl. Ipik Gandamanah No. X, Purwakarta',
                'join_date'     => '2024-07-10',
            ],
        ];

        foreach ($members as $index => $member) {
            $member['address'] = 'Jl. Ipik Gandamanah No. ' . ($index + 1) . ', Purwakarta';
            Member::create($member);
        }

        // Akun demo anggota yang bisa langsung login (member portal).
        $demoUser = User::updateOrCreate(
            ['email' => 'member@perpustakaan.com'],
            [
                'name'     => 'Anggota Demo',
                'username' => 'anggota_demo',
                'password' => Hash::make('password'),
                'role'     => 'member',
                'email_verified_at' => now(),
            ]
        );

        Member::updateOrCreate(
            ['email' => 'member@perpustakaan.com'],
            [
                'user_id'       => $demoUser->id,
                'member_number' => 'AGT-DEMO-001',
                'name'          => 'Anggota Demo',
                'phone'         => '081200000000',
                'address'       => 'Jl. Ipik Gandamanah No. 1, Purwakarta',
                'join_date'     => '2024-01-01',
            ]
        );
    }
}
