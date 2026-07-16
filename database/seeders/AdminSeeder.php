<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gramediku.com'],
            [
                'name'     => 'Administrator',
                'username' => 'admin',
                'email'    => 'admin@gramediku.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'status'   => 'approved',
                'email_verified_at' => now(),
            ]
        );
    }
}
