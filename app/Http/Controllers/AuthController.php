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
            $user = Auth::user();

            // Cek apakah email sudah terverifikasi (khusus member)
            if ($user->isMember() && $user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()
                    ->withErrors(['verification' => 'Email Anda belum diverifikasi. Silakan cek inbox atau kirim ulang email verifikasi.'])
                    ->onlyInput('email');
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
    private function homeFor($user): string
    {
        return $user->isAdmin()
            ? route('dashboard')
            : route('member.dashboard');
    }
}
