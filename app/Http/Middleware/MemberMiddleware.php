<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->isMember()) {
            // Admin yang nyasar ke area anggota diarahkan ke dashboard-nya;
            // tamu diarahkan untuk login.
            if (Auth::check() && Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Silakan masuk sebagai anggota untuk mengakses halaman ini.',
            ]);
        }

        return $next($request);
    }
}
