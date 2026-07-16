<?php

namespace App\Http\Controllers;

use App\Models\BookReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberPortalController extends Controller
{
    public function dashboard()
    {
        $member = $this->member();

        $activeBorrowings = $member->borrowings()
            ->with('book')
            ->whereIn('status', ['pending', 'borrowed'])
            ->latest()
            ->get();

        $stats = [
            'pending'    => $member->borrowings()->where('status', 'pending')->count(),
            'borrowed'   => $member->borrowings()->where('status', 'borrowed')->count(),
            'returned'   => $member->borrowings()->where('status', 'returned')->count(),
            'total_fine' => BookReturn::whereHas(
                'borrowing',
                fn ($q) => $q->where('member_id', $member->id)
            )->sum('fine_amount'),
        ];

        return view('member.dashboard', compact('member', 'activeBorrowings', 'stats'));
    }

    public function borrowings(Request $request)
    {
        $member = $this->member();

        $query = $member->borrowings()->with(['book', 'return']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->latest()->paginate(10)->withQueryString();

        return view('member.borrowings', compact('member', 'borrowings'));
    }

    public function profile()
    {
        $member = $this->member();

        return view('member.profile', compact('member'));
    }

    public function updateProfile(Request $request)
    {
        $member = $this->member();

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        // Update name di member dan user sekaligus
        $member->update([
            'name'    => $data['name'],
            'phone'   => $data['phone'],
            'address' => $data['address'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update(['name' => $data['name']]);

        return redirect()->route('member.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ambil data anggota milik user yang sedang login.
     */
    private function member(): \App\Models\Member
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $member = $user->member;

        abort_unless($member, 403, 'Akun Anda belum terhubung dengan data anggota.');

        return $member;
    }
}
