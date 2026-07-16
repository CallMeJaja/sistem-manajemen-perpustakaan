<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect($this->homeFor(Auth::user()));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if ($user->isMember()) {
                if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
                    Auth::logout();
                    return back()
                        ->withErrors(['verification' => 'Email Anda belum diverifikasi. Silakan cek inbox atau kirim ulang email verifikasi.'])
                        ->onlyInput('email');
                }

                if ($user->isPending()) {
                    Auth::logout();
                    return back()
                        ->withErrors(['approval' => 'Akun Anda masih menunggu persetujuan admin. Email sudah terverifikasi, tunggu hingga admin menyetujui.'])
                        ->onlyInput('email');
                }

                if ($user->isRejected()) {
                    Auth::logout();
                    return back()
                        ->withErrors(['approval' => 'Akun Anda ditolak oleh admin. Silakan hubungi perpustakaan untuk informasi lebih lanjut.'])
                        ->onlyInput('email');
                }

                if (!$user->isApproved()) {
                    Auth::logout();
                    return back()
                        ->with('error', 'Terjadi kesalahan pada status akun Anda.')
                        ->onlyInput('email');
                }
            }

            $request->session()->regenerate();

            return redirect()->intended($this->homeFor(Auth::user()));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('catalog.index');
    }

    /**
     * Halaman tujuan setelah login sesuai peran pengguna.
     */
    private function homeFor(\App\Models\User $user): string
    {
        return $user->isAdmin()
            ? route('dashboard')
            : route('member.dashboard');
    }
}
