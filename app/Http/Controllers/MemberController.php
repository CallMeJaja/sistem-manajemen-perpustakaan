<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->paginate(10)->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        // Get the latest member number that is numeric
        $latest = Member::whereRaw('member_number REGEXP "^[0-9]+$"')
            ->orderBy('member_number', 'desc')
            ->first();

        $nextNumber = $latest ? (int)$latest->member_number + 1 : 202404001;

        return view('members.create', compact('nextNumber'));
    }

    public function store(StoreMemberRequest $request)
    {
        Member::create($request->only(['member_number', 'name', 'email', 'phone', 'address', 'join_date']));

        return redirect()->route('members.index')->with('success', 'Anggota berhasil didaftarkan.');
    }

    public function show(Member $member)
    {
        $borrowings = $member->borrowings()
            ->with(['book', 'return'])
            ->latest()
            ->paginate(10);

        return view('members.show', compact('member', 'borrowings'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->only(['member_number', 'name', 'email', 'phone', 'address', 'join_date']));

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->hasActiveBorrowing()) {
            return redirect()->route('members.index')
                ->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif.');
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * Admin menyetujui akun member yang masih pending.
     */
    public function approve(Member $member)
    {
        $user = $member->user;

        if (!$user) {
            return redirect()->route('members.index')
                ->with('error', 'Anggota ini belum memiliki akun pengguna.');
        }

        if ($user->isApproved()) {
            return redirect()->route('members.index')
                ->with('info', 'Akun anggota ini sudah disetujui sebelumnya.');
        }

        $user->update([
            'status'      => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('members.index')
            ->with('success', "Akun {$member->name} berhasil disetujui.");
    }

    /**
     * Admin menolak akun member yang masih pending.
     */
    public function reject(Member $member)
    {
        $user = $member->user;

        if (!$user) {
            return redirect()->route('members.index')
                ->with('error', 'Anggota ini belum memiliki akun pengguna.');
        }

        if ($user->isRejected()) {
            return redirect()->route('members.index')
                ->with('info', 'Akun anggota ini sudah ditolak sebelumnya.');
        }

        $user->update([
            'status'      => 'rejected',
            'approved_at' => null,
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('members.index')
            ->with('success', "Akun {$member->name} telah ditolak.");
    }
}
