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
                'name'          => 'Rizky Pratama',
                'email'         => 'rizky.pratama@email.com',
                'phone'         => '081234567890',
                'address'       => 'Jl. Merdeka No. 12, Purwakarta',
                'join_date'     => '2024-01-15',
            ],
            [
                'member_number' => 'MBR-00002',
                'name'          => 'Siti Nurhaliza',
                'email'         => 'siti.nurhaliza@email.com',
                'phone'         => '082345678901',
                'address'       => 'Jl. Pahlawan No. 5, Purwakarta',
                'join_date'     => '2024-02-10',
            ],
            [
                'member_number' => 'MBR-00003',
                'name'          => 'Budi Santoso',
                'email'         => 'budi.santoso@email.com',
                'phone'         => '083456789012',
                'address'       => 'Jl. Diponegoro No. 33, Purwakarta',
                'join_date'     => '2024-03-05',
            ],
            [
                'member_number' => 'MBR-00004',
                'name'          => 'Dewi Rahayu',
                'email'         => 'dewi.rahayu@email.com',
                'phone'         => '084567890123',
                'address'       => 'Jl. Sudirman No. 7, Purwakarta',
                'join_date'     => '2024-04-20',
            ],
            [
                'member_number' => 'MBR-00005',
                'name'          => 'Ahmad Fauzi',
                'email'         => 'ahmad.fauzi@email.com',
                'phone'         => '085678901234',
                'address'       => 'Jl. Gatot Subroto No. 15, Purwakarta',
                'join_date'     => '2024-05-01',
            ],
            [
                'member_number' => 'MBR-00006',
                'name'          => 'Putri Maharani',
                'email'         => 'putri.maharani@email.com',
                'phone'         => '086789012345',
                'address'       => 'Jl. Ahmad Yani No. 22, Purwakarta',
                'join_date'     => '2024-06-15',
            ],
            [
                'member_number' => 'MBR-00007',
                'name'          => 'Dani Kurniawan',
                'email'         => 'dani.kurniawan@email.com',
                'phone'         => '087890123456',
                'address'       => 'Jl. Veteran No. 8, Purwakarta',
                'join_date'     => '2024-07-10',
            ],
            [
                'member_number' => 'MBR-00008',
                'name'          => 'Rina Fitriani',
                'email'         => 'rina.fitriani@email.com',
                'phone'         => '088901234567',
                'address'       => 'Jl. Pemuda No. 19, Purwakarta',
                'join_date'     => '2024-08-25',
            ],
            [
                'member_number' => 'MBR-00009',
                'name'          => 'Hendra Wijaya',
                'email'         => 'hendra.wijaya@email.com',
                'phone'         => '089012345678',
                'address'       => 'Jl. Kartini No. 3, Purwakarta',
                'join_date'     => '2024-09-05',
            ],
            [
                'member_number' => 'MBR-00010',
                'name'          => 'Yuni Astuti',
                'email'         => 'yuni.astuti@email.com',
                'phone'         => '081122334455',
                'address'       => 'Jl. Rajawali No. 11, Purwakarta',
                'join_date'     => '2024-10-18',
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
