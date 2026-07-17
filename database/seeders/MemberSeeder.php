<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $year = now()->format('Y');

        $names = [
            'Al Amani Abas',
            'Dhafi Ebsan Yurizal',
            'Diva Oryza Sativa',
            'Dyan Putri Agustin',
            'Fikri Ramdani',
            'Helgi Nur Allamsyah',
            'Intan Sri Dayanti',
            'Jerry Sutisno',
            'Josh Winston Imanuel',
            'Keisya Febri Sabila',
            'Khaikal Iksanuddin',
            'Kirana Larasati Dewi',
            'Muhamad Gilang Ramadan',
            'Muhamad Sarwan Al Barizy',
            'Muhammad Apiransyah Ramdhani',
            'Reza Asriano Maulana',
            'Salman Alfaridzi',
            'Satrio Ilham Syahputra',
            'Shevadina Aulia Rahma',
            'Siti Fatimatuzzahro',
            'Siti Romlah',
            'Subani Maulana',
            'Umar Maulana Sidiq',
            'Zahra Ayu Trisna',
        ];

        foreach ($names as $index => $name) {
            $seq = str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            $memberNumber = "AGT-{$year}-{$seq}";
            $slug = strtolower(str_replace(' ', '_', $name));
            $email = str_replace(' ', '.', strtolower($name)) . '@gramediku.com';
            $phone = '0812' . str_pad($index + 1, 9, '0', STR_PAD_LEFT);

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'              => $name,
                    'username'          => $slug,
                    'password'          => Hash::make('password'),
                    'role'              => 'member',
                    'status'            => 'approved',
                    'email_verified_at' => now(),
                ]
            );

            Member::updateOrCreate(
                ['email' => $email],
                [
                    'user_id'       => $user->id,
                    'member_number' => $memberNumber,
                    'name'          => $name,
                    'phone'         => $phone,
                    'address'       => 'Jl. Ipik Gandamanah No. ' . ($index + 1) . ', Purwakarta',
                    'join_date'     => now()->subMonths(rand(1, 6))->subDays(rand(1, 28))->toDateString(),
                ]
            );
        }

        // Akun demo anggota
        $demoUser = User::updateOrCreate(
            ['email' => 'member@gramediku.com'],
            [
                'name'     => 'Anggota Demo',
                'username' => 'anggota_demo',
                'password' => Hash::make('password'),
                'role'     => 'member',
                'status'   => 'approved',
                'email_verified_at' => now(),
            ]
        );

        Member::updateOrCreate(
            ['email' => 'member@gramediku.com'],
            [
                'user_id'       => $demoUser->id,
                'member_number' => "AGT-{$year}-0000",
                'name'          => 'Anggota Demo',
                'phone'         => '081200000001',
                'address'       => 'Jl. Ipik Gandamanah No. 0, Purwakarta',
                'join_date'     => now()->subYear()->toDateString(),
            ]
        );
    }
}