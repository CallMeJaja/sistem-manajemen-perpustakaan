<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureMemberIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isMember()) {
            return $next($request);
        }

        if ($user->isPending()) {
            return redirect()->route('member.awaiting-approval');
        }

        if ($user->isRejected()) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda ditolak oleh admin. Silakan hubungi perpustakaan untuk informasi lebih lanjut.');
        }

        return $next($request);
    }
}