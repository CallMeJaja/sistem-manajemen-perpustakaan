<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            /** @var \App\Models\User $authUser */
            $authUser = Auth::user();
            return redirect($authUser->isAdmin() ? route('dashboard') : route('member.dashboard'));
        }

        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['name'],
                'username' => $this->generateUsername($data['email']),
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'role'     => 'member',
                'status'   => 'pending',
            ]);

            Member::create([
                'user_id'       => $user->id,
                'member_number' => $this->generateMemberNumber($user->id),
                'name'          => $data['name'],
                'email'         => $data['email'],
                'phone'         => $data['phone'] ?? null,
                'address'       => $data['address'] ?? null,
                'join_date'     => now()->toDateString(),
            ]);

            return $user;
        });

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk memverifikasi akun sebelum dapat login.');
    }

    /**
     * Buat username unik dari bagian depan email.
     */
    private function generateUsername(string $email): string
    {
        $base = Str::slug(Str::before($email, '@'), '_') ?: 'anggota';
        $username = $base;
        $suffix = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $suffix;
            $suffix++;
        }

        return $username;
    }

    /**
     * Nomor anggota otomatis, mis. AGT-2026-0007.
     */
    private function generateMemberNumber(int $userId): string
    {
        return 'AGT-' . now()->format('Y') . '-' . str_pad((string) $userId, 4, '0', STR_PAD_LEFT);
    }
}
