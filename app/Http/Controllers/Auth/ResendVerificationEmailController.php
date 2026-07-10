<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResendVerificationEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->intended(route('member.dashboard'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
