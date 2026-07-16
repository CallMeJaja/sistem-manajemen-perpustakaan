<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ResendVerificationEmailController extends Controller
{
    public function create()
    {
        return view('auth.resend-verification');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('success', 'Jika email yang Anda masukkan terdaftar dan belum terverifikasi, kami telah mengirimkan tautan verifikasi baru.');
    }
}
