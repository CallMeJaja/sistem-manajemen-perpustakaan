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

        // Sorting
        $sortOptions = [
            'newest'       => ['column' => 'created_at', 'direction' => 'desc'],
            'oldest'       => ['column' => 'created_at', 'direction' => 'asc'],
            'name_az'      => ['column' => 'name', 'direction' => 'asc'],
            'name_za'      => ['column' => 'name', 'direction' => 'desc'],
            'member_number'=> ['column' => 'member_number', 'direction' => 'asc'],
        ];

        $sort = $request->input('sort', 'newest');
        if (isset($sortOptions[$sort])) {
            $query->orderBy($sortOptions[$sort]['column'], $sortOptions[$sort]['direction']);
        } else {
            $query->latest();
        }

        $members = $query->paginate(10)->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $year = now()->format('Y');
        $prefix = "AGT-{$year}-";

        $latest = Member::where('member_number', 'like', "{$prefix}%")
            ->orderByRaw("CAST(SUBSTRING_INDEX(member_number, '-', -1) AS UNSIGNED) DESC")
            ->first();

        if ($latest) {
            $lastSeq = (int) substr($latest->member_number, -4);
            $nextNumber = $prefix . str_pad($lastSeq + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = $prefix . '0001';
        }

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
     * API: Search members for autocomplete (multi-field: member_number, name, email, phone).
     */
    public function search(Request $request)
    {
        $q = $request->input('q', '');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $members = Member::where(function ($query) use ($q) {
            $query->where('member_number', 'like', "%{$q}%")
                  ->orWhere('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%");
        })->limit(10)->get(['id', 'member_number', 'name', 'email', 'phone']);

        return response()->json($members);
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
